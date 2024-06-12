@extends('layouts.master', [
    'judul' => 'Edit Skripsi',
])
@section('content')
    <style>
        img{
            background-size: cover; /* or 'contain' depending on your preference */
            background-position: center center; /* to center the image */
            width: 100%;
            height: 100%;
        }
    </style>
    <section class="section">
        <div class="row">
            
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header">Edit Skripsi</div>
                    <div class="card-body">
                        <form action="{{ route('buku.update', $data->id) }}" method="post" enctype="multipart/form-data">
                            <div class="modal-body">
                                @method('PUT')
                                @csrf
                                <div class="row">
                                    <div class="form-group">
                                        <label for="nomor">Nomor Skripsi</label>
                                        <input required type="text" value="{{ $data->id_buku }}" name="id_buku"
                                            placeholder="Nomor Skripsi" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label for="kategori">Kategori Skripsi</label>
                                        <select name="kategori" required id="kategori" class="form-control">
                                            <option selected disabled>Pilih Kategori</option>
                                            @foreach ($kategori as $item)
                                                <option value="{{ $item->id }}"
                                                    {{ $data->kategori_id == $item->id ? 'selected' : '' }}>{{ $item->judul }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
        
                                <div class="form-group">
                                    <label for="judul">Judul Skripsi</label>
                                    <input required type="text" name="judul" placeholder="Judul Buku"
                                        value="{{ $data->judul }}" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="pengarang">Pengarang / Author</label>
                                    <input required type="text" name="pengarang" value="{{ $data->pengarang }}"
                                        placeholder="Pengarang" class="form-control">
                                </div>
        
        
                                <div class="form-group">
                                    <label for="tahun">Tahun Terbit</label>
                                    <input required type="date" name="tahun" id="tahun" value="{{ $data->tahun_terbit }}"
                                        class="form-control">
                                </div>
                                
        
                                <div class="form-group">
                                    <label for="deskripsi">Deskripsi</label>
                                    <textarea name="deskripsi" id="deskripsi" class="form-control">{{ $data->deskripsi }}</textarea>
                                </div>
                                <div class="form-group">
                                    <label for="gambar">File Skripsi / Jurnal</label>
                                    <input type="file" name="cover" class="form-control-file" id="gambar">
                                </div>
                            </div>
                            <div class="modal-footer">
                                <a href="{{ Route('buku.index') }}" class="btn btn-light-primary">
                                    Kembali
                                </a>
                                <a href="{{asset($data->cover)}}" class="btn btn-success ms-2">Lihat File</a>
                                <button class="btn btn-primary ms-2" type="submit">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script src="{{ asset('template/assets/extensions/toastify-js/src/toastify.js') }}"></script>
    @if (count($errors) > 0)
        <script>
            var errors = @json($errors->all());
            Toastify({
                text: errors,
                duration: 3000,
                close: true,
                backgroundColor: "#D61355",
            }).showToast();
        </script>
    @enderror
    @if (session()->has('success'))
        <script>
            Toastify({
                text: "{{ session('success') }}",
                duration: 3000,
                close: true,
                backgroundColor: "#19C37D",
            }).showToast();
        </script>
    @endif

    @if (session()->has('error'))
        <script>
            Toastify({
                text: "{{ session('error') }}",
                duration: 3000,
                close: true,
                backgroundColor: "#D61355",
            }).showToast();
        </script>
    @endif

    @error('name')
        <script>
            Toastify({
                text: "{{ $message }}",
                duration: 3000,
                close: true,
                backgroundColor: "#D61355",
            }).showToast();
        </script>
    @enderror
    @error('username')
        <script>
            Toastify({
                text: "{{ $message }}",
                duration: 3000,
                close: true,
                backgroundColor: "#D61355",
            }).showToast();
        </script>
    @enderror
    @error('email')
        <script>
            Toastify({
                text: "{{ $message }}",
                duration: 3000,
                close: true,
                backgroundColor: "#D61355",
            }).showToast();
        </script>
    @enderror
@endsection
