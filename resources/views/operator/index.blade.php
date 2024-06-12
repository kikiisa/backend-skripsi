@extends('layouts.master', [
    'judul' => 'Daftar Operator',
])
@section('content')
    <section class="section">
        <div class="card">
            <div class="card-header">Daftar Operator</div>
            <div class="card-body">
                <button type="button" class="btn btn-outline-primary block" data-bs-toggle="modal" data-bs-target="#add">
                    Tambah Operator
                </button>
                <table class="table table-striped" id="table1">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Username</th>
                            <th>Nama Lengkap</th>
                            <th>Email</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $item)
                            <tr>
                                <td>{{ $loop->index + 1 }}</td>
                                <td>{{ $item->username }}</td>
                                <td>{{ $item->name }}</td>
                                <td>{{ $item->email }}</td>
                                <td>
                                    <form action="{{ Route('operator.destroy', $item->id) }}" method="post">
                                        @method('DELETE')
                                        @csrf
                                        <button class="btn btn-danger"
                                            onclick="return confirm('Menghapus Data operator ? ')"><i
                                                class="bi bi-trash"></i></button>
                                        <a href="{{ Route('operator.edit', $item->uuid) }}" class="btn btn-warning"><i
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
                    <h5 class="modal-title">Tambah operator</h5>
                    <button type="button" class="close rounded-pill" data-bs-dismiss="modal" aria-label="Close">
                        <i data-feather="x"></i>
                    </button>
                </div>
                <form action="{{ route('operator.store') }}" method="post" enctype="multipart/form-data">
                    <div class="modal-body">
                        @method('POST')
                        @csrf
                        <div class="form-group">
                            <label for="name" class="form-label">Username</label>
                            <input type="text" required name="username" value="" id="username" class="form-control" placeholder="Username">
                        </div>
                        <div class="form-group">
                            <label for="name" class="form-label">Nama Lengkap</label>
                            <input type="text" required name="name" id="name" value="" class="form-control" placeholder="Your Name">
                        </div>
                        <div class="form-group">
                            <label for="email" class="form-label">Email</label>
                            <input type="text" required name="email" value="" id="email" class="form-control" placeholder="Your Email">
                        </div>
                        <div class="row">
                            <div class="form-group col-lg-6 col-6">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" required name="password" id="password" class="form-control" placeholder="Your Password">
                            </div>
                            <div class="form-group col-lg-6 col-6">
                                <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                                <input type="password" required name="password_confirmation" id="password_confirmation" class="form-control" placeholder="Your Password">
                            </div>
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
@endsection
