@extends('index')

@section('navbar')
<nav class="navbar navbar-light fixed-top bg-light p-0 shadow">
  <div class="container-fluid">
    <div class="py-3 m-0">
     <a href="{{ route('faculty-rbp') }}"><img src="{{ asset('img/logo/rmo-logo.png') }}" class="navbar-office-logo"></a>
      </div>
    <div class="navbar-nav px-3">
        <a class="text-center navbar-nav-text" href="#logoutModal" type="button" data-toggle="modal"><img src="{{ asset('img/logo/logout.svg') }}" class="navbar-logout-icon"><p class="mb-0 mt-1">Logout</p></a>
    </div>
  </div>
</nav>
<div class="d-flex wrapper" id="wrapper">
  @if ($user)
  
  <!-- Sidebar-->
  <div class="border-end" id="sidebar-wrapper">
      <button class="navbar-toggler toggler-example sidebar-btn" id="sidebarToggle" type="button" data-toggle="collapse" data-target="#navbarSupportedContent1"
      aria-controls="navbarSupportedContent1" aria-expanded="false" aria-label="Toggle navigation"><span class="dark-blue-text"><i
          class="fas fa-angle-left fa-1x"></i></span></button>
      <div class="sidebar-heading px-3 mt-4 text-muted row">
        <!-- If no picture/logo -->
        <!-- <div class="member-logo my-auto mr-2">C</div> -->
        <!-- else if have picture/logo -->
        <img src="{{ asset('img/users/'.$user->image) }}" height="auto" width="80px" class="my-auto pr-2"/> 
          <div class="sidebar-user-container m-auto">
            <a href="{{ route('faculty-view-profile',$user->id) }}"><p class="sidebar-user-name">{{ $user->fullname }}</p></a>
            <p class="sidebar-user-email">{{ $user->email }}</p>
          </div>
        </div>

        <x-navbar.faculty :active="$active"></x-navbar.faculty>
  </div>
  @endif
@stop

@section('content')
<!-- Page content wrapper-->
<div id="page-content-wrapper">
  <!-- Content Header -->
  <div class="container-fluid">
    <!-- Page Title -->
    <div class="row mb-2">
      <div class="col-sm-9 pl-3 mt-3">
        <h2 class="card-heading py-3 d-flex"><ion-icon name="proposal-add-outline" size="large"></ion-icon>  </h2>   
      </div>
      <div class="col-sm-3 mt-3">
        <a href="{{ URL::previous() }}" class="btn btn-primary btn-goback float-right"><i class="fas fa-reply"></i> Go Back</a>
      </div>

    </div>
  </div>
  <!-- End of Content Header -->

  @if(session('updated'))
  <div class="alert alert-success alert-dismissible">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
    <p class="card-alert-text"><i class="icon fas fa-info-circle"></i> {!! \Session::get('updated') !!}</p>
  </div>
@endif

@if (session('success'))
<div class="alert alert-success alert-dismissible">
  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
  <p class="card-alert-text"><i class="icon fas fa-info-circle"></i> {!! \Session::get('success') !!}</p>
</div>
@endif
@if(session('alert'))
  <div class="alert alert-danger alert-dismissible">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
    <p class="card-alert-text"><i class="icon fas fa-info-circle"></i> {!! \Session::get('alert') !!}</p>
  </div>
@endif


 <!-- Start of content table -->
 <div class="container-fluid py-2">
  <div class="card table-container">
    <div class="card-body card-body-proposal">
      <form class="proposal-form" action="{{ route('faculty-patented-create',$id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row pb-5">
          <div class="col-xl-6 ml-4">
            <div class="form-group text-left">
              <label for="InputNameofCommercialProduct" class="card-heading py-3">Name of Commercial Product*</label>
              <input type="text" class="form-control" id="InputNameofCommercialProduct" placeholder="Name of Commercial Product" name="product_name" required>
            </div>

            <div class="form-group text-left">
              <label for="InputUtilizationInvention" class="card-heading py-3">Utilization of Invention*</label>
              <input type="text" class="form-control" id="InputUtilizationInvention" placeholder="Enter Utilization of Invention" name="utilization" required>
            </div>

        </div>


        <div class="col-xl-5 ml-5">

            <div class="form-group text-left">
                <label for="InputPatentNumber" class="card-heading py-3">Patent Number*</label>
                <input type="text" class="form-control" id="InputPatentNumber" placeholder="Enter Patent Number" name="patent_no" required>
              </div>

            <div class="form-group text-left">
                <label for="InputDateofIssue" class="card-heading py-3">Issued Date*</label>
                <input type="date" class="form-control" id="InputDateofIssue" placeholder="Date of Issue" name="date_issue" required>
            </div>
        </div>
    
    </div>

                    

    <button type="submit" class="btn btn-primary float-lg-right ">ADD</button>          
              
    </div>
  </div>
</div>

</form>
  </div>

  </div>
</div>
</div>






<!-- Logout Modal -->
<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="logoutModalLabel" aria-hidden="true">
<div class="modal-dialog" role="document">
<div class="modal-content">
<div class="modal-header">
  <img src="../img/logout.svg" class="navbar-logout-icon"><span class="modal-title" id="logoutModalLabel"> LOGOUT ?</span>
  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>
<div class="modal-body text-center">
  <p>Are you sure you want to <span class="colored">LOGOUT</span> into your account now?</p>
  <button type="button" class="btn btn-primary">Yes</button>
  <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>

</div>
</div>
</div>
</div>
@stop