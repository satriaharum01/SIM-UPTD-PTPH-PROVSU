@extends('template.app')

@section('content')

<div class="text-center mb-4">
    <a href="." class="navbar-brand navbar-brand-autodark"></a>
</div>
<form class="card card-md" action="<?= route('daftar.akun') ?>" method="POST" autocomplete="off" required>
    @csrf
    <div class="card-body">
        <h2 class="card-title text-center mb-4">Silahkan mengisi form untuk membuat akun</h2>
        <div class="mb-3">
            <label class="form-label">Nama Pengguna</label>
            <input type="name" name="name" class="form-control" placeholder="Ex: Muhammad Arifin" autocomplete="off">
        </div>
		<div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control" placeholder="Ex: umsupress@gmail.com" autocomplete="off">
        </div>
		<div class="mb-3">
            <label class="form-label">Nomor Handphone</label>
            <input type="number" name="no_hp" class="form-control" placeholder="Ex: 087724287778" autocomplete="off">
			<input type="text" name="level" class="form-control d-none" value="Penulis">
       </div>
        <div class="mb-2">
            <label class="form-label">Password</label>
            <div class="input-group input-group-flat">
                <input type="password" name="password" class="form-control" placeholder="Password" autocomplete="off">
            </div>
        </div>
        <div class="form-footer">
            <button type="submit" class="btn btn-primary w-100">Daftar</button>
        </div>
    </div>
</form>


@endsection