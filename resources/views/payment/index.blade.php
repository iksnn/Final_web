@extends('layout.app')

@section('title', 'Data Pembayaran')

@section('content')

<div class="card shadow">
    <div class="card-header">
        <h4 class="card-title">
            Data Pembayaran
        </h4>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-hover table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>Order</th>
                        <th>Jumlah</th>
                        <th>Provinsi</th>
                        <th>Kabupaten</th>
                        <th>Kecamatan</th>
                        <th>Detail Alamat</th>
                        <th>No Rekening</th>
                        <th>Atas Nama</th>
                        <th>Status</th>
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
        <h5 class="modal-title">Form Pembayaran</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
            <div class="col-md-12">
                <form class="form-kategori">
                <div class="form-group">
                    <label for="tanggal">Tanggal</label>
                    <input type="text" class="form-control" id="tanggal" name="tanggal" placeholder="Tanggal" readonly>
                </div>

                <div class="form-group">
                    <label for="jumlah">Jumlah</label>
                    <input type="text" class="form-control" id="jumlah" name="jumlah" placeholder="Jumlah" readonly>
                </div>

                <div class="form-group">
                    <label for="jumlah">Provinsi</label>
                    <input type="text" class="form-control" id="provinsi" name="provinsi" placeholder="Provinsi" readonly>
                </div>

                <div class="form-group">
                    <label for="jumlah">Kabupaten</label>
                    <input type="text" class="form-control" id="kabupaten" name="kabupaten" placeholder="Kabupaten" readonly>
                </div>

                <div class="form-group">
                    <label for="jumlah">Kecamatan</label>
                    <input type="text" class="form-control" id="kecamatan" name="kecamatan" placeholder="Kecamatan" readonly>
                </div>

                <div class="form-group">
                    <label for="jumlah">Detail Alamat</label>
                    <input type="text" class="form-control" id="detail_alamat" name="detail_alamat" placeholder="Detail Alamat" readonly>
                </div>

                <div class="form-group">
                    <label for="no_rekening">No Rekening</label>
                    <input type="text" class="form-control" id="no_rekening" name="no_rekening" placeholder="No Rekening" readonly>
                </div>

                <div class="form-group">
                    <label for="atas_nama">Atas Nama</label>
                    <input type="text" class="form-control" id="atas_nama" name="atas_nama" placeholder="Atas Nama" readonly>
                </div>
                <div class="form-group">
                        <label for="status">Status</label>
                        <select name="status" id="status" class="form-control">
                            <option value="DITERIMA">DITERIMA</option>
                            <option value="DITOLAK">DITOLAK</option>
                            <option value="MENUNGGU">MENUNGGU</option>
                        </select>
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
        $(function(){

            function rupiah(angka) {
                if (typeof angka === 'undefined') {
                    return 'Rp 0'; // atau sesuaikan dengan pesan default jika angka kosong
                }
                
                const format = angka.toString().split('').reverse().join('');
                const convert = format.match(/\d{1,3}/g);
                return 'Rp ' + (convert ? convert.join('.').split('').reverse().join('') : '0');
            }

            function date(date) {
                var date = new Date(date);
                var day = date.getDate();
                var month = date.getMonth();
                var year = date.getFullYear();

                return `${day}-${month}-${year}`
            }

            $.ajax({
                url : '/api/payments',
                success : function ({data}) {

                    let row = ''; // Inisialisasi variabel row sebagai string kosong
                    data.map(function (val, index){
                        row += `
                        <tr>
                            <td>${index+1}</td>
                            <td>${date(val.created_at)}</td>
                            <td>${val.id_order}</td>
                            <td>${rupiah(val.jumlah)}</td>
                            <td>${val.provinsi}</td>
                            <td>${val.kabupaten}</td>
                            <td>${val.kecamatan}</td>
                            <td>${val.detail_alamat}</td>
                            <td>${val.no_rekening}</td>
                            <td>${val.atas_nama}</td>
                            <td>${val.status}</td>
                            <td>
                                <a data-toggle="modal" href="#modal-form" data-id="${val.id}" class="btn btn-warning modal-ubah">Edit</a>
                            </td>
                        </tr>
                        `;
                    });
                    $('tbody').append(row);
                }
            })

            $(document).on('click', '.btn-hapus', function() {
                const id = $(this).data('id');
                const token = localStorage.getItem('token')
                
                confirm_dialog = confirm('Apakah Anda yakin?');

                if (confirm_dialog) {
                    $.ajax({
                        url : '/api/payments/' + id,
                        type : "DELETE",
                        headers : {
                            "Authorization": "Bearer" + token
                        },
                        success : function(data){
                            if (data.message == 'success') {
                                alert('Data Berhasil diHapus')
                                location.reload();
                            }
                            
                        }
                    })
                }
            });

            function date(date) {
                var date = new Date(date);
                var day = date.getDate();
                var month = date.getMonth();
                var year = date.getFullYear();

                return `${day}-${month}-${year}`
            }
            
            $(document).on('click', '.modal-ubah', function () {
                $('#modal-form').modal('show');
                const id = $(this).data('id');

                $.get('/api/payments/' + id, function({
                    data
                }) {
                    $('input[name="tanggal"]').val(date(data.created_at));
                    $('input[name="jumlah"]').val(data.jumlah);
                    $('input[name="provinsi"]').val(data.provinsi);
                    $('input[name="kabupaten"]').val(data.kabupaten);
                    $('input[name="kecamatan"]').val(data.kecamatan);
                    $('input[name="detail_alamat"]').val(data.detail_alamat);
                    $('input[name="no_rekening"]').val(data.no_rekening);
                    $('input[name="atas_nama"]').val(data.atas_nama);
                    $('select[name="status"]').val(data.status);
                });

                $('.form-kategori').off('submit').submit(function (e) {
                    e.preventDefault();
                    const token = localStorage.getItem('token');
                    const formData = new FormData(this);
                    $.ajax({
                        url: `api/payments/${id}?_method=PUT`,
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
