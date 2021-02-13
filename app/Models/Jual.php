<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jual extends Model
{
    use HasFactory;
    protected $table = 'barang_jual';
    protected $primaryKey = 'id_barang';
    public $timestamps = false;
}
