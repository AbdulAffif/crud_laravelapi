<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Barangs;
use Illuminate\Support\Facades\Auth;
use Validator;

class BarangController extends Controller
{
    public $successStatus = 200;

    public function simpan(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'kode_sku' => 'required',
            'nama_barang' => 'required',
            'foto_barang' => 'required|image:jpeg,png,jpg,gif,svg|max:2048',
            'qty' => 'required',
            'harga_satuan' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()], 401);            
        }
        $uploadFolder = 'barangs';
        $image = $request->file('foto_barang');
        $image_uploaded_path = $image->store($uploadFolder, 'public');
        $input = $request->all();
        $input['foto_barang'] = basename($image_uploaded_path);
        $user = Auth::user();

        $barangs = Barangs::create($input);

        if($barangs)
        {
            return response()->json(['success'=>'simpan Berhasil'], $this->successStatus);
        }else{
            return response()->json(['error'=>'Gagal Simpan'], 401);
        }
        
    }
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'kode_sku' => 'required',
            'nama_barang' => 'required',
            'foto_barang' => 'required|image:jpeg,png,jpg,gif,svg|max:2048',
            'qty' => 'required',
            'harga_satuan' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()], 401);            
        }
        $user = Auth::user();

        $uploadFolder = 'barangs';
        $image = $request->file('foto_barang');
        $image_uploaded_path = $image->store($uploadFolder, 'public');

        $barangs = Barangs::where('id',$request->id)->update([
            'kode_sku' => $request->kode_sku,
            'nama_barang' => $request->nama_barang,
            'foto_barang' => basename($image_uploaded_path),
            'qty' => $request->qty,
            'harga_satuan' => $request->harga_satuan
        ]);
        
        if($barangs)
        {
            return response()->json(['success'=>'Update Berhasil'], $this->successStatus);
        }else{
            return response()->json(['error'=>'Gagal Simpan'], 401);
        }
    }
    public function delete($id)
    {
        $user = Auth::user();
        $barangs = Barangs::where('id',$id)->delete();
        
        if($barangs)
        {
            return response()->json(['success'=>'Delete Berhasil'], $this->successStatus);
        }else{
            return response()->json(['error'=>'Gagal Simpan'], 401);
        }
    }
    public function find($id)
    {
        $user = Auth::user();
        $barangs = Barangs::where('id',$id)->get();
        
        if($barangs)
        {
            return response()->json(['data'=>$barangs], $this->successStatus);
        }else{
            return response()->json(['error'=>'Not Found'], 404);
        }
    }
    public function cari(Request $request)
    {
        $user = Auth::user();
        if($request->param=='id')
        {
            $barangs = Barangs::where('id',$request->keyword)->get();
            return response()->json(['data'=>$barangs], $this->successStatus);

        }elseif($request->param=='kode_sku')
        {
            $barangs = Barangs::where('kode_sku',$request->keyword)->get();
            return response()->json(['data'=>$barangs], $this->successStatus);

        }elseif($request->param=='nama_barang')
        {
            $barangs = Barangs::where('nama_barang','LIKE','%'.$request->keyword.'%')->get();
            return response()->json(['data'=>$barangs], $this->successStatus);

        }else{
            
            return response()->json(['error'=>'Not Found'], 404);
        }
        
    }
    
}
