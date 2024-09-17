<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KasMasukDet extends Model
{
  protected $table = "kas_masuk_det";
  protected $fillable = [
    'idkm', 'idakun', 'nildb'
  ];
}
