<!DOCTYPE html>
<html>

<head>
    <title>Laporan Buku Besar</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <style type="text/css">
        table tr td,
        table tr th {
            font-size: 10pt;
        }
    </style>
</head>

<body>
    <table class="table table-bordered" width="100%" align="center">
        <tr align="center">
            <td>
                <h2>Laporan Buku Besar<br>Toko Bread and Butter</h2>
                <hr>
            </td>
        </tr>
    </table>
    <table class="table table-bordered" width="100%" align="center">
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="10%">No Nota</th>
                <th width="15%">Tgl Transaksi</th>
                <th width="25%">Catatan</th>
                <th width="15%">Tempat Beli</th>
                <th width="15%">Debet</th>
                <th width="15%">Kredit</th>
            </tr>
        </thead>
        <tbody>
            @php $i=1 @endphp
            @foreach ($bukubesar as $bb)
            <tr align="center">
                <td>{{ $i++ }}</td>
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
    <div align="right">
        <h6>Tanda Tangan</h6><br><br>
        @if (Auth::check())
        <h6>{{ Auth::user()->name }}</h6>
        @endif
    </div>
</body>

</html>