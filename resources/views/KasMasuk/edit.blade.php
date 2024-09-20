@extends('layouts.layout')
@section('content')
<form action="{{ route('kasmasuk.update', $kasmasuk->id) }}" method="POST" enctype="multipart/form-data">
  @csrf
  @method('PUT')
  <fieldset>
    <div class="form-group row">
      <div class="col-md-5">
        Nomor Nota<input id="notran" type="text" name="notrans" class="form-control" value="{{ $kasmasuk->nokm }}" required>
      </div>
      <div class="col-md-5">
        Tanggal Transaksi<input id="tgltr" type="date" name="tgltr" value="{{ $kasmasuk->tglkm }}" class="form-control"
          required>
      </div>
    </div>
    <div class="form-group row">
      <div class="col-md-10">
        Memo
        <textarea id="memo" type="text" name="memo" class="form-control" required>{{ $kasmasuk->memokm }}</textarea>
      </div>
    </div>
    <div class="form-group row">
      <div class="col-md-10">
        Tempat Beli
        <input id="tmptbeli" type="text" name="tmptbeli" class="form-control" value="{{ $kasmasuk->tmptbeli }}" required>
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
          <!-- Cek apakah akun saat ini sudah dipilih, jika ya tambahkan 'selected' -->
          <option value="{{ $akn->id }}"
            @if(isset($kasmasukdet[$i-1]) && $kasmasukdet[$i-1]->idakun == $akn->id) selected @endif>
            {{ $akn->kdakun }} | {{ $akn->nmakun }}
          </option>
          @endforeach
          </select>
          @endfor
      </div>
      <div class="col-md-4">
        Jumlah Pemasukan
        @for ($i = 1; $i <= 3; $i++)
          <input id="txt{{ $i }}" type="text" name="txt{{ $i }}" class="form-control"
          value="{{ isset($kasmasukdet[$i-1]) ? $kasmasukdet[$i-1]->nildb : 0 }}" onkeyup="sum();">
          @endfor
          <input id="idkm" type="hidden" name="idkm" class="form-control" value="{{ $kasmasuk->id }}" required>
      </div>

    </div>
    <div class="form-group row">
      <div class="col-md-10">Total Penerimaan
        <input id="total" type="text" name="total" class="form-control" value="{{ $kasmasuk->jmkmd }}" required>
      </div>
    </div>

    <div class="form-group row">
      <div class="col-md-10">
        Ubah Gambar Bukti?
        <input id="image_path" type="file" name="image_path" class="form-control">
      </div>
    </div>

    <div class="form-group row mb-0">
      <div class="col-md-10">
        <p class="mb-0">Gambar Bukti Sebelumnya</p>
      </div>
    </div>

    <div class="form-group row">
      <div id="popup" class="col-md-2 mb-3 flex flex-row">
        @if ($kasmasuk->image_path)
        <img id="thumbnail" class="gambar" src="{{ asset('storage/'.$kasmasuk->image_path) }}" alt="{{ $kasmasuk->image_path }}" width="100%" height="100%">
        @else
        <p>No image available</p>
        @endif
      </div>
    </div>

    <!-- Div untuk popup fullscreen -->
    <div class="popup" id="popupContainer">
      <span class="close-btn" id="closeBtn">&times;</span>
      <img id="popupImage" src="" width="100%" height="100%" alt="Fullscreen Image">
    </div>

    <div class="form-group row">
      <div class="col-md-10">
        <input type="Button" class="btn btn-primary btn-send" value="Kembali" onclick="history.go(-1)">
        <input type="submit" class="btn btn-success btn-send" value="Update">
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
@endsection