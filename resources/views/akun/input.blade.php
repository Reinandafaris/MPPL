@extends('layouts.layout')
@section('content')
    <form action="{{ route('akun.store') }}" method="POST">
        @csrf
        <fieldset>
            <legend>Input Data Akun</legend>
            <div class="form-group row">
                <div class="col-md-5">
                    <label for="kode">Kode Akun</label>
                    <input id="kode" type="text" name="kode" class="form-control">
                </div>
                <div class="col-md-5">
                    <label for="nama">Nama Akun</label>
                    <input id="nama" type="text" name="nama" class="form-control">
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-5">
                    <label for="klasifikasi">Klasifikasi Akun</label>
                    <select id="klasifikasi" name="klasifikasi"class="form-control">
                        <option value="">--Pilih Klasifikasi--</option>
                        <option value="Harta">Harta</option>
                        <option value="Kewajiban">Kewajiban</option>
                        <option value="Modal">Modal</option>
                        <option value="Beban">Beban</option>
                        <option value="Pendapatan">Pendapatan</option>
                        <option value="Biaya Atas Pendapatan">Biaya Atas Pendapatan</optio n>
                        <option value="Pengeluaran Operasional">Pengeluaran Operasional</option>
                        <option value="Pendapatan Lain">Pendapatan Lain</option>
                    </select>
                </div>
                <div class="col-md-5">
                    <label for="no_hp">Sub Klasifikasi</label>
                    <input id="subklas" type="text" name="subklas" class="form-control">
                </div>
            </div>
            <div class="col-md-10">
                <input type="submit" class="btn btn-success btn-send" value="Simpan">
                <input type="Button" class="btn btn-primary btn-send" value="Kembali" onclick="history.go(-1)">
            </div>
            <hr>
        </fieldset>
    </form>
@endsection
