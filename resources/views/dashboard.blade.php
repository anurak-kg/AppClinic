@extends('layout.master')
@section('title','หน้าหลัก')

@section('content')

  <!-- START ACCORDION & CAROUSEL-->


              <div align="middle">


                    <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
                      <ol class="carousel-indicators">
                        <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
                        <li data-target="#carousel-example-generic" data-slide-to="1" class=""></li>
                        <li data-target="#carousel-example-generic" data-slide-to="2" class=""></li>
                      </ol>
                      <div class="carousel-inner">
                        <div class="item active">
                          <img src="http://placehold.it/900x500/39CCCC/ffffff&text=Welcome" alt="First slide">
                          <div class="carousel-caption">
                            First Slide
                          </div>
                        </div>
                        <div class="item">
                          <img src="http://placehold.it/900x500/3c8dbc/ffffff&text=Welcome" alt="Second slide">
                          <div class="carousel-caption">
                            Second Slide
                          </div>
                        </div>
                        <div class="item">
                          <img src="http://placehold.it/900x500/f39c12/ffffff&text=Welcome" alt="Third slide">
                          <div class="carousel-caption">
                            Third Slide
                          </div>
                        </div>
                      </div>
                      <a class="left carousel-control" href="#carousel-example-generic" data-slide="prev">
                        <span class="fa fa-angle-left"></span>
                      </a>
                      <a class="right carousel-control" href="#carousel-example-generic" data-slide="next">
                        <span class="fa fa-angle-right"></span>
                      </a>
                    </div>
                  </div><!-- /.box-body -->




            <!-- END ACCORDION & CAROUSEL-->
@stop
