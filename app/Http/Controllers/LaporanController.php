<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \Barryvdh\DomPDF\Facade\Pdf as PDF;
use Illuminate\Support\Facades\DB as DB;

class LaporanController extends Controller
{
  public function index()
  {
    return view('laporan');
  }
  public function show(Request $request)
  {
    $periode = $request->get('periode');
    $jenis = $request->get('jenis');
    if ($jenis == 'bukubesar') {
      if ($periode == 'All') {
        $bb = \App\Models\BukuBesar::All();
        $pdf = PDF::loadview('bukubesar.bukubesar_pdf', ['bukubesar' => $bb])->setPaper('A4', 'landscape');
        return $pdf->stream();
      } elseif ($periode == 'periode') {
        $tglawal = $request->get('tglawal');
        $tglakhir = $request->get('tglakhir');
        $bb = DB::table('buku_besar')
          ->whereBetween('tgltran', [$tglawal, $tglakhir])
          ->orderby('tgltran', 'ASC')
          ->get();
        $pdf = PDF::loadview('bukubesar.bukubesar_pdf', ['bukubesar' => $bb])->setPaper('A4', 'landscape');
        return $pdf->stream();
      }
    } elseif ($jenis == 'kaskeluar') {
      if ($periode == 'All') {
        $data = \App\Models\KasKeluar::All();
        $pdf = PDF::loadview('kaskeluar.kaskeluar_pdf', ['kaskeluar' => $data])->setPaper('A4', 'landscape');
        return $pdf->stream();
      } elseif ($periode == 'periode') {
        $tglawal = $request->get('tglawal');
        $tglakhir = $request->get('tglakhir');
        $data = DB::table('kas_keluar')
          ->whereBetween('tglkk', [$tglawal, $tglakhir])
          ->orderby('tglkk', 'ASC')
          ->get();
        $pdf = PDF::loadview('kaskeluar.kaskeluar_pdf', ['kaskeluar' => $data])->setPaper('A4', 'landscape');
        return $pdf->stream();
      }
    } elseif ($jenis == 'kasmasuk') {
      if ($periode == 'All') {
        $data = \App\Models\KasMasuk::All();
        $pdf = PDF::loadview('kasmasuk.kasmasuk_pdf', ['kasmasuk' => $data])->setPaper('A4', 'landscape');
        return $pdf->stream();
      } elseif ($periode == 'periode') {
        $tglawal = $request->get('tglawal');
        $tglakhir = $request->get('tglakhir');
        $data = DB::table('kas_masuk')
          ->whereBetween('tglkm', [$tglawal, $tglakhir])
          ->orderby('tglkm', 'ASC')
          ->get();
        $pdf = $pdf = PDF::loadview('kasmasuk.kasmasuk_pdf', ['kasmasuk' => $data])->setPaper('A4', 'landscape');
        return $pdf->stream();
      }
    }
  }
}
