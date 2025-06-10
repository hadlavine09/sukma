@extends('backend.component.main')

@section('content')
<main class="app-content">
    <div class="app-title">
        <div>
            <h1><i class="bi bi-plus-circle"></i> Tambah Supplier</h1>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="bi bi-house-door fs-6"></i></li>
            <li class="breadcrumb-item">Forms</li>
            <li class="breadcrumb-item active"><a href="#">Tambah Supplier</a></li>
        </ul>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="tile">
                <div class="tile-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert" id="success-alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert" id="error-alert">
                            <ul>
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <form action="{{ route('supplier.store') }}" method="POST">
                        @csrf
                        <div class="row mb-3">
                            <!-- Nama Supplier -->
                            <div class="col-md-6">
                                <label for="nama_supplier" class="form-label">Nama Supplier</label>
                                <input type="text" class="form-control" name="nama_supplier" id="nama_supplier" required>
                            </div>

                            <!-- No Supplier -->
                            <div class="col-md-6">
                                <label for="no_supplier" class="form-label">No Supplier</label>
                                <input type="text" class="form-control" name="no_supplier" id="no_supplier" required>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <!-- No HP Supplier -->
                            <div class="col-md-6">
                                <label for="no_hp_supplier" class="form-label">No HP Supplier</label>
                                <input type="text" class="form-control" name="no_hp_supplier" id="no_hp_supplier" required>
                            </div>

                            <!-- Alamat Supplier -->
                            <div class="col-md-6">
                                <label for="alamat_supplier" class="form-label">Alamat Supplier</label>
                                <textarea class="form-control" name="alamat_supplier" id="alamat_supplier" rows="3" required></textarea>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <!-- Toko ID -->
                            {{-- <div class="col-md-6">
                                <label for="toko_id" class="form-label">Toko</label>
                                <select class="form-select" name="toko_id" id="toko_id" required>
                                    <option value="" disabled selected>-- Pilih Toko --</option>
                                    @foreach($tokos as $toko)
                                        <option value="{{ $toko->id }}">{{ $toko->nama_toko }}</option>
                                    @endforeach
                                </select>
                            </div> --}}

                            <!-- Status Supplier -->
                            <div class="col-md-6">
                                <label for="status_supplier" class="form-label">Status Supplier</label>
                                <select class="form-select" name="status_supplier" id="status_supplier" required>
                                    <option value="Aktif" selected>Aktif</option>
                                    <option value="Tidak Aktif">Tidak Aktif</option>
                                </select>
                            </div>
                        </div>

                        <div class="tile-footer">
                            <button class="btn btn-primary" type="submit"><i class="bi bi-check-circle"></i> Simpan</button>
                            <a href="{{ route('supplier.index') }}" class="btn btn-secondary"><i class="bi bi-arrow-left"></i> Kembali</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection

@section('js_content')
<script>
    setTimeout(function() {
        $('#success-alert').fadeOut('slow');
        $('#error-alert').fadeOut('slow');
    }, 3000);
</script>
@endsection
