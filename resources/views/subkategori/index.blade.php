@extends('layout.app')

@section('title', 'Data Sub Kategori')

@section('content')

<div class="card shadow">
    <div class="card-header">
        <h4 class="card-title"> 
            Data Sub Kategori
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
                        <th>Nama Kategori</th>
                        <th>Nama Sub Kategori</th>
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
        <h5 class="modal-title">Form Sub Kategori</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
            <div class="col-md-12">
                <form class="form-subkategori">
                    <div class="form-group">
                        <label for="">Nama Sub Kategori</label>
                        <input type="text" class="form-control" name="nama_subkategori"
                            placeholder="Nama subkategori" required>
                    </div>
                    <div class="form-group">
                        <label for="">Kategori</label>
                        <select name="id_kategori" id="id_kategori" class="form-control">
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->nama_kategori }}</option>
                            @endforeach
                        </select>
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
    // Fetch subcategories using AJAX
    $.ajax({
                url : '/api/subcategories',
                success : function ({data}) {

                    let row = ''; // Inisialisasi variabel row sebagai string kosong
                    data.map(function (val, index){
                        row += `
                        <tr>
                            <td>${index+1}</td>
                            <td>${val.nama_subkategori}</td>
                            <td>${val.category ? val.category.nama_kategori : 'Tidak Ada Kategori'}</td>

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
            })

    // Handle delete confirmation
    $(document).on('click', '.btn-hapus', function () {
        const id = $(this).data('id');
        const token = localStorage.getItem('token');

        confirm_dialog = confirm('Apakah Anda yakin?');

        if (confirm_dialog) {
            $.ajax({
                url: '/api/subcategories/' + id,
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
        $('input[name="nama_subkategori"]').val('');
        $('textarea[name="deskripsi"]').val('');
        $('select[name="id_kategori"]').val(''); // Reset the select element
    });
    $('.form-subkategori').submit(function (e) {
        e.preventDefault();
        const token = localStorage.getItem('token');
        const formData = new FormData(this);
        $.ajax({
            url: '/api/subcategories',
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

    // Handle form submission for adding a new subcategory
    });
    // Handle modal for editing a subcategory
        $(document).on('click', '.modal-ubah', function () {
            $('#modal-form').modal('show');
            const id = $(this).data('id');

            // Hapus handler peristiwa yang sebelumnya dipasang
            $('.form-subkategori').off('submit');

            $.get('/api/subcategories/' + id, function({ data }) {
                $('input[name="nama_subkategori"]').val(data.nama_subkategori);
                $('textarea[name="deskripsi"]').val(data.deskripsi);
                $('select[name="id_kategori"]').val(data.id_kategori);
            });

            // Pasang kembali handler peristiwa setelah menghapusnya
            $('.form-subkategori').submit(function (e) {
                e.preventDefault();
                const token = localStorage.getItem('token');
                const formData = new FormData(this);
                $.ajax({
                    url: `api/subcategories/${id}?_method=PUT`,
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
