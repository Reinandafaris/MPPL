<!DOCTYPE html>
<html>

<head>
    <title>Laporan Kas Keluar</title>
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
                <h2>Laporan Kas keluar<br>PT. XYZ</h2>
                <hr>
            </td>
        </tr>
    </table>
    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
        <thead>
            <tr align="center">
                <th width="5%">No</th>
                <th width="20%">No Transaksi</th>
                <th width="20%">Tanggal</th>
                <th width="40%">Memo</th>
                <th width="15%">Jumlah</th>
            </tr>
        </thead>
        <tbody>
            @php $i=1 @endphp
            @foreach ($kaskeluar as $kk)
                <tr>
                    <td>{{ $i++ }}</td>
                    <td>{{ $kk->nokk }}</td>
                    <td>{{ $kk->tglkk }}</td>
                    <td>{{ $kk->memokk }}</td>
                    <td>{{ $kk->jmkk }}</td>
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
