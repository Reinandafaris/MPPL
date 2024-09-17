@extends('layouts.layout')
@section('content')
    <form action="" method="POST">
        @csrf
        <fieldset>
            <div class="form-group row">
                <div class="col-md-5">
                    Nomor Transaksi<input type="text" class="form-control" value="{{ $kasmasuk->nokm }}" disabled>
                </div>
                <div class="col-md-5">
                    Tanggal transaksi<input type="date" value="{{ $kasmasuk->tglkm }}" class="form-control" disabled>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-10">
                    Memo
                    <textarea type="text" class="form-control" disabled>{{ $kasmasuk->memokm }}</textarea>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-10">Total Pengeluaran
                    <input type="text" class="form-control" value="{{ $kasmasuk->jmkmd }}" disabled>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-10">Data Akun Yang Digunakan
                    <table class="table table-bordered" width="100%" cellspacing="0">
                        <thead>
                            <tr align="center">
                                <td width="20%">Id Akun</td>
                                <td width="20%">Kode Akun</td>
                                <td width="30%">Jumlah Debit</td>
                            </tr>
                        <tbody>
                            @foreach ($kasmasukdet as $detail)
                                <tr align="center">
                                    <td>{{ $detail->kdakun }}</td>
                                    <td>{{ $detail->nmakun }}</td>
                                    <td>{{ $detail->nildb }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                        </thead>
                    </table>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-10">
                    <input type="Button" class="btn btn-primary btn-send" value="Kembali" onclick="history.go(-1)">
                </div>
            </div>
            <hr>
        </fieldset>
    </form>
@endsection
