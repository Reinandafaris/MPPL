@extends('layouts.layout')
@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Data Kas Keluar</h1>
</div>
<hr>
<div class="card-header py-3" align="right">
    <a href="{{ route('kaskeluar.create') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
        <i class="fas fa-plus fa-sm text-white-50"></i> Tambah </a>
</div>
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr align="center">
                        <th width="15%">No Nota</th>
                        <th width="15%">Tgl Transaksi</th>
                        <th width="25%">Memo</th>
                        <th width="15%">Tempat Beli</th>
                        <th width="15%">Jumlah</th>
                        <th width="15%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($kaskeluar as $kk)
                    <tr>
                        <td>{{ $kk->nokk }}</td>
                        <td>{{ $kk->tglkk }}</td>
                        <td>{{ $kk->memokk }}</td>
                        <td>{{ $kk->tmptbeli }}</td>
                        <td>{{ $kk->jmkk }}</td>
                        <td align="center">
                            <a href="{{ route('kaskeluar.show', [$kk->id]) }}"
                                class="d-none d-sm-inline-block btn btn-sm btn-dark shadow-sm">
                                <i class="fas fa-edit fa-sm text-white-50"></i> Detail
                            </a>
                            <a href="/kaskeluar/hapus/{{ $kk->id }}"
                                onclick="return confirm('Yakin Ingin menghapus data?')"
                                class="d-none d-sm-inline-block btn btn-sm btn-danger shadow-sm">
                                <i class="fas fa-trash-alt fa-sm text-white-50"></i> Hapus
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection