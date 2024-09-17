<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Akun extends Model
{
  protected $table = "akuns";
  protected $fillable = [
    'id', 'kdakun', 'nmakun', 'klasifikasi', 'subklasifikasi', 'jmlcr'
  ];
}
