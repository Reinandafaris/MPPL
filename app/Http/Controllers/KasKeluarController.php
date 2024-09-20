<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Models\KasKeluar as ModelsKasKeluar;
use App\Models\Akun as ModelsAkun;
use App\Models\BukuBesar as ModelsBukuBesar;
use \App\Models\KasKeluarDet as ModelsKasKeluarDet;
use Illuminate\Support\Facades\DB as FacadesDB;
use Illuminate\Support\Facades\Storage;

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
    $AWAL = 'RND';
    // karna array dimulai dari 0 maka kita tambah di awal data kosong
    // bisa juga mulai dari "1"=>"I"
    $bulanRomawi = array("", "I", "II", "III", "IV", "V", "VI", "VII", "VIII", "IX", "X", "XI", "XII");
    $noUrutAkhir = ModelsKasKeluar::max('id');
    $nomorawal = $noUrutAkhir + 1;
    $no = 1;
    if ($noUrutAkhir) {
      //echo "No urut surat di database : " . $noUrutAkhir;
      //echo "<br>";
      $nomor = sprintf($AWAL . '-' . "%03s", abs($noUrutAkhir + 1));
    } else {
      //echo "No urut surat di database : 0" ;
      //echo "<br>";
      $nomor = sprintf($AWAL . '-' . "%03s", $no);
    }
    return view('kaskeluar.input', ['nomor' => $nomor, 'nomorawal' => $nomorawal, 'akun' => $akun, 'akn' => $akun2]);
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(Request $request)
  {

    // Validasi input, termasuk validasi untuk gambar
    $request->validate([
      'notrans' => 'required',
      'tgltr' => 'required|date',
      'memo' => 'required',
      'tmptbeli' => 'required',
      'image_path' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
      'total' => 'required|numeric',
    ]);

    // Inisialisasi variabel untuk menyimpan path gambar
    $imagePath = null;

    // Mengecek apakah ada file gambar yang diupload
    if ($request->hasFile('image_path')) {
      // Menyimpan gambar ke folder 'public/images' dan mendapatkan path-nya
      $imagePath = $request->file('image_path')->store('images', 'public');
    }

    //Menyimpan Data Ke Tabel Kas_Keluar
    $save_kk = new ModelsKasKeluar;
    $save_kk->nokk = $request->get('notrans');
    $save_kk->tglkk = $request->get('tgltr');
    $save_kk->memokk = $request->get('memo');
    $save_kk->tmptbeli = $request->get('tmptbeli');
    $save_kk->image_path = $imagePath;  // Simpan path gambar ke database
    $save_kk->jmkk = $request->get('total');
    $save_kk->save();

    //Menyimpan Data Ke Tabel Buku_Besar
    $savebb = new ModelsBukuBesar;
    $savebb->idtrans = $request->get('idkk');
    $savebb->notran = $request->get('notrans');
    $savebb->tgltran = $request->get('tgltr');
    $savebb->catatan = $request->get('memo');
    $savebb->tmptbeli = $request->get('tmptbeli');
    $savebb->jmldb = 0;
    $savebb->jmlcr = $request->get('total');
    $savebb->save();

    // Menggunakan ID kas_masuk yang baru disimpan
    $idkk = $save_kk->id;  // Ambil ID kas_masuk yang baru

    //Menyimpan Data Ke Tabel Kas_Keluar_det
    for ($i = 1; $i <= 3; $i++) {
      $idakun = $request->get('idakun' . $i);
      $nil = $request->get('txt' . $i);
      if ($idakun == 0 or $nil == 0 or empty($idakun)) {
        return redirect()->route('kaskeluar.index');
      } else {
        $savedet = new ModelsKasKeluarDet;
        $savedet->idkk = $idkk; // Gunakan ID kas_keluar
        $savedet->idakun = $idakun;
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
    // Cari kas_keluar berdasarkan ID
    $kasKeluar = ModelsKasKeluar::findOrFail($id);

    // Ambil juga data yang terkait seperti buku_besar dan kas_keluar_det
    $bukuBesar = ModelsBukuBesar::where('idtrans', $kasKeluar->id)->first();
    $kasKeluarDet = ModelsKasKeluarDet::where('idkk', $kasKeluar->id)->get();

    // Ambil semua akun untuk pilihan dalam form
    $akun = ModelsAkun::all();
    $akun2 = ModelsAkun::paginate(3);

    // Kembalikan view edit dengan data yang sudah ada
    return view('kaskeluar.edit', ['kaskeluar' => $kasKeluar, 'bukubesar' => $bukuBesar, 'kaskeluardet' => $kasKeluarDet, 'akun' => $akun, 'akn' => $akun2]);
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, string $id)
  {
    // Validasi input, termasuk validasi untuk gambar
    $request->validate([
      'notrans' => 'required',
      'tgltr' => 'required|date',
      'memo' => 'required',
      'tmptbeli' => 'required',
      'image_path' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
      'total' => 'required|numeric',
    ]);

    // Cari kas_keluar berdasarkan ID yang diberikan
    $kasKeluar = ModelsKasKeluar::findOrFail($id);

    // Inisialisasi variabel untuk menyimpan path gambar
    $imagePath = $kasKeluar->image_path; // Gunakan path gambar yang ada

    // Mengecek apakah ada file gambar baru yang diupload
    if ($request->hasFile('image_path')) {
      // Jika ada gambar lama, hapus gambar yang lama
      if ($kasKeluar->image_path) {
        Storage::disk('public')->delete($kasKeluar->image_path);
      }
      // Simpan gambar yang baru
      $imagePath = $request->file('image_path')->store('images', 'public');
    }

    // Update data di tabel kas_keluar
    $kasKeluar->nokk = $request->get('notrans');
    $kasKeluar->tglkk = $request->get('tgltr');
    $kasKeluar->memokk = $request->get('memo');
    $kasKeluar->tmptbeli = $request->get('tmptbeli');
    $kasKeluar->image_path = $imagePath;
    $kasKeluar->jmkk = $request->get('total');
    $kasKeluar->save();

    // Update data di tabel buku_besar
    $bukuBesar = ModelsBukuBesar::where('idtrans', $kasKeluar->id)->first();
    if ($bukuBesar) {
      $bukuBesar->notran = $request->get('notrans');
      $bukuBesar->tgltran = $request->get('tgltr');
      $bukuBesar->catatan = $request->get('memo');
      $bukuBesar->tmptbeli = $request->get('tmptbeli');
      $bukuBesar->jmldb = 0;
      $bukuBesar->jmlcr = $request->get('total');
      $bukuBesar->save();
    }

    // Menggunakan ID kas_Keluar
    $idkk = $kasKeluar->id;

    // Hapus data lama di kas_Keluar_det dan simpan data baru
    ModelsKasKeluarDet::where('idkk', $idkk)->delete();

    // Menyimpan detail kas_Keluar_det yang baru
    for ($i = 1; $i <= 3; $i++) {
      $idakun = $request->get('idakun' . $i);
      $nil = $request->get('txt' . $i);
      if ($idakun == 0 or $nil == 0 or empty($idakun)) {
        return redirect()->route('kaskeluar.index');
      } else {
        $savedet = new ModelsKasKeluarDet;
        $savedet->idkk = $idkk;
        $savedet->idakun = $idakun;
        $savedet->nilcr = $nil;
        $savedet->save();
      }
    }

    return redirect()->route('kaskeluar.index')->with('success', 'Kas Keluar berhasil diupdate');
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(string $id)
  {
    // Temukan data KasKeluar berdasarkan id
    $kk = ModelsKasKeluar::findOrFail($id);

    // Hapus gambar jika ada
    if ($kk->image_path) {
      Storage::delete('public/' . $kk->image_path); // Hapus file gambar di folder public
    }

    // Hapus data dari tabel kas_keluar_det dan buku_besar yang terkait
    FacadesDB::table('kas_keluar_det')->where('idkk', '=', $kk->id)->delete();
    FacadesDB::table('buku_besar')->where('notran', '=', $kk->nokk)->delete();

    // Hapus data dari tabel kas_keluar
    $kk->delete();

    // Redirect ke route index setelah data dihapus
    return redirect()->route('kaskeluar.index');
  }
}
