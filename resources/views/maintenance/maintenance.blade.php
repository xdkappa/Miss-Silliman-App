<?php $explode = explode(",",Auth::user()->roles);
  $active = '';
  if(!in_array("admin",$explode))
    $active = 'active';

  $talent = App\User::where('event','Talent')
                ->orderby('id')
                ->get();
  $speech = App\User::where('event','Speech')
                ->orderby('id')
                ->get();
  $orgs = App\User::where('userType','organizer')
                ->orderby('id')
                ->get();
 

    function bySP($a,$b)
    {
        if ($a->SP==$b->SP) return 0;
        return ( $a->SP > $b->SP ) ?-1 : 1;
    }

    function byAveTalent($a,$b)
    {
        if ($a->AverageTalent==$b->AverageTalent) return 0;
        return ( $a->AverageTalent > $b->AverageTalent ) ?-1 : 1;
    }

    function byAveSpeech($a,$b)
    {
        if ($a->AverageSpeech==$b->AverageSpeech) return 0;
        return ( $a->AverageSpeech > $b->AverageSpeech ) ?-1 : 1;
    }

    uasort($reports,"bySP");
    $report_SP = $reports;
    uasort($reports,"byAveTalent");
    $report_Talent = $reports;
    uasort($reports,"byAveSpeech");
    $report_Speech = $reports;

?>
@extends('layouts.master')

@section('content')
<style>
    .bordered {
        border: 1px solid black;
        border-collapse: collapse;
        padding : 4px;
    }
    .numfield{
        text-align : right;
    }
    .percentField{
        text-align : center;
    }
</style>
  <section class="content">
    <div class="row clearfix">
        <div class="col-lg-12">
            <ul class="nav nav-tabs tabs">
                @if(in_array("admin",$explode) == "true")
                <li class="active tab">
                    <a href="#judge" data-toggle="tab" aria-expanded="false">
                        <span class="visible-xs"><i class="fa fa-legal"></i></span>
                        <span class="hidden-xs">Judges</span>
                    </a>
                </li>
                <li class="tab">
                    <a href="#organizer" data-toggle="tab" aria-expanded="false">
                        <span class="visible-xs"><i class="fa fa-group"></i></span>
                        <span class="hidden-xs">Organizers</span>
                    </a>
                </li>
                <li class="tab">
                    <a href="#candidate" data-toggle="tab" aria-expanded="true">
                        <span class="visible-xs"><i class="fa fa-female"></i></span>
                        <span class="hidden-xs">Candidates</span>
                    </a>
                </li>
                <li class="tab">
                    <a href="#reports" data-toggle="tab" aria-expanded="true">
                        <span class="visible-xs"><i class="fa fa-archive"></i></span>
                        <span class="hidden-xs">Reports</span>
                    </a>
                </li>
                @endif
            </ul>
            <div class="tab-content">
                @if(in_array("admin",$explode) == "true")
                <div class="tab-pane active" id="judge">
                  <div class="container">
                      <!-- Page-Title -->
                      <div class="row">
                          <div class="col-sm-12">
                              <h4 class="pull-left page-title">Judges Table</h4>
                          </div>
                      </div>
                      <div class="panel">
                          <div class="panel-body">
                              <div class="row">
                                  <div class="col-sm-6">
                                      <div class="m-b-30">
                                          <button data-toggle="modal" data-target="#judgeModal" class="btn btn-primary waves-effect waves-light add">Add <i class="fa fa-plus"></i></button>
                                      </div>
                                  </div>
                              </div>
                              <table id="judgeTable" class="table table-bordered datatable table-striped">
                                  <thead>
                                      <tr>
                                          <th>Name</th>
                                          <th>Event</th>
                                          <th>Username</th>
                                          <th>Action</th>
                                      </tr>
                                  </thead>
                                  <tbody>
                                    @foreach($judges as $key)
                                    <tr class="gradeX">
                                      <td>{{$key->lName}}, {{$key->fName}} {{$key->mName}}</td>
                                      <td>{{$key->event}}</td>
                                      <td>{{$key->username}}</td>
                                      <td class="actions">
                                        <a class="edit" data-rel="{{$key->id}}" data-toggle="modal" data-target="#judgeModal" class="on-default edit-row"><i class="fa fa-pencil"></i></a>
                                        <a href="#" data-rel="{{$key->id}}" class="on-default remove-row"><i class="fa fa-trash-o"></i></a>
                                      </td>
                                    </tr>
                                    @endforeach
                                  </tbody>
                              </table>
                          </div>
                          <!-- end: page -->
                      </div> <!-- end Panel -->
                  </div> <!-- container -->
                </div><!-- end of judge pane -->
                <div class="tab-pane" id="organizer">
                  <div class="container">
                      <!-- Page-Title -->
                      <div class="row">
                          <div class="col-sm-12">
                              <h4 class="pull-left page-title">Organizers Table</h4>
                          </div>
                      </div>


                      <div class="panel">
                          <div class="panel-body">
                              <div class="row">
                                  <div class="col-sm-6">
                                      <div class="m-b-30">
                                          <button data-toggle="modal" data-target="#organizerModal" class="btn btn-primary waves-effect waves-light add">Add <i class="fa fa-plus"></i></button>
                                      </div>
                                  </div>
                              </div>
                              <table id="organizerTable" class="table table-bordered datatable table-striped">
                                  <thead>
                                      <tr>
                                          <th>Name</th>
                                          <th>Position</th>
                                          <th>Roles</th>
                                          <th>Username</th>
                                          <th>Action</th>
                                      </tr>
                                  </thead>
                                  <tbody>
                                    @foreach($organizers as $key)
                                    <tr class="gradeX">
                                      <td>{{$key->lName}} ,{{$key->fName}} {{$key->mName}}</td>
                                      <td>{{$key->position}}</td>
                                      <td>{{$key->roles}}</td>
                                      <td>{{$key->username}}</td>
                                      <td class="actions">
                                        <a href="#" data-rel="{{$key->id}}" data-toggle="modal" data-target="#organizerModal" class="on-default edit-row"><i class="fa fa-pencil"></i></a>
                                        <a href="#" data-rel="{{$key->id}}" class="on-default remove-row"><i class="fa fa-trash-o"></i></a>
                                      </td>
                                    </tr>
                                    @endforeach
                                  </tbody>
                              </table>
                          </div>
                          <!-- end: page -->
                      </div> <!-- end Panel -->
                  </div> <!-- container -->
                </div><!-- end of organizer pane -->
                <div class="tab-pane" id="candidate">
                  <div class="container">
                      <!-- Page-Title -->
                      <div class="row">
                          <div class="col-sm-12">
                              <h4 class="pull-left page-title">Candidates Table</h4>
                          </div>
                      </div>
                      <div class="panel">
                          <div class="panel-body">
                              <div class="row">
                                  <div class="col-sm-6">
                                      <div class="m-b-30">
                                          <button data-toggle="modal" data-target="#candidateModal" class="btn btn-primary waves-effect waves-light add">Add <i class="fa fa-plus"></i></button>
                                      </div>
                                  </div>
                              </div>
                              <table id="candidateTable" class="table table-bordered table-striped datatable">
                                  <thead>
                                      <tr>
                                        <th>Image</th>
                                        <th>Candidate No.</th>
                                        <th>College</th>
                                        <th>Name</th>
                                        <th>Action</th>
                                      </tr>
                                  </thead>
                                  <tbody>
                                    @foreach($candidates as $key)
                                    <tr class="gradeX">
                                      <td><img src="{{$key->image}}" alt="User" width="64px" length="64px" style="border-radius: 50%;"/></td>
                                      <td>{{$key->id}}</td>
                                      <td>{{$key->collegeName}}</td>
                                      <td><p>{{$key->lName}}, {{$key->fName}} {{$key->mName}}</p></td>
                                      <td class="actions">
                                        <a href="#" data-rel="{{$key->id}}" data-toggle="modal" data-target="#candidateModal" class="on-default edit-row"><i class="fa fa-pencil"></i></a>
                                        <a href="#" data-rel="{{$key->id}}" class="on-default remove-row"><i class="fa fa-trash-o"></i></a>
                                      </td>
                                    </tr>
                                    @endforeach
                                  </tbody>
                              </table>
                          </div>
                          <!-- end: page -->
                      </div> <!-- end Panel -->
                  </div> <!-- container -->
                </div><!-- end of candidate pane -->
                @endif
                <div class="tab-pane {{$active}}" id="reports">
                  <div class="container">
                      <!-- Page-Title -->
                      <div class="row">
                          <div class="col-sm-12">
                              <h2 class="pull-left page-title">Reports</h2>
                          </div>
                      </div>
                      <ul class="nav nav-tabs tabs tabs-top">
                          <li class="active tab">
                              <a href="#evt-pressLaunch" data-toggle="tab" aria-expanded="false">Press Launch</a>
                          </li>
                          <li class="tab">
                              <a href="#evt-pre" data-toggle="tab" aria-expanded="false">Prepageant</a>
                          </li>
                          <li class="tab">
                              <a href="#evt-final" data-toggle="tab" aria-expanded="false">Pageant Night</a>
                          </li>
                      </ul>
                      <div class="tab-content col-lg-12">
                        <div class="tab-pane active" id="evt-pressLaunch">
                            <!-- Page-Title -->
                            <div class="row">
                                <div class="col-sm-12">
                                    <h4 class="pull-left page-title">Press Launch Report</h4>
                                </div>
                            </div>
                            <div class="panel">
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="m-b-30">
                                                <button id="btnPrint_pressLaunch" data-toggle="modal" data-target="#FNModal" class="btn btn-primary waves-effect waves-light">Print <i class="fa fa-print"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="eventsTable-pressLaunch">
                                        <h3 style="font-weight:normal;">Miss Silliman 2018</h3>
                                        <h4 style="font-weight:normal;">Press Launch Results</h4>
                                        <table class="table table-bordered table-striped reports">
                                            <thead>
                                                <tr>
                                                    <th>College</th>
                                                    <th>Candidate</th>
                                                    <th>Press Launch</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($pressLaunchScores as $key)
                                                <tr class="gradeX">
                                                    <td>{{$key->collegeCode}}</td>
                                                    <td>{{strtoupper($key->lName)}}, {{$key->fName}}</td>
                                                    <td class="numfield">{{$key->PL_RS}}</td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                        <div class="row">
                                          @foreach($orgs as $key)
                                          <div class="col-xs-4 col-md-4" style="margin-top:50px;">
                                            <h5 style="border-top: solid 1px #CCC;padding-top:10px;text-align:center">{{$key->fName}} {{$key->lName}}</h5>
                                            <h6 style="text-align:center">Organizer</h6>
                                          </div>
                                          @endforeach
                                        </div>
                                    </div>
                                </div>
                                <!-- end: page -->
                            </div> <!-- end Panel -->
                        </div> <!-- end of event-press launch pane -->
                        <div class="tab-pane" id="evt-pre">
                            <!-- Page-Title -->
                            <div class="row">
                                <div class="col-sm-12">
                                    <h4 class="pull-left page-title">Prepageant Report</h4>
                                </div>
                            </div>
                            <div class="panel">
                              <ul class="nav nav-tabs tabs">
                                  <li class="active tab">
                                      <a href="#evt-pre-sp" data-toggle="tab">
                                          <span class="visible-xs"><i class="fa fa-star"></i></span>
                                          <span class="hidden-xs">Special Projects</span>
                                      </a>
                                  </li>
                                  <li class="tab">
                                      <a href="#evt-pre-talent" data-toggle="tab">
                                          <span class="visible-xs"><i class="fa fa-street-view"></i></span>
                                          <span class="hidden-xs">Talent</span>
                                      </a>
                                  </li>
                                  <li class="tab">
                                      <a href="#evt-pre-speech" data-toggle="tab">
                                          <span class="visible-xs"><i class="fa fa-bullhorn"></i></span>
                                          <span class="hidden-xs">Speech</span>
                                      </a>
                                  </li>
                                  <li class="tab">
                                      <a href="#evt-pre-summ" data-toggle="tab">
                                          <span class="visible-xs"><i class="fa fa-bullhorn"></i></span>
                                          <span class="hidden-xs">Summary</span>
                                      </a>
                                  </li>
                              </ul>
                              <div class="tab-content">
                                  <div class="tab-pane active" id="evt-pre-sp">
                                      <div class="row">
                                          <div class="col-sm-6">
                                              <div class="m-b-30">
                                                  <button id="btnPrint_PP_SP" data-toggle="modal" data-target="#PPModal" class="btn btn-primary waves-effect waves-light">Print <i class="fa fa-print"></i></button>
                                              </div>
                                          </div>
                                      </div>
                                      <div id="eventsTable-SP">
                                        <h3 style="font-weight:normal;">Miss Silliman 2018</h3>
                                        <h4 style="font-weight:normal;">Special Project Results</h4>
                                        <table class="table table-bordered table-striped specialprojects">
                                            <thead>
                                                <tr>
                                                    <th>College</th>
                                                    <th>Candidate</th>
                                                    <th>Special Project (Total)</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($report_SP as $key)
                                                <tr class="gradeX">
                                                    <td>{{$key->cCode}}</td>
                                                    <td>{{$key->candidates}}</td>
                                                    <td class="numfield">{{$key->SP}}</td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                        <div class="row">
                                          @foreach($orgs as $key)
                                          <div class="col-xs-4 col-md-4" style="margin-top:50px;">
                                            <h5 style="border-top: solid 1px #CCC;padding-top:10px;text-align:center">{{$key->fName}} {{$key->lName}}</h5>
                                            <h6 style="text-align:center">Organizer</h6>
                                          </div>
                                          @endforeach
                                        </div>
                                      </div>
                                  </div><!--end of special projects pane-->
                                  <div class="tab-pane" id="evt-pre-talent">
                                      <div class="row">
                                          <div class="col-sm-6">
                                              <div class="m-b-30">
                                                  <button id="btnPrint_PP_talent" data-toggle="modal" data-target="#PPModal" class="btn btn-primary waves-effect waves-light">Print <i class="fa fa-print"></i></button>
                                              </div>
                                          </div>
                                      </div>
                                      <div id="eventsTable-talent">
                                        <h3 style="font-weight:normal;">Miss Silliman 2018</h3>
                                        <h4 style="font-weight:normal;">Talent Results</h4>
                                        <table class="table table-bordered table-striped prepReports">
                                            <thead>
                                                <tr>
                                                    <th>College</th>
                                                    <th>Candidate</th>
                                                    <th>{{$talent[0]->fName}} {{$talent[0]->lName}}</th>
                                                    <th>{{$talent[1]->fName}} {{$talent[1]->lName}}</th>
                                                    <th>{{$talent[2]->fName}} {{$talent[2]->lName}}</th>
                                                    <th>Average</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($reports as $key)
                                                <tr class="gradeX">
                                                    <td>{{$key->cCode}}</td>
                                                    <td>{{$key->candidates}}</td>
                                                    <td class="numfield">{{$key->judge1}}</td>
                                                    <td class="numfield">{{$key->judge2}}</td>
                                                    <td class="numfield">{{$key->judge3}}</td>
                                                    <td class="numfield">{{$key->AverageTalent}}</td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                        <div class="row">
                                          @foreach($talent as $key)
                                          <div class="col-xs-4 col-md-4" style="margin-top:50px;">
                                            <h5 style="border-top: solid 1px #CCC;padding-top:10px;text-align:center">{{$key->fName}} {{$key->lName}}</h5>
                                            <h6 style="text-align:center">Talent Judge</h6>
                                          </div>
                                          @endforeach
                                        </div>
                                      </div>
                                  </div><!--end of talent pane-->
                                  <div class="tab-pane" id="evt-pre-speech">
                                      <div class="row">
                                          <div class="col-sm-6">
                                              <div class="m-b-30">
                                                  <button id="btnPrint_PP_speech" data-toggle="modal" data-target="#PPModal" class="btn btn-primary waves-effect waves-light">Print <i class="fa fa-print"></i></button>
                                              </div>
                                          </div>
                                      </div>
                                      <div id="eventsTable-speech">
                                        <h3 style="font-weight:normal;">Miss Silliman 2018</h3>
                                        <h4 style="font-weight:normal;">Speech Results</h4>
                                        <table class="table table-bordered table-striped prepReports">
                                            <thead>
                                              <tr>
                                                  <th>College</th>
                                                  <th>Candidate</th>
                                                  <th>{{$speech[0]->fName}} {{$speech[0]->lName}}</th>
                                                  <th>{{$speech[1]->fName}} {{$speech[1]->lName}}</th>
                                                  <th>{{$speech[2]->fName}} {{$speech[2]->lName}}</th>
                                                  <th>Average</th>
                                              </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($report_Speech as $key)
                                                <tr class="gradeX">
                                                    <td>{{$key->cCode}}</td>
                                                    <td>{{$key->candidates}}</td>
                                                    <td class="numfield">{{$key->judge4}}</td>
                                                    <td class="numfield">{{$key->judge5}}</td>
                                                    <td class="numfield">{{$key->judge6}}</td>
                                                    <td class="numfield">{{$key->AverageSpeech}}</td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                        <div class="row">
                                          @foreach($speech as $key)
                                          <div class="col-xs-4 col-md-4" style="margin-top:50px;">
                                            <h5 style="border-top: solid 1px #CCC;padding-top:10px;text-align:center">{{$key->fName}} {{$key->lName}}</h5>
                                            <h6 style="text-align:center">Speech Judge</h6>
                                          </div>
                                          @endforeach
                                        </div>
                                      </div>
                                  </div><!--end of speech pane-->
                                  <div class="tab-pane" id="evt-pre-summ"  style="overflow-x:auto">
                                      <div class="row">
                                          <div class="col-sm-6">
                                              <div class="m-b-30">
                                                  <button id="btnPrint_PP_summ" data-toggle="modal" data-target="#PPModal" class="btn btn-primary waves-effect waves-light">Print <i class="fa fa-print"></i></button>
                                              </div>
                                          </div>
                                      </div>
                                      <div id="eventsTable-summary">
                                        <h3 style="font-weight:normal;">Miss Silliman 2018</h3>
                                        <h4 style="font-weight:normal;">Prepageant Results</h4>
                                        <table class="table table-bordered table-striped">
                                            <thead>
                                              <tr>
                                                  <th>College</th>
                                                  <th>Candidate</th>
                                                  <th>{{$talent[0]->fName}} {{$talent[0]->lName}}</th>
                                                  <th>{{$talent[1]->fName}} {{$talent[1]->lName}}</th>
                                                  <th>{{$talent[2]->fName}} {{$talent[2]->lName}}</th>
                                                  <th>Average Talent Points</th>
                                                  <th>{{$speech[0]->fName}} {{$speech[0]->lName}}</th>
                                                  <th>{{$speech[1]->fName}} {{$speech[1]->lName}}</th>
                                                  <th>{{$speech[2]->fName}} {{$speech[2]->lName}}</th>
                                                  <th>Average Speech Points</th>
                                              </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($reports as $key)
                                                <tr class="gradeX">
                                                    <td>{{$key->cCode}}</td>
                                                    <td>{{$key->candidates}}</td>
                                                    <td class="numfield">{{$key->judge1}}</td>
                                                    <td class="numfield">{{$key->judge2}}</td>
                                                    <td class="numfield">{{$key->judge3}}</td>
                                                    <td class="numfield">{{$key->AverageTalent}}</td>
                                                    <td class="numfield">{{$key->judge4}}</td>
                                                    <td class="numfield">{{$key->judge5}}</td>
                                                    <td class="numfield">{{$key->judge6}}</td>
                                                    <td class="numfield">{{$key->AverageSpeech}}</td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                        <div class="row">
                                          @foreach($talent as $key)
                                          <div class="col-xs-4 col-md-4" style="margin-top:50px;">
                                            <h5 style="border-top: solid 1px #CCC;padding-top:10px;text-align:center">{{$key->fName}} {{$key->lName}}</h5>
                                            <h6 style="text-align:center">Talent Judge</h6>
                                          </div>
                                          @endforeach
                                          @foreach($speech as $key)
                                          <div class="col-xs-4 col-md-4" style="margin-top:50px;">
                                            <h5 style="border-top: solid 1px #CCC;padding-top:10px;text-align:center">{{$key->fName}} {{$key->lName}}</h5>
                                            <h6 style="text-align:center">Speech Judge</h6>
                                          </div>
                                          @endforeach
                                        </div>
                                      </div>
                                  </div><!--end of speech pane-->
                              </div>
                                <!-- end: page -->
                            </div> <!-- end Panel -->
                        </div> <!-- end of event-prepageant pane -->
                        <div class="tab-pane" id="evt-final">
                            <!-- Page-Title -->
                            <div class="row">
                                <div class="col-sm-12">
                                    <h4 class="pull-left page-title">Pageant Night Report</h4>
                                </div>
                            </div>
                            <ul class="nav nav-tabs tabs tabs-top">
                                <li class="active tab">
                                    <a href="#evt-pn-initialScore" data-toggle="tab" aria-expanded="false">Initial Score</a>
                                </li>
                                <li class="tab">
                                    <a href="#evt-pn-stdQuestion" data-toggle="tab" aria-expanded="false">Standard Question</a>
                                </li>
                                <li class="tab">
                                    <a href="#evt-pn-summ" data-toggle="tab" aria-expanded="false">Summary</a>
                                </li>
                            </ul>
                            <div class="tab-content col-lg-12">
                                <div class="tab-pane active" id="evt-pn-initialScore">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <h5 class="pull-left page-title">Initial Score Report</h5>
                                        </div>
                                    </div>
                                    <ul class="nav nav-tabs tabs tabs-top">
                                        <li class="active tab">
                                            <a href="#evt-pn-initialScore-prod" data-toggle="tab" aria-expanded="false">Production Number</a>
                                        </li>
                                        <li class="tab">
                                            <a href="#evt-pn-initialScore-theme" data-toggle="tab" aria-expanded="false">Theme Wear</a>
                                        </li>
                                        <li class="tab">
                                            <a href="#evt-pn-initialScore-eveGown" data-toggle="tab" aria-expanded="false">Evening Gown</a>
                                        </li>
                                        <li class="tab">
                                            <a href="#evt-pn-initialScore-seqInt" data-toggle="tab" aria-expanded="false">Sequential Interview</a>
                                        </li>
                                        <li class="tab">
                                            <a href="#evt-pn-initialScore-initInt" data-toggle="tab" aria-expanded="false">Initial Interview</a>
                                        </li>
                                        <li class="tab">
                                            <a href="#evt-pn-initialScore-summ" data-toggle="tab" aria-expanded="false">Summary</a>
                                        </li>
                                    </ul>
                                    <div class="tab-content col-lg-12">
                                        <div class="tab-pane active" id="evt-pn-initialScore-prod">
                                            <div class="panel">
                                                <div class="panel-body">
                                                    <div class="row">
                                                        <div class="col-sm-6">
                                                            <div class="m-b-30">
                                                                <button id="btnPrint-pn-initialScore-prod" data-toggle="modal" data-target="#FNModal" class="btn btn-primary waves-effect waves-light">Print <i class="fa fa-print"></i></button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div id="print-pn-initialscore-prod">
                                                        <h3 style="font-weight:normal;">Miss Silliman 2018</h3>
                                                        <h4 style="font-weight:normal;">Production Number Results</h4>
                                                        <table class="table table-bordered table-striped reports">
                                                            <thead>
                                                                <tr>
                                                                    <th>Judge</th>
                                                                    <th>Candidate</th>
                                                                    <th>Confidence</th>
                                                                    <th>Mastery</th>
                                                                    <th>Stage Presence</th>
                                                                    <th>Overall Impact</th>
                                                                    <th>Total</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach($initScores as $key)
                                                                <tr class="gradeX">
                                                                    <td>{{$key->judge}}</td>
                                                                    <td>{{$key->candidate}}</td>
                                                                    <td>{{$key->IS_Production_RS}}</td>
                                                                    <td>{{$key->IS_ThemeWr_RS}}</td>
                                                                    <td>{{$key->IS_EveGown_RS}}</td>
                                                                    <td>{{$key->IS_Subtotal}}</td>
                                                                    <td>{{$key->SQ_Content_RS}}</td>
                                                                    <td>{{$key->SQ_Confidence_RS}}</td>
                                                                    <td>{{$key->SQ_Wit_RS}}</td>
                                                                    <td>{{$key->SQ_Subtotal}}</td>
                                                                </tr>
                                                                @endforeach
                                                            </tbody>
                                                        </table>	
                                                    </div>													
                                                </div>
                                                <!-- end: page -->
                                            </div> <!-- end Panel -->
                                        </div><!--end of production number pane-->
                                        <div class="tab-pane" id="evt-pn-initialScore-theme">
                                            <div class="panel">
                                                    <div class="panel-body">
                                                        <div class="row">
                                                            <div class="col-sm-6">
                                                                <div class="m-b-30">
                                                                    <button id="btnPrint-pn-initialScore-theme" data-toggle="modal" data-target="#FNModal" class="btn btn-primary waves-effect waves-light">Print <i class="fa fa-print"></i></button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div id="print-pn-initialscore-theme">
                                                            <h3 style="font-weight:normal;">Miss Silliman 2018</h3>
                                                            <h4 style="font-weight:normal;">Theme Wear Results</h4>
                                                            <table class="table table-bordered table-striped reports">
                                                                <thead>
                                                                    <tr>
                                                                        <th>Judge</th>
                                                                        <th>Candidate</th>
                                                                        <th>Grace</th>
                                                                        <th>Projection</th>
                                                                        <th>Poise</th>
                                                                        <th>Relevance</th>
                                                                        <th>Total</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    @foreach($initScores as $key)
                                                                    <tr class="gradeX">
                                                                        <td>{{$key->judge}}</td>
                                                                        <td>{{$key->candidate}}</td>
                                                                        <td>{{$key->IS_Production_RS}}</td>
                                                                        <td>{{$key->IS_ThemeWr_RS}}</td>
                                                                        <td>{{$key->IS_EveGown_RS}}</td>
                                                                        <td>{{$key->IS_Subtotal}}</td>
                                                                        <td>{{$key->SQ_Content_RS}}</td>
                                                                        <td>{{$key->SQ_Confidence_RS}}</td>
                                                                        <td>{{$key->SQ_Wit_RS}}</td>
                                                                        <td>{{$key->SQ_Subtotal}}</td>
                                                                    </tr>
                                                                    @endforeach
                                                                </tbody>
                                                            </table>	
                                                        </div>													
                                                    </div>
                                                    <!-- end: page -->
                                                </div> <!-- end Panel -->
                                            </div><!--end of theme wear pane-->
                                        <div class="tab-pane" id="evt-pn-initialScore-eveGown">
                                            evegown
                                        </div><!--end of evening gown pane-->
                                        <div class="tab-pane" id="evt-pn-initialScore-seqInt">
                                            seqInt
                                        </div><!--end of sequentialInterview pane-->
                                        <div class="tab-pane" id="evt-pn-initialScore-initInt">
                                            initInt
                                        </div><!--end of initialInterview pane-->
                                        <div class="tab-pane" id="evt-pn-initialScore-summ">
                                            summ
                                        </div><!--end of summary pane-->
                                    </div>
                                </div><!--end of initialScore pane-->
                                <div class="tab-pane" id="evt-pn-stdQuestion">

                                </div><!--end of stdQuestion pane-->
                                <div class="tab-pane" id="evt-pn-summ">
                                    <div class="panel">
                                        <div class="panel-body">
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <div class="m-b-30">
                                                        <button id="btnPrint_FN" data-toggle="modal" data-target="#FNModal" class="btn btn-primary waves-effect waves-light">Print <i class="fa fa-print"></i></button>
                                                    </div>
                                                </div>
                                            </div>
                                            <div id="printFN">
                                                <h3 style="font-weight:normal;">Miss Silliman 2018</h3>
                                                <h4 style="font-weight:normal;">Pageant Night -- Initial Score Results</h4>
                                                <table class="table table-bordered table-striped reports">
                                                    <thead>
                                                        <tr>
                                                            <th>Judge</th>
                                                            <th>Candidate</th>
                                                            <th>Production (Raw Score)</th>
                                                            <th>Theme Wear (Raw Score)</th>
                                                            <th>Evening Gown (Raw Score)</th>
                                                            <th>Initial Score Subtotal</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach($initScores as $key)
                                                        <tr class="gradeX">
                                                            <td>{{$key->judge}}</td>
                                                            <td>{{$key->candidate}}</td>
                                                            <td>{{$key->IS_Production_RS}}</td>
                                                            <td>{{$key->IS_ThemeWr_RS}}</td>
                                                            <td>{{$key->IS_EveGown_RS}}</td>
                                                            <td>{{$key->IS_Subtotal}}</td>
                                                        </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>	
                                            </div>													
                                        </div>
                                        <!-- end: page -->
                                    </div> <!-- end Panel -->
                                </div><!--end of summary pane-->
                            </div>



                            
                        </div> <!-- end of event-final pane -->
                      </div> <!-- end of tab-content -->
                  </div> <!-- container -->
                </div>
            </div>
        </div>
    </div>
  </section>
  <!-- M O D A L S -->
  <div id="judgeModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
      <div class="modal-dialog">
          <div class="modal-content">
              <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                  <h4 class="modal-title">Judge</h4>
              </div>
              <div class="modal-body">
                <form id="judgeForm" action="{{url('/addJudge')}}" method="post" enctype="multipart/form-data">
                  @csrf
                  <div class="row">
                      <div class="col-md-4">
                          <div class="form-group">
                              <label for="JudgeField-FName" class="control-label">First Name</label>
                              <input type="text" class="form-control" id="JudgeField-FName" name="fName">
                          </div>
                      </div>
                      <div class="col-md-4">
                          <div class="form-group">
                              <label for="JudgeField-MName" class="control-label">Middle Name</label>
                              <input type="text" class="form-control" id="JudgeField-MName" name='mName'>
                          </div>
                      </div>
                      <div class="col-md-4">
                          <div class="form-group">
                              <label for="JudgeField-LName" class="control-label">Last Name</label>
                              <input type="text" class="form-control" id="JudgeField-LName" name='lName'>
                          </div>
                      </div>
                  </div>
                  <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="field-4" class="control-label">Event</label>
                            <select id="JudgeField-Event" class="full-width form-control input-block" data-init-plugin="select2" name='event'>
                              <option>Talent</option>
                              <option>Speech</option>
                              <option>Final</option>
                            </select>
                        </div>
                    </div>
                  </div>
                  <div class="row">
                      <div class="col-md-6">
                          <div class="form-group">
                              <label for="JudgeField-Username" class="control-label">Username</label>
                              <input type="text" class="form-control" id="JudgeField-Username" name='username' onClick='suggestJUsername()'>
                          </div>
                      </div>
                      <div class="col-md-6">
                          <div class="form-group">
                              <label for="JudgeField-Password" class="control-label">Password</label>
                              <input type="password" class="form-control" id="JudgeField-Password" name='password'>
                          </div>
                      </div>
                  </div>

              </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-info waves-effect waves-light">Save changes</button>
                </div>
                <input type='hidden' class='editMode' name='editMode' value=''/>
              </form>
          </div>
      </div>
  </div><!-- /.modal -->
  <div id="organizerModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
      <div class="modal-dialog">
          <div class="modal-content">
              <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                  <h4 class="modal-title">Organizer</h4>
              </div>
              <div class="modal-body">
                <form action="{{url('/addOrganizer')}}" method="post" enctype="multipart/form-data">
                  @csrf
                  <div class="row">
                      <div class="col-md-4">
                          <div class="form-group">
                              <label for="OrgField-FName" class="control-label">First Name</label>
                              <input type="text" class="form-control" id="OrgField-FName" name='fName'>
                          </div>
                      </div>
                      <div class="col-md-4">
                          <div class="form-group">
                              <label for="OrgField-MName" class="control-label">Middle Name</label>
                              <input type="text" class="form-control" id="OrgField-MName" name='mName'>
                          </div>
                      </div>
                      <div class="col-md-4">
                          <div class="form-group">
                              <label for="OrgField-LName" class="control-label">Last Name</label>
                              <input type="text" class="form-control" id="OrgField-LName" name='lName'>
                          </div>
                      </div>
                  </div>
                  <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="field-4" class="control-label">Position</label>
                            <select class="full-width form-control input-block" data-init-plugin="select2" name='position'>
                              <option>Chair</option>
                              <option>Vice-Chair</option>
                              <option>Committee Head</option>
                              <option>Others</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                      <div class="checkbox checkbox-primary">
                          <input id="checkbox2" type="checkbox" value="judge" name="roles[]">
                          <label for="checkbox2">
                              Judge
                          </label>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                      <div class="col-md-6">
                          <div class="form-group">
                              <label for="OrgField-Username" class="control-label">Username</label>
                              <input type="text" class="form-control" id="OrgField-Username" name='username' onClick="suggestOrgUsername()">
                          </div>
                      </div>
                      <div class="col-md-6">
                          <div class="form-group">
                              <label for="OrgField-Password" class="control-label">Password</label>
                              <input type="password" class="form-control" id="OrgField-Password" name='password'>
                          </div>
                      </div>
                  </div>
              </div>
              <div class="modal-footer">
                  <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
                  <button type="submit" class="btn btn-info waves-effect waves-light">Save changes</button>
              </div>
              <input type='hidden' class='editMode' name='editMode' value=''/>
            </form>
          </div>
      </div>
  </div><!-- /.modal -->
  <div id="candidateModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
      <div class="modal-dialog">
          <div class="modal-content">
              <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                  <h4 class="modal-title">Add Candidate</h4>
              </div>
              <div class="modal-body">
                <form action="{{url('/Candidate')}}" method="post" enctype="multipart/form-data">
                  @csrf
                  <div class="row">
                      <div class="col-md-12">
                          <div class="form-group">
                            <div class="avatar-upload">
                                <div class="avatar-edit">
                                    <input type='file' id="imageUpload" accept=".png, .jpg, .jpeg" />
                                    <label for="imageUpload"></label>
                                </div>
                                <div class="avatar-preview">
                                    <div id="imagePreview" style="background-image: url(public/css/images/testImg.jpg);">
                                    </div>
                                </div>
                            </div>
                          </div>
                      </div>


                  </div>
                  <div class="row">
                      <div class="col-md-4">
                          <div class="form-group">
                              <label for="field-1" class="control-label">First Name</label>
                              <input type="text" class="form-control" id="field-1" name='fName'>
                          </div>
                      </div>
                      <div class="col-md-4">
                          <div class="form-group">
                              <label for="field-2" class="control-label">Middle Name</label>
                              <input type="text" class="form-control" id="field-2" name='mName'>
                          </div>
                      </div>
                      <div class="col-md-4">
                          <div class="form-group">
                              <label for="field-3" class="control-label">Last Name</label>
                              <input type="text" class="form-control" id="field-3" name='lName'>
                          </div>
                      </div>
                  </div>
                  <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="field-4" class="control-label">College</label>
                            <select class="full-width form-control input-block" data-init-plugin="select2" name='position'>
                              @foreach($colleges as $key)
                                <option>{{$key->collegeName}}</option>
                              @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="field-5" class="control-label">School Year</label>
                            <input type="text" class="form-control" id="field-5" name='SY'>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="field-6" class="control-label">Candidate Number</label>
                            <input type="text" class="form-control" id="field-6" name='number'>
                        </div>
                    </div>
                  </div>
                  <div class="row">
                      <div class="col-md-6">
                          <div class="form-group">
                              <label for="field-8" class="control-label">Username</label>
                              <input type="text" class="form-control" id="field-8" name='username'>
                          </div>
                      </div>
                      <div class="col-md-6">
                          <div class="form-group">
                              <label for="field-9" class="control-label">Password</label>
                              <input type="password" class="form-control" id="field-9" name='password'>
                          </div>
                      </div>
                  </div>
              </div>
              <div class="modal-footer">
                  <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
                  <button type="submit" class="btn btn-info waves-effect waves-light">Save changes</button>
                </form>
              </div>
          </div>
      </div>
  </div><!-- /.modal -->
  </div>
    </div>
</div>


  <!-- /.modal -->



<script type="text/­javascript" src="https://­ajax.googleapis.com/­ajax/libs/jquery/­3.3.1/jquery.min.js"></script>
<script>
function suggestJUsername()
    {
        const fName = document.getElementById('JudgeField-FName').value;
        const lName = document.getElementById('JudgeField-LName').value;
        const txt_Username = document.getElementById('JudgeField-Username');

        const rand = (Math.floor(Math.random() * 10000) % 10000).toString();

        usernameString = fName[0] + lName + rand.padStart(4,'0');

        txt_Username.value = usernameString.toLowerCase();

    }

    function suggestOrgUsername()
    {

        const fName = document.getElementById('OrgField-FName').value;
        const lName = document.getElementById('OrgField-LName').value;
        const txt_Username = document.getElementById('OrgField-Username');

        const rand = (Math.floor(Math.random() * 10000) % 10000).toString();

        usernameString = fName[0] + lName + rand.padStart(4,'0')

        txt_Username.value = usernameString.toLowerCase();

    }

    function myFunction() {
        window.print();
    }

    document.getElementById("btnPrint_PP_SP").onclick = function () {
        $printPP = document.getElementById("eventsTable-SP");
        printElement($printPP);
    }

    document.getElementById("btnPrint_PP_talent").onclick = function () {
        $printPP = document.getElementById("eventsTable-talent");
        printElement($printPP);
    }

    document.getElementById("btnPrint_PP_speech").onclick = function () {
        $printPP = document.getElementById("eventsTable-speech");
        printElement($printPP);
    }

    document.getElementById("btnPrint_pressLaunch").onclick = function () {
        $printPP = document.getElementById("eventsTable-pressLaunch");
        printElement($printPP);
    }

    document.getElementById("btnPrint_PP_summ").onclick = function () {
        $printPP = document.getElementById("eventsTable-summary");
        printElement($printPP);
    }

document.getElementById("btnPrint-pn-initialScore-prod").onclick = function () {
    $printFN = document.getElementById("print-pn-initialscore-prod");
    printElement($printFN);
}

document.getElementById("btnPrint-pn-initialScore-theme").onclick = function () {
    $printFN = document.getElementById("print-pn-initialscore-theme");
    printElement($printFN);
}

    function printElement(elem) {
        var domClone = elem.cloneNode(true);

        var $printSection = document.getElementById("printSection");

        if (!$printSection) {
            var $printSection = document.createElement("div");
            $printSection.id = "printSection";
            document.body.appendChild($printSection);
        }

        $printSection.innerHTML = "";
        $printSection.appendChild(domClone);
        window.print();
    }
</script>
@endsection
