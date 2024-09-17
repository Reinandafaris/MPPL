<?php

namespace App\Http\Controllers;

use App\Models\Akun as ModelsAkun;
use Illuminate\Http\Request;

class AkunController extends Controller
{
  public function index()
  {
    $akun = ModelsAkun::All();
    return view('akun.akun', ['akun' => $akun]);
  }

  /**
   * Show the form for creating a new resource.
   */
  public function create()
  {
    return view('akun.input');
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(Request $request)
  {
    //Menyimpan data kedalam tabel
    $save_akun = new ModelsAkun;
    $save_akun->kdakun = $request->get('kode');
    $save_akun->nmakun = $request->get('nama');
    $save_akun->klasifikasi = $request->get('klasifikasi');
    $save_akun->subklasifikasi = $request->get('subklas');
    $save_akun->save();
    return redirect()->route('akun.index');
  }

  /**
   * Display the specified resource.
   */
  public function show(string $id)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit(string $id)
  {
    $akun_edit = ModelsAkun::findOrFail($id);
    return view('akun.edit', ['akun' => $akun_edit]);
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, string $id)
  {
    $akun = ModelsAkun::findOrFail($id);
    $akun->kdakun = $request->get('kode');
    $akun->nmakun = $request->get('nama');
    $akun->klasifikasi = $request->get('klasifikasi');
    $akun->subklasifikasi = $request->get('subklas');
    $akun->save();
    return redirect()->route('akun.index');
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(string $id)
  {
    $akun = ModelsAkun::findOrFail($id);
    $akun->delete();
    return redirect()->route('akun.index');
  }
}
