@extends('layout.home')

@section('title', 'FAQ')

@section('content')
<!-- FAQ -->
<section class="section-wrap faq">
        <div class="container">
          <div class="row">

            <div class="col-sm-9">
              <h2 class="mb-20 mt-80"><small>payment questions</small></h2>

              <div class="panel-group accordion mb-50" id="accordion-2">
              <div class="panel">
                  <div class="panel-heading">
                      <a data-toggle="collapse" data-parent="#accordion-2" href="#collapse-4" class="minus">How To Order<span>&nbsp;</span>
                      </a>
                  </div>
                  <style>
                    .panel-body ol li {
                      margin-bottom: 30px; /* Spasi antara elemen <li> */
                    }

                    .panel-body ol li img {
                      margin-top: 30px; /* Spasi di atas elemen <img> */
                    }
                  </style>
                  <div id="collapse-4" class="panel-collapse collapse in">
                      <div class="panel-body">
                      <ol>
                      <li><strong>Pilih Produk yang ingin di pesan</strong></li>
                      <img src="/front/img/tutor 1.png">
                      <img src="/front/img/tutor 2.png">
                      <li><strong>Masukkan Ke keranjang</strong></li>
                      <img src="/front/img/tutor 3.png">  
                      <li><strong>Isi data alamat tujuan untuk menghitung ongkos kirim</strong></li>
                      <img src="/front/img/tutor 4.png">
                      <li><strong>Isi data lengkap penerima</strong></li>
                      <img src="/front/img/tutor 5.png">
                      <li><strong>Transfer ke rekening yang tertera sesuai dengan nominal</strong></li>
                      <li><strong>Untuk cek Order histori bisa di lihat dengan cara Mengklik Profil yang berada di kanan atas.</strong></li>
                      <img src="/front/img/tutor 7.png">
                      </ol>
                      </div>
                  </div>

                <div class="panel">
                  <div class="panel-heading">
                    <a data-toggle="collapse" data-parent="#accordion-2" href="#collapse-5" class="plus">Bagaimana cara bayar lewat transfer rekening<span>&nbsp;</span>
                    </a>
                  </div>
                  <div id="collapse-5" class="panel-collapse collapse">
                    <div class="panel-body">
                    <li>Kunjungi cabang bank BCA terdekat atau gunakan layanan perbankan online BCA jika Anda memiliki akses.</li>
                    <li>Masuk ke akun Anda (jika menggunakan layanan online).</li>
                    <li>Pilih opsi "Transfer" atau "Transfer Antar Bank."</li>
                    <li>Pilih jenis transfer yang ingin Anda lakukan, misalnya, transfer antar rekening BCA atau transfer antar bank.</li>
                    <li>Masukkan nomor rekening tujuan dengan benar.</li>
                    <li>Isi nominal yang ingin Anda transfer.</li>
                    <li>Verifikasi kembali informasi yang telah Anda masukkan.</li>
                    <li>Konfirmasikan transfer dan ikuti langkah-langkah yang diminta, seperti memasukkan kode OTP (One-Time Password) jika diperlukan.</li>
                    <li>Transfer Anda akan diproses, dan uang akan dikirimkan ke rekening BCA tujuan.</li>
                    </div>
                  </div>
                </div>

              </div> <!-- end accordion -->

            </div> <!-- end col -->

            <aside class="sidebar col-sm-3">
              <div class="contact-item">
                <h6>Information</h6>
                <ul>
                  <li>
                    <i class="fa fa-envelope"></i><a href="mailto:theme@support.com">theme@support.com</a>
                  </li>
                  <li>
                    <i class="fa fa-phone"></i><span>+1 (800) 888 5260 52 63</span>
                  </li>
                  <li>
                    <i class="fa fa-skype"></i><span>zennashop</span>
                  </li>
                </ul>
              </div>

            </aside> <!-- end col -->

          </div>
        </div>
      </section> <!-- end faq -->
@endsection