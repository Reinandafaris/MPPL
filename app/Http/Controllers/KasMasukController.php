<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Models\KasMasuk as ModelsKasMasuk;
use App\Models\Akun as ModelsAkun;
use App\Models\BukuBesar as ModelsBukuBesar;
use \App\Models\KasMasukDet as ModelsKasMasukDet;
use Illuminate\Support\Facades\DB as FacadesDB;

class KasMasukController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    $km = ModelsKasMasuk::All();
    return view('kasmasuk.kasmasuk', ['kasmasuk' => $km]);
  }

  /**
   * Show the form for creating a new resource.
   */
  public function create()
  {
    $akun = ModelsAkun::All();
    $akun2 = ModelsAkun::paginate(3);
    $AWAL = 'KM';
    // karna array dimulai dari 0 maka kita tambah di awal data kosong
    // bisa juga mulai dari "1"=>"I"
    $bulanRomawi = array("", "I", "II", "III", "IV", "V", "VI", "VII", "VIII", "IX", "X", "XI", "XII");
    $noUrutAkhir = ModelsKasMasuk::max('id');
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
    return view('kasmasuk.input', ['nomor' => $nomor, 'nomorawal' => $nomorawal, 'akun' => $akun, 'akn' => $akun2]);
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(Request $request)
  {
    //Menyimpan Data Ke Tabel Kas_Masuk
    $save_km = new ModelsKasMasuk;
    $save_km->nokm = $request->get('notrans');
    $save_km->tglkm = $request->get('tgltr');
    $save_km->memokm = $request->get('memo');
    $save_km->jmkmd = $request->get('total');
    $save_km->save();

    //Menyimpan Data Ke Tabel Buku_Besar
    $savebb = new ModelsBukuBesar;
    $savebb->idtrans = $request->get('idkm');
    $savebb->notran = $request->get('notrans');
    $savebb->tgltran = $request->get('tgltr');
    $savebb->catatan = $request->get('memo');
    $savebb->jmldb = $request->get('total');
    $savebb->jmlcr = 0;
    $savebb->save();

    //Menyimpan Data Ke Tabel Kas_Masuk_det
    for ($i = 1; $i <= 3; $i++) {
      $idkm = $request->get('idkm');
      $idakn = $request->get('idakun' . $i);
      $nil = $request->get('txt' . $i);
      if ($idakn == 0 or $nil == 0 or empty($idakn)) {
        return redirect()->route('kasmasuk.index');
      } else {
        $savedet = new ModelsKasMasukDet;
        $savedet->idkm = $idkm;
        $savedet->idakun = $idakn;
        $savedet->nildb = $nil;
        $savedet->save();
      }
    }
    return redirect()->route('kasmasuk.index');
  }

  /**
   * Display the specified resource.
   */
  public function show(string $id)
  {
    $km = ModelsKasMasuk::findOrFail($id);
    //Query Mengambil Data Detail
    $detail = FacadesDB::select('SELECT akuns.kdakun, akuns.nmakun, kas_masuk_det.nildb FROM kas_masuk_det, akuns WHERE akuns.id=kas_masuk_det.idakun AND idkm = :id', ['id' => $km->id]);
    return view('kasmasuk.detail', ['kasmasuk' => $km, 'kasmasukdet' => $detail]);
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
    $km = ModelsKasMasuk::findOrFail($id);
    $km->delete();
    FacadesDB::table('kas_masuk_det')->where('idkm', '=', $km->id)->delete();
    FacadesDB::table('buku_besar')->where('notran', '=', $km->nokm)->delete();
    return redirect()->route('kasmasuk.index');
  }
}
