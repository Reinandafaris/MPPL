@extends('layouts.layout')
@section('content')
    <form action="{{ route('akun.update', [$akun->id]) }}" method="POST">
        @csrf
        <input type="hidden" name="_method" value="PUT">
        <fieldset>
            <legend>Input Data Akun</legend>
            <div class="form-group row">
                <div class="col-md-5">
                    <label for="kode">Kode Akun</label>
                    <input id="kode" type="text" name="kode" class="form-control" value="{{ $akun->kdakun }}">
                </div>
                <div class="col-md-5">
                    <label for="nama">Nama Akun</label>
                    <input id="nama" type="text" name="nama" class="form-control"value="{{ $akun->nmakun }}">
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-5">
                    <label for="klasifikasi">Klasifikasi Akun</label>
                    <select id="klasifikasi" name="klasifikasi"class="form-control">
                        <option value="{{ $akun->klasifikasi }}">{{ $akun->klasifikasi }}</option>
                        <option value="">--Pilih Klasifikasi--</option>
                        <option value="Harta">Harta</option>
                        <option value="Kewajiban">Kewajiban</option>
                        <option value="Modal">Modal</option>
                        <option value="Pendapatan">Pendapatan</option>
                        <option value="Biaya Atas Pendapatan">Biaya Atas Pendapatan</option>
                        <option value="Pengeluaran Operasional">Pengeluaran Operasional</option>
                        <option value="Pendapatan Lain">Pendapatan Lain</option>
                    </select>
                </div>
                <div class="col-md-5">
                    <label for="no_hp">Sub Klasifikasi</label>
                    <input id="subklas" type="text" name="subklas" class="form-control"
                        value="{{ $akun->subklasifikasi }}">
                </div>
            </div>
            <div class="col-md-10">
                <input type="submit" class="btn btn-success btn-send" value="Update">
                <input type="Button" class="btn btn-primary btn-send" value="Kembali" onclick="history.go(-1)">
            </div>
            <hr>
        </fieldset>
    </form>
@endsection
