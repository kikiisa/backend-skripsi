@extends('layouts.master', [
    'judul' => 'Edit Mahasiswa',
])
@section('content')
    <section class="section">
        <div class="row">
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-body">
                        @if ($data->profile == 'default')
                            <div class="row">
                              
                                    <img src="{{asset('template/assets/images/faces/user.png')}}" alt="default"  style='height: 100%; width: 100%; object-fit: contain'>
                              
                            </div>
                        @else
                            {{'yes'}}
                        @endif
                        <img src="" alt="" srcset="">
                    </div>
                </div>
            </div>
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ Route('users.update', $data->id) }}" method="post">
                            @method('PUT')
                            @csrf
                            <div class="form-group">
                                <label>Nim</label>
                                <input type="text" value="{{ $data->nim }}" name="nim" placeholder="Enter Nik"
                                    class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Nama Lengkap</label>
                                <input type="text" name="name" value="{{ $data->name }}"
                                    placeholder="Nama Lengkap" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Email</label>
                                <input type="text" name="email" id="email" value="{{ $data->email }}"
                                    placeholder="Enter Email" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Phone / WhatsApps</label>
                                <input type="text" name="phone" placeholder="Enter Phone" value="{{ $data->phone }}"
                                    class="form-control">
                            </div>       
                            <button class="btn btn-primary">simpan</button>
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
@endsection
