@extends('layouts.master', [
    'judul' => 'Daftar Skripsi',
])
@section('content')
    <section class="section">
        <div class="card">
            <div class="card-header">Daftar Skripsi</div>
            <div class="card-body">
                <button type="button" class="btn btn-outline-primary block" data-bs-toggle="modal" data-bs-target="#add">
                    Tambah Skripsi
                </button>
                <table class="table table-striped" id="table1">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nomor Skripsi</th>
                            <th>Judul Skripsi</th>
                            <th>Kategori</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $item)
                            <tr>
                                <td>{{ $loop->index + 1 }}</td>
                                <td>{{ $item->id_buku }}</td>
                                <td>{{ $item->judul }}</td>
                                <td><small class="badge bg-info"><strong>{{$item->kategori->judul}}</strong></small></td>
                                <td>
                                    <form action="{{ Route('buku.destroy', $item->id) }}" method="post">
                                        @method('DELETE')
                                        @csrf
                                        <button class="btn btn-danger"
                                            onclick="return confirm('Menghapus Data buku ? Menghapus Data Transaksi Lainya')"><i
                                                class="bi bi-trash"></i></button>
                                        <a href="{{ Route('buku.edit', $item->uuid) }}" class="btn btn-warning"><i
                                                class="bi bi-pen"></i></a>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </section>
    <div class="modal fade text-left modal-borderless" id="add" tabindex="-1" role="dialog"
        aria-labelledby="myModalLabel1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Skripsi</h5>
                    <button type="button" class="close rounded-pill" data-bs-dismiss="modal" aria-label="Close">
                        <i data-feather="x"></i>
                    </button>
                </div>
                <form action="{{ route('buku.store') }}" method="post" enctype="multipart/form-data">
                    <div class="modal-body">
                        @method('POST')
                        @csrf
                        <div class="row">
                            <div class="form-group col-lg-6 col-6">
                                <label for="nomor">Nomor Skripsi</label>
                                <input required type="text" name="id_buku" placeholder="Nomor Skripsi" class="form-control">
                            </div>
                            <div class="form-group col-lg-6 col-6">
                                <label for="kategori">Kategori Skripsi</label>
                                <select name="kategori" required id="kategori" class="form-control">
                                    <option selected disabled>Pilih Kategori</option>
                                    @foreach ($kategori as $item)
                                        <option value="{{$item->id}}">{{$item->judul}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-lg-6 col-6">
                                <label for="judul">Judul Skripsi</label>
                                <input required type="text" name="judul" placeholder="Judul Skripsi" class="form-control">
                            </div>
                            <div class="form-group col-lg-6 col-6">
                                <label for="pengarang">Author</label>
                                <input required type="text" name="pengarang" placeholder="Author" class="form-control">
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-lg-6 col-6">
                                <label for="tahun">Tahun Terbit</label>
                                <input required type="date" name="tahun" id="tahun" class="form-control">
                            </div>
                           
                        </div>
                        <div class="form-group">
                            <label for="deskripsi">Deskripsi</label>
                            <textarea name="deskripsi" id="deskripsi" class="form-control"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="gambar">Cover Buku</label>
                            <input required type="file" name="cover" class="form-control-file" id="gambar">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light-primary" data-bs-dismiss="modal">
                            <i class="bx bx-x d-block d-sm-none"></i>
                            <span class="d-none d-sm-block">Close</span>
                        </button>
                        <button class="btn btn-primary ml-1" type="submit">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
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
