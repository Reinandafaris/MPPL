<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BukuBesar as ModelsBukuBesar;

class BukubesarController extends Controller
{
  public function index()
  {
    $bb = ModelsBukuBesar::orderBy('created_at', 'DESC')->get();
    return view('bukubesar.bukubesar', ['bukubesar' => $bb]);
  }
}
