<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BukuBesar extends Model
{
  protected $table = "buku_besar";
  protected $fillable = [
    'id', 'idtrans', 'notran', 'tgltran', 'catatan', 'jmldb', 'jmlcr'
  ];
}
