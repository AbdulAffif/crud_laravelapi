<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barangs extends Model
{
    use HasFactory;

    protected $fillable = ['kode_sku','nama_barang','foto_barang','qty','harga_satuan'];
}
