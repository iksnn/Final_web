@extends('layout.home')

@section('title', 'Contact Us')

@section('content')
<!-- Contact -->
  <section class="section-wrap contact pb-40">
          <div class="container">
            <div class="row">


            <div class="col-md-3 col-md-offset-5 col-sm-5 mb-40 ">
              <div class="contact-item">
                <h6>Address</h6>
                <address>{{$about->judul_website}}<br>
                {{$about->alamat}}</address>
              </div> <!-- end address -->

              <div class="contact-item">
                <h6>Information</h6>
                <ul>
                  <li>
                    <i class="fa fa-envelope"></i><a href="mailto:{{$about->email}}">{{$about->email}}</a>
                  </li>
                  <li>
                    <i class="fa fa-phone"></i><a href="https://wa.me/6285731202786">{{$about->telepon}}</a>

                  </li>
                </ul>               
              </div> <!-- end information -->
            </div>

          </div>
        </div>
      </section> <!-- end contact -->
@endsection