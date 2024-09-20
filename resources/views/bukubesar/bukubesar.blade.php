@extends('layouts.layout')
@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Data Buku Besar</h1>
</div>
<hr>
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr align="center">
                        <th width="20%">No Nota</th>
                        <th width="15%">Tgl Transaksi</th>
                        <th width="25%">Catatan</th>
                        <th width="15%">Tempat Beli</th>
                        <th width="15%">Debet</th>
                        <th width="15%">Kredit</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($bukubesar as $bb)
                    <tr align="center">
                        <td>{{ $bb->notran }}</td>
                        <td>{{ $bb->tgltran }}</td>
                        <td>{{ $bb->catatan }}</td>
                        <td>{{ $bb->tmptbeli }}</td>
                        <td>{{ $bb->jmldb }}</td>
                        <td>{{ $bb->jmlcr }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection