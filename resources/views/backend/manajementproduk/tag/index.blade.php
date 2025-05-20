@extends('backend.component.main')

@section('content')
<main class="app-content">
    <div class="app-title">
        <div>
            <h1><i class="bi bi-table"></i> Data Tag</h1>
            <p>Table untuk menampilkan data Tag dengan lebih efektif</p>
        </div>
        <ul class="app-breadcrumb breadcrumb side">
            <li class="breadcrumb-item"><i class="bi bi-house-door fs-6"></i></li>
            <li class="breadcrumb-item">Tables</li>
            <li class="breadcrumb-item active"><a href="#">Data Tag</a></li>
        </ul>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="tile">
                <div class="tile-body">
                    <!-- Menampilkan pesan sukses/error -->
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert" id="success-alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert" id="error-alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <div class="mb-3">
                        <a href="{{ route('tag.create') }}" class="btn btn-primary"><i class="bi bi-plus"></i> Tambah Data</a>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-hover table-bordered" id="tagTable">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Kode Tag</th>
                                    <th>Nama Tag</th>
                                    <th>Gambar Tag</th>
                                    <th>Deskripsi</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Data akan dimuat melalui DataTables -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection

<!-- Modal Delete -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Konfirmasi Hapus Data</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Apakah Anda yakin ingin menghapus Tag <strong id="tag-name"></strong>?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <form action="{{ route('tag.destroy') }}" method="POST" id="deletetagForm" class="d-inline">
                    @csrf
                    <input type="hidden" name="kode_tag" value=""> <!-- Hidden field for kode_tag -->
                    <button type="submit" class="btn btn-primary">Hapus</button>
                </form>
            </div>
        </div>
    </div>
</div>

@section('js_content')
<!-- Include CSS and JS for DataTables -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

<script>
    $(document).ready(function() {
        // Initialize DataTable
        var tagTable = $('#tagTable').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: '{!! route('tag.index') !!}',  // Get data through AJAX
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', className: "text-center" },
                { data: 'kode_tag', name: 'kode_tag' },
                { data: 'nama_tag', name: 'nama_tag' },
                { data: 'gambar_tag', name: 'gambar_tag', className: "text-center",
                    render: function(data, type, row) {
                        var imageUrl = "{{ asset('storage') }}/" + data; // Menggunakan Blade untuk memulai URL
                        if (data) {
                            return `<img src="${imageUrl}" alt="gambar" height="50">`; // Menampilkan gambar
                        } else {
                            return '<span class="text-muted">Tidak ada</span>';
                        }
                    }
                },
                { data: 'deskripsi_tag', name: 'deskripsi_tag' },
                { data: 'action', name: 'action', orderable: false, searchable: false, className: "text-center" }
            ]
        });

        // Handle delete button click
        $(document).on('click', '.delete-btn', function() {
            var tagKode = $(this).data('id');  // Get the kode_tag from the clicked button
            var tagName = $(this).data('nm');  // Get the name from the button

            // Update the name in the modal
            $('#tag-name').text(tagName);

            // Update the action URL for the form
            $('#deletetagForm').attr('action', '{{ route('tag.destroy') }}');  // POST to destroy route

            // Update the hidden input field with the tagKode (kode_tag)
            $('#deletetagForm').find('input[name="kode_tag"]').val(tagKode);

            // Show the modal
            $('#deleteModal').modal('show');
        });

        // Auto-dismiss alert after 3 seconds
        setTimeout(function() {
            $('#success-alert').fadeOut('slow');
            $('#error-alert').fadeOut('slow');
        }, 3000); // 3000 milliseconds = 3 seconds
    });
</script>
@endsection
