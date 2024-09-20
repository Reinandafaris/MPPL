<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Models\KasMasuk as ModelsKasMasuk;
use App\Models\Akun as ModelsAkun;
use App\Models\BukuBesar as ModelsBukuBesar;
use \App\Models\KasMasukDet as ModelsKasMasukDet;
use Illuminate\Support\Facades\DB as FacadesDB;
use Illuminate\Support\Facades\Storage;

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
    $AWAL = 'RND';
    // karna array dimulai dari 0 maka kita tambah di awal data kosong
    // bisa juga mulai dari "1"=>"I"
    $bulanRomawi = array("", "I", "II", "III", "IV", "V", "VI", "VII", "VIII", "IX", "X", "XI", "XII");
    $noUrutAkhir = ModelsKasMasuk::max('id');
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
    return view('kasmasuk.input', ['nomor' => $nomor, 'nomorawal' => $nomorawal, 'akun' => $akun, 'akn' => $akun2]);
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

    //Menyimpan Data Ke Tabel Kas_Masuk
    $save_km = new ModelsKasMasuk;
    $save_km->nokm = $request->get('notrans');
    $save_km->tglkm = $request->get('tgltr');
    $save_km->memokm = $request->get('memo');
    $save_km->tmptbeli = $request->get('tmptbeli');
    $save_km->image_path = $imagePath;  // Simpan path gambar ke database
    $save_km->jmkmd = $request->get('total');
    $save_km->save();

    //Menyimpan Data Ke Tabel Buku_Besar
    $savebb = new ModelsBukuBesar;
    $savebb->idtrans = $request->get('idkm');
    $savebb->notran = $request->get('notrans');
    $savebb->tgltran = $request->get('tgltr');
    $savebb->catatan = $request->get('memo');
    $savebb->tmptbeli = $request->get('tmptbeli');
    $savebb->jmldb = $request->get('total');
    $savebb->jmlcr = 0;
    $savebb->save();

    // Menggunakan ID kas_masuk yang baru disimpan
    $idkm = $save_km->id;  // Ambil ID kas_masuk yang baru

    // Menyimpan detail kas_masuk_det
    for ($i = 1; $i <= 3; $i++) {
      $idakun = $request->get('idakun' . $i);
      $nil = $request->get('txt' . $i);
      if ($idakun == 0 or $nil == 0 or empty($idakun)) {
        return redirect()->route('kasmasuk.index');
      } else {
        $savedet = new ModelsKasMasukDet;
        $savedet->idkm = $idkm;  // Gunakan ID kas_masuk
        $savedet->idakun = $idakun;
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
    // Cari kas_masuk berdasarkan ID
    $kasMasuk = ModelsKasMasuk::findOrFail($id);

    // Ambil juga data yang terkait seperti buku_besar dan kas_masuk_det
    $bukuBesar = ModelsBukuBesar::where('idtrans', $kasMasuk->id)->first();
    $kasMasukDet = ModelsKasMasukDet::where('idkm', $kasMasuk->id)->get();

    // Ambil semua akun untuk pilihan dalam form
    $akun = ModelsAkun::all();
    $akun2 = ModelsAkun::paginate(3);

    // Kembalikan view edit dengan data yang sudah ada
    return view('kasmasuk.edit', ['kasmasuk' => $kasMasuk, 'bukubesar' => $bukuBesar, 'kasmasukdet' => $kasMasukDet, 'akun' => $akun, 'akn' => $akun2]);
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

    // Cari kas_masuk berdasarkan ID yang diberikan
    $kasMasuk = ModelsKasMasuk::findOrFail($id);

    // Inisialisasi variabel untuk menyimpan path gambar
    $imagePath = $kasMasuk->image_path; // Gunakan path gambar yang ada

    // Mengecek apakah ada file gambar baru yang diupload
    if ($request->hasFile('image_path')) {
      // Jika ada gambar lama, hapus gambar yang lama
      if ($kasMasuk->image_path) {
        Storage::disk('public')->delete($kasMasuk->image_path);
      }
      // Simpan gambar yang baru
      $imagePath = $request->file('image_path')->store('images', 'public');
    }

    // Update data di tabel kas_masuk
    $kasMasuk->nokm = $request->get('notrans');
    $kasMasuk->tglkm = $request->get('tgltr');
    $kasMasuk->memokm = $request->get('memo');
    $kasMasuk->tmptbeli = $request->get('tmptbeli');
    $kasMasuk->image_path = $imagePath;
    $kasMasuk->jmkmd = $request->get('total');
    $kasMasuk->save();

    // Update data di tabel buku_besar
    $bukuBesar = ModelsBukuBesar::where('idtrans', $kasMasuk->id)->first();
    if ($bukuBesar) {
      $bukuBesar->notran = $request->get('notrans');
      $bukuBesar->tgltran = $request->get('tgltr');
      $bukuBesar->catatan = $request->get('memo');
      $bukuBesar->tmptbeli = $request->get('tmptbeli');
      $bukuBesar->jmldb = $request->get('total');
      $bukuBesar->jmlcr = 0;
      $bukuBesar->save();
    }

    // Menggunakan ID kas_masuk
    $idkm = $kasMasuk->id;

    // Hapus data lama di kas_masuk_det dan simpan data baru
    ModelsKasMasukDet::where('idkm', $idkm)->delete();

    // Menyimpan detail kas_masuk_det yang baru
    for ($i = 1; $i <= 3; $i++) {
      $idakun = $request->get('idakun' . $i);
      $nil = $request->get('txt' . $i);
      if ($idakun == 0 or $nil == 0 or empty($idakun)) {
        return redirect()->route('kasmasuk.index');
      } else {
        $savedet = new ModelsKasMasukDet;
        $savedet->idkm = $idkm;
        $savedet->idakun = $idakun;
        $savedet->nildb = $nil;
        $savedet->save();
      }
    }

    return redirect()->route('kasmasuk.index')->with('success', 'Kas Masuk berhasil diupdate');
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(string $id)
  {
    // Temukan data KasMasuk berdasarkan id
    $km = ModelsKasMasuk::findOrFail($id);

    // Hapus gambar jika ada
    if ($km->image_path) {
      Storage::delete('public/' . $km->image_path); // Hapus file gambar di folder public
    }

    // Hapus data dari tabel kas_masuk_det dan buku_besar yang terkait
    FacadesDB::table('kas_masuk_det')->where('idkm', '=', $km->id)->delete();
    FacadesDB::table('buku_besar')->where('notran', '=', $km->nokm)->delete();

    // Hapus data dari tabel kas_masuk
    $km->delete();

    // Redirect ke route index setelah data dihapus
    return redirect()->route('kasmasuk.index');
  }
}
