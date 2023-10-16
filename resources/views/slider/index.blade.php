@extends('layout.app')

@section('title', 'Data Slider')

@section('content')

<div class="card shadow">
    <div class="card-header">
        <h4 class="card-title">
            Data Slider
        </h4>
    </div>
    <div class="card-body">
        <div class="d-flex justify-content-end mb-4">
            <a href="#modal-form"  class="btn btn-primary modal-tambah">Tambah Data</a>
        </div>
        <div class="table-responsive">
            <table class="table table-bordered table-hover table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Slider</th>
                        <th>Deskripsi</th> 
                        <th>Gambar</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-form" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Form slider</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
            <div class="col-md-12">
                <form class="form-slider">
                    <div class="form-group">
                        <label for="">Nama Slider</label>
                        <input type="text" class="form-control" name="nama_slider"
                            placeholder="Nama Slider" required>
                    </div>
                    <div class="form-group">
                        <label for="">Deskripsi</label>
                        <textarea name="deskripsi" placeholder="Deskripsi" id="" cols="30" rows="10" class="form-control" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="">Gambar</label>
                        <input type="file" class="form-control" name="gambar">
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary btn-block">Submit</button>
                    </div>
                </form>
            </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

@endsection

@push('js')
    <script>
      $(function () {
    // Fetch sliders using AJAX
    $.ajax({
        url: '/api/sliders',
        success: function ({ data }) {
            let row = ''; // Inisialisasi variabel row sebagai string kosong
            data.map(function (val, index) {
                row += `
                <tr>
                    <td>${index + 1}</td>
                    <td>${val.nama_slider}</td>
                    <td>${val.deskripsi}</td>
                    <td><img src="/uploads/${val.gambar}" width="150"></td>
                    <td>
                        <a data-toggle="modal" href="#modal-form" data-id="${val.id}" class="btn btn-warning modal-ubah">Edit</a>
                        <a href="#" data-id="${val.id}" class="btn btn-danger btn-hapus">Hapus</a>
                    </td>
                </tr>
                `;
            });
            $('tbody').append(row);
        }
    });

    // Handle delete confirmation
    $(document).on('click', '.btn-hapus', function () {
        const id = $(this).data('id');
        const token = localStorage.getItem('token');

        confirm_dialog = confirm('Apakah Anda yakin?');

        if (confirm_dialog) {
            $.ajax({
                url: '/api/sliders/' + id,
                type: "DELETE",
                headers: {
                    "Authorization": "Bearer " + token // Add a space after "Bearer"
                },
                success: function (data) {
                    if (data.message == 'success') {
                        alert('Data Berhasil diHapus');
                        location.reload();
                    }
                }
            });
        }
    });

    // Handle modal for adding a new subcategory
    $('.modal-tambah').click(function () {
        $('#modal-form').modal('show');
        $('input[name="nama_slider"]').val('');
        $('textarea[name="deskripsi"]').val('');
    });

    // Handle form submission for adding a new subcategory
    $('.form-slider').submit(function (e) {
        e.preventDefault();
        const token = localStorage.getItem('token');
        const formData = new FormData(this);
        $.ajax({
            url: '/api/sliders',
            type: 'POST',
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            headers: {
                "Authorization": "Bearer " + token
            },
            success: function (data) {
                if (data.success) {
                    alert('Data Berhasil diTambah');
                    location.reload();
                }
            }
        });
    });

    // Handle modal for editing a subcategory
    $(document).on('click', '.modal-ubah', function () {
        $('#modal-form').modal('show');
        const id = $(this).data('id');

        // Fetch data for editing
        $.get('/api/sliders/' + id, function ({ data }) {
            $('input[name="nama_slider"]').val(data.nama_slider);
            $('textarea[name="deskripsi"]').val(data.deskripsi);
        });

        // Handle form submission for editing
        $('.form-slider').off('submit').submit(function (e) {
            e.preventDefault();
            const token = localStorage.getItem('token');
            const formData = new FormData(this);
            $.ajax({
                url: `api/sliders/${id}?_method=PUT`,
                type: 'POST',
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                headers: {
                    "Authorization": "Bearer " + token // Perlu ada spasi setelah "Bearer"
                },
                success: function (data) {
                    if (data.success) {
                        alert('Data Berhasil diUbah');
                        location.reload();
                    }
                }
            });
        });
    });
});

    </script>
@endpush
