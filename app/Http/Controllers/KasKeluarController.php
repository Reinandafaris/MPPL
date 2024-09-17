<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Models\KasKeluar as ModelsKasKeluar;
use App\Models\Akun as ModelsAkun;
use App\Models\BukuBesar as ModelsBukuBesar;
use \App\Models\KasKeluarDet as ModelsKasKeluarDet;
use Illuminate\Support\Facades\DB as FacadesDB;

class KasKeluarController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    $kk = ModelsKasKeluar::All();
    return view('kaskeluar.kaskeluar', ['kaskeluar' => $kk]);
  }

  /**
   * Show the form for creating a new resource.
   */
  public function create()
  {
    $akun = ModelsAkun::All();
    $akun2 = ModelsAkun::paginate(3);
    $AWAL = 'KK';
    // karna array dimulai dari 0 maka kita tambah di awal data kosong
    // bisa juga mulai dari "1"=>"I"
    $bulanRomawi = array("", "I", "II", "III", "IV", "V", "VI", "VII", "VIII", "IX", "X", "XI", "XII");
    $noUrutAkhir = ModelsKasKeluar::max('id');
    $nomorawal = $noUrutAkhir + 1;
    $no = 1;
    if ($noUrutAkhir) {
      //echo "No urut surat di database : " . $noUrutAkhir;
      //echo "<br>";
      $nomor = sprintf($AWAL . '-' . "%05s", abs($noUrutAkhir + 1));
    } else {
      //echo "No urut surat di database : 0" ;
      //echo "<br>";
      $nomor = sprintf($AWAL . '-' . "%05s", $no);
    }
    return view('kaskeluar.input', ['nomor' => $nomor, 'nomorawal' => $nomorawal, 'akun' => $akun, 'akn' => $akun2]);
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(Request $request)
  {
    //Menyimpan Data Ke Tabel Kas_Keluar
    $save_kk = new ModelsKasKeluar;
    $save_kk->nokk = $request->get('notrans');
    $save_kk->tglkk = $request->get('tgltr');
    $save_kk->memokk = $request->get('memo');
    $save_kk->jmkk = $request->get('total');
    $save_kk->save();

    //Menyimpan Data Ke Tabel Buku_Besar
    $savebb = new ModelsBukuBesar;
    $savebb->idtrans = $request->get('idkk');
    $savebb->notran = $request->get('notrans');
    $savebb->tgltran = $request->get('tgltr');
    $savebb->catatan = $request->get('memo');
    $savebb->jmldb = 0;
    $savebb->jmlcr = $request->get('total');
    $savebb->save();

    //Menyimpan Data Ke Tabel Kas_Keluar_det
    for ($i = 1; $i <= 3; $i++) {
      $idkk = $request->get('idkk');
      $idakn = $request->get('idakun' . $i);
      $nil = $request->get('txt' . $i);
      if ($idakn == 0 or $nil == 0 or empty($idakn)) {
        return redirect()->route('kaskeluar.index');
      } else {
        $savedet = new ModelsKasKeluarDet;
        $savedet->idkk = $idkk;
        $savedet->idakun = $idakn;
        $savedet->nilcr = $nil;
        $savedet->save();
      }
    }
    return redirect()->route('kaskeluar.index');
  }

  /**
   * Display the specified resource.
   */
  public function show(string $id)
  {
    $kk = ModelsKasKeluar::findOrFail($id);
    //Query Mengambil Data Detail
    $detail = FacadesDB::select('SELECT akuns.kdakun, akuns.nmakun, kas_keluar_det.nilcr FROM kas_keluar_det, akuns WHERE akuns.id=kas_keluar_det.idakun AND idkk = :id', ['id' => $kk->id]);
    return view('kaskeluar.detail', ['kaskeluar' => $kk, 'kaskeluardet' => $detail]);
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit(string $id)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, string $id)
  {
    //
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(string $id)
  {
    $kk = ModelsKasKeluar::findOrFail($id);
    $kk->delete();
    FacadesDB::table('kas_keluar_det')->where('idkk', '=', $kk->id)->delete();
    FacadesDB::table('buku_besar')->where('notran', '=', $kk->nokk)->delete();
    return redirect()->route('kaskeluar.index');
  }
}
