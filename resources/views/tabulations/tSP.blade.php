<?php
    $collegeCode = ["CBA","CAS","MED","HS","CED","MASSCOMM","COPVA","GRAD","IRS","NURSING"];
    $collegeName = [
        "COLLEGE OF BUSINESS ADMINISTRATION",
        "COLLEGE OF ARTS AND SCIENCES",
        "SENIOR HIGH SCHOOL",
        "COLLEGE OF ENGINEERING AND DESIGN",
        "COLLEGE OF MASS COMMUNICATION",
        "COLLEGE OF PERFORMING AND VISUAL ARTS",
        "GRADUATE STUDIES",
        "INSTITUTE OF REHABILITATIVE STUDIES",
        "COLLEGE OF NURSING"
    ];
    $name = [
        "Mikhaella Ponce de Leon",
        "Christine Torcino",
        "Oghogho Ovonlen",
        "Erica Villagracia",
        "Shannel Vendiola",
        "Ivy Salaum",
        "Chanel Pepino",
        "Yihui Yuan",
        "Amidala Quisumbing",
        "Gabrielle Arrojado"
    ];
    $picSrc = [
        "public/css/images/CBA.png",
        "public/css/images/CAS.png",
        "public/css/images/MED.png",
        "public/css/images/HS.png",
        "public/css/images/CED.png",
        "public/css/images/MC.png",
        "public/css/images/COPVA.png",
        "public/css/images/GRAD.png",
        "public/css/images/IRS.png",
        "public/css/images/NURSING.png",
    ];
?>
@extends('layouts.master')

@section('content')
<section class="content">
    <div class="container">
        <div class="row col-md-12 align-center">
            <h1> SPECIAL PROJECTS </h1>
        </div>
        <div class="row col-md-12">
            <div class="col-md-3"></div>
            <div class="tabs-vertical-env col-md-6">
                <ul class="nav tabs-vertical">
                    @for( $i=0 ; $i<=9 ; $i++)
                        @if($i==0)
                            <li class="active">
                                <a href=#list-{{$i}} data-toggle="tab" aria-expanded="false">{{$collegeCode[$i]}}</a>
                            </li>
                        @else
                            <li class="">
                                <a href=#list-{{$i}} data-toggle="tab" aria-expanded="false">{{$collegeCode[$i]}}</a>
                            </li>
                        @endif
                    @endfor
                </ul>
                <div class="tab-content" style="padding:100px">
                    @for( $i=0 ; $i<=9 ; $i++)
                        @if($i==0)
                            <div class="tab-pane active width-auto" id=list-{{$i}}>
                                <div class="card" style="padding : 20px">
                                    <div class="align-center">
                                        <img
                                            class="card-img-top"
                                            src={{$picSrc[$i]}}
                                            alt="Card image cap"
                                            style="height : 250px; width : 250px; border-radius : 50%">
                                    </div>
                                    <div class="card-body">
                                        <h3 class="card-title">{{$collegeCode[$i]}}</h3>
                                        <h5 class="card-title">{{$name[$i]}}</h5>
                                        <div class="input-group input-group-lg">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="inputGroup-sizing-lg">SCORE</span>
                                        </div>
                                        <input type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-lg">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="tab-pane width-auto" id=list-{{$i}}>
                                <div class="card col-sm-12" style="padding : 20px">
                                    <div class="align-center">
                                        <img
                                            class="card-img-top"
                                            src={{$picSrc[$i]}}
                                            alt="Card image cap"
                                            style="height : 250px; width : 250px; border-radius : 50%">
                                    </div>
                                    <div class="card-body">
                                        <h3 class="card-title">{{$collegeCode[$i]}}</h3>
                                        <h5 class="card-title">{{$name[$i]}}</h5>
                                        <div class="input-group input-group-lg">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="inputGroup-sizing-lg">SCORE</span>
                                        </div>
                                        <input id="scoreInput" type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-lg">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endfor
                    <div class="col-md-2"></div>
                </div>
            </div>
            <div class="col-md-3"></div>
        </div>
        <div class="modal-footer">
            <button id="openModal" type="button" class="btn btn-link waves-effect" data-toggle="modal" data-target="#myModal">PROCEED</button>
        </div>
        <div id="myModal" class="modal fade" role="dialog">
          <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Modal Header</h4>
              </div>
              <div class="modal-body">
                <p>Some text in the modal.</p>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              </div>
            </div>

          </div>
        </div>
    </div> <!-- container -->
</section>

@endsection