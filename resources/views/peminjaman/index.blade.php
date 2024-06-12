@extends('layouts.master', [
    'judul' => 'Peminjaman Buku',
])
@section('content')
    <section class="section">
        <div class="card">
            <div class="card-header">Daftar Peminjaman</div>
            <div class="card-body">
               
                <table class="table table-striped" id="table1">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Peminjam</th>
                           
                            <th>Judul Skripsi</th>
                            <th>Tanggal Di Pinjam</th>
                            <th>Tanggal Kembali</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $item)
                            <tr>
                                <td>{{ $loop->index + 1 }}</td>
                              
                                <td>{{ $item->user->name }}</td>
                                <td>{{ $item->book->judul }}</td>
                                <td>{{$item->pinjam}}</td>
                                <td>{{$item->kembali}}</td>
                                <td>
                                    @if ($item->status == 'proses')
                                        <button class="badge border-0 mb-2 w-100 bg-warning" type="submit">Proses Persetujuan</button>
                                        
                                    @elseif($item->status == 'kembali')
                                        <button class="badge border-0 mb-2 w-100 bg-success"  type="submit">Di Kembalikan</button>
                                    @else  
                                        <button class="badge border-0 mb-2 w-100 bg-info">Di Pinjam</button>
                                    @endif
                                    @if ($item->status != 'kembali')
                                        <form action="" method="post">
                                            <select name="status" id="status" class="form-control" onchange="changeStatus(this.value,{{ $item->id }},{{$item->book->id}})">
                                                <option value="">-- Pilih Status --</option>
                                                <option value="kembali">Di Kembalikan</option>
                                                <option value="pinjam">Setujui Peminjaman</option>
                                            </select>
                                        </form>
                                    @endif
                                </td>
                                <td>
                                    <form action="{{ Route('peminjaman.destroy', $item->id) }}" method="post">
                                        @method('DELETE')
                                        @csrf
                                        <button class="btn btn-danger"
                                            onclick="return confirm('Menghapus Data Transaksi Ini ?')"><i
                                                class="bi bi-trash"></i></button>
                                        <a href="{{ Route('buku.show', $item->uuid) }}" class="btn btn-warning"><i
                                                class="bi bi-eye"></i></a>
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
    <script src="{{ asset('template/assets/js/axios.min.js') }}"></script>
    <script>
        const changeStatus = async (status,id,book_id) => 
        {
            const response = await axios.put(`/api/transaksi-buku/${id}`,{
                status:status,
                id:id,
                book_id:book_id
            })
            console.log(response);
            if(response.data.status == 'success')
            {
                Toastify({
                    text: "Berhasil Mengubah Status",
                    duration: 3000,
                    close: true,
                    backgroundColor: "#19C37D",
                }).showToast();
                window.location.reload()
            }else{
                Toastify({
                    text: 'Terjadi Kesalahan',
                    duration: 3000,
                    close: true,
                    backgroundColor: "#D61355",
                }).showToast();
            }
        }
    </script>
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
