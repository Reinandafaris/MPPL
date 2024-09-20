@extends('layouts.layout')
@section('content')
<form action="{{ route('kaskeluar.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <fieldset>
        <div class="form-group row">
            <div class="col-md-5">
                Nomor Nota<input id="notran" type="text" name="notrans" class="form-control"
                    value="{{ $nomor }}" required>

            </div>
            <div class="col-md-5">
                Tanggal Transaksi<input id="tgltr" type="date" name="tgltr" value="" class="form-control"
                    required>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-10">
                Memo
                <textarea id="memo" type="text" name="memo" class="form-control" required></textarea>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-10">
                Tempat Beli
                <input id="tmptbeli" type="text" name="tmptbeli" class="form-control" required>
            </div>
        </div>
        <hr>
        <div class="form-group row">
            <div class="col-md-6">
                Akun
                @for ($i = 1; $i <= 3; $i++)
                    <select id="idakun{{ $i }}" name="idakun{{ $i }}" class="form-control">
                    <option value="0">--Pilih Akun--</option>
                    @foreach ($akun as $akn)
                    <option value="{{ $akn->id }}">{{ $akn->kdakun }} | {{ $akn->nmakun }}</option>
                    @endforeach
                    </select>
                    @endfor
            </div>
            <div class="col-md-4">
                Jumlah Pengeluaran
                @for ($i = 1; $i <= 3; $i++)
                    <input id="txt{{ $i }}" type="text" name="txt{{ $i }}" class="form-control"
                    value="0" onkeyup="sum();">
                    @endfor
                    <input id="idkk" type="hidden" name="idkk" class="form-control" value="{{ $nomorawal }}"
                        required>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-10">Total Pengeluaran
                <input id="total" type="text" name="total" class="form-control" required>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-10">
                Gambar Bukti
                <input id="image_path" type="file" name="image_path" class="form-control">
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-10">
                <input type="submit" class="btn btn-success btn-send" value="Simpan">
                <input type="Button" class="btn btn-primary btn-send" value="Kembali" onclick="history.go(-1)">
            </div>
        </div>
        <hr>
    </fieldset>
</form>
<script>
    function sum() {
        var text1 = document.getElementById('txt1').value;
        var text2 = document.getElementById('txt2').value;
        var text3 = document.getElementById('txt3').value;
        var result = parseFloat(text1) + parseFloat(text2) + parseFloat(text3);
        if (!isNaN(result)) {
            document.getElementById('total').value = result;
        }
    }
</script>

<script>
    // Mengatur format default value agar tahun langsung ke 2021
    const dateInput = document.getElementById('tgltr');

    // Mengubah tanggal input ke format YYYY-MM-DD untuk HTML5
    function formatToYYYYMMDD(day, month, year) {
        return `${year}-${month.toString().padStart(2, '0')}-${day.toString().padStart(2, '0')}`;
    }

    // Mengatur tanggal default ke 01/01/2021 saat halaman di-load
    window.onload = function() {
        const defaultDate = formatToYYYYMMDD(1, 1, 2021); // 01 Januari 2021
        dateInput.value = defaultDate;
    };
</script>

@endsection