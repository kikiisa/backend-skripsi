@extends('layouts.master', [
    'judul' => 'Daftar Mahasiswa',
])
@section('content')
    <section class="section">
        <div class="card">
            <div class="card-header">Daftar Mahasiswa</div>
            <div class="card-body">
                <table class="table table-striped" id="table1">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nim</th>
                            <th>Nama Lengkap</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $item)
                            <tr>
                                <td>{{ $loop->index + 1 }}</td>
                                <td>{{ $item->nim }}</td>
                                <td>{{ $item->name }}</td>
                                <td>{{ $item->email }}</td>
                                <td>{{ $item->phone }}</td>
                                <td>
                                    <form action="{{Route('users.status',$item->id)}}" method="post">
                                        @csrf
                                        @method("PUT")
                                        @if ($item->status == 'active')
                                            <button class="btn btn-success" name="status" value="inactive" type="submit">Aktif</button>
                                        
                                        @else($item->status == 'inactive')
                                            <button class="btn btn-danger" name="status" value="active" type="submit">Nonaktif</button>
                                        @endif
                                    </form>
                                </td>
                                <td>
                                    <form action="{{Route('users.destroy',$item->id)}}" method="post">
                                        @method("DELETE")
                                        @csrf
                                        <button class="btn btn-danger" onclick="return confirm('Menghapus Data User Menghapus Data Transaksi Lainya')"><i class="bi bi-trash"></i></button>
                                        <a href="{{Route('users.edit',$item->uuid)}}" class="btn btn-warning"><i class="bi bi-pen"></i></a>
                                        <a href="" class="btn btn-success"><i class="bi bi-envelope"></i></a>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </section>
    <script src="{{ asset('template/assets/extensions/toastify-js/src/toastify.js') }}"></script>
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
