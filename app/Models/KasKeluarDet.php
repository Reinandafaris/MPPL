<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KasKeluarDet extends Model
{
  protected $table = "kas_keluar_det";
  protected $fillable = [
    'idkk', 'idakun', 'nilcr'
  ];
}
