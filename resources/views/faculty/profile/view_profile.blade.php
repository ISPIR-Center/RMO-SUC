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
          {{-- <button type="button" class="btn btn-lg btn-light float-right" data-bs-toggle="modal" data-bs-target="#exampleModal"> --}}
            <a href="#awardsModal" class="btn btn-lg btn-light float-right" data-toggle="modal">Add Award <i class="fas fa-plus"></i></a>
        </a>
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
      <div class="card-header">
        <div class="row">
          <div class="col-sm-9">
            <h1 class="card-title2 py-3">Researcher Details</h1>
          </div>
         
        </div>
      </div>
      <div class="card-body card-body-proposal">
        <form class="proposal-form" action="">
          <div class="row pb-5">
            <div class="col-xl-5 ml-4">
  
                <div class="form-group text-left">
                  <label for="InputUniversityAgenda" class="card-heading py-3">Name</label>
                  <p class="card-text">{{ $proponent->fullname }}</p>
                </div>

                <div class="form-group text-left">
                  <label for="InputResearchTitle" class="card-heading py-3">Employee No.</label>
                  <p class="card-text">{{ $proponent->employee_no }}</p>
                </div>
  
                <div class="form-group text-left">
                  <label for="InputResearchProponent" class="card-heading py-3">BulSU Campus</label>
                  <p class="card-text">{{ $proponent->campus }}</p>
                </div>
  
                <div class="form-group text-left">
                  <label for="InputResearchMember" class="card-heading py-3">Awards - Year Received</label>
                   <p class="card-text">
                    @foreach ($awards as $item)
                    ➤ {{ $item->name }} - {{ $item->year }} <br>
                @endforeach</p> 
              </div>
  
            </div>
  
  
            <div class="col-xl-6 ml-6">
  
              <div class="d-flex">
                <div class="col-6 form-group text-left">
                  <label for="InputDisciplineCovered" class="card-heading py-3">BulSU Email</label>
                  <p class="card-text">{{ $proponent->email }}</p>
              </div>
                <div class="col-6 form-group text-left">
                  <label for="InputProgramComponent" class="card-heading py-3">Contact #</label>
                  <p class="card-text">{{ $proponent->contact_no }}</p>
              </div>
              <div class="col-6 form-group text-left">
                <label for="InputProgramComponent" class="card-heading py-3">Gender</label>
                <p class="card-text">{{ $proponent->gender }}</p>
            </div>
              </div>
  
              <div class="d-flex">
              
                <div class="col-6 form-group text-left">
                  <label for="InputDateCompleted" class="card-heading py-3">Employee Type</label>
                  <p class="card-text">{{ $proponent->type }}</p>
              </div>

              <div class="col-6 form-group text-left">
                <label for="InputProgjectCost" class="card-heading py-3">Position</label>
                <p class="card-text">{{ $proponent->position }}</p>
            </div>

              </div>
  
              <div class="d-flex">
                <div class="col-6 form-group text-left">
                <label for="InputResearchMember" class="card-heading py-3">College</label>
                <p class="card-text">{{ $proponent->college }}</p>
              </div>

              <div class="col-6 form-group text-left">
                <label for="InputOutputDeliverables" class="card-heading py-3">Department</label>
                <p class="card-text">{{ $proponent->department }}</p>
              </div>
              </div>
     

  </div>
  </div>
</div>



<!-- Logout Modal -->
<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="logoutModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <img src="{{ asset('img/logo/logout.svg') }}" class="navbar-logout-icon"><span class="modal-title" id="logoutModalLabel"> LOGOUT ?</span>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body text-center">
        <p>Are you sure you want to <span class="colored">LOGOUT</span> into your account now?</p>
        <form action="{{ route('logout') }}" method="post">
          @csrf
          <input type="hidden" name="logout">
          <button type="submit" class="btn btn-primary">Yes</button>
        </form>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>

      </div>
    </div>
  </div>
</div>

<!-- Patented Modal Add -->
<div class="modal fade" id="patentedAddModal" tabindex="-1" role="dialog" aria-labelledby="patentedAddModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <span class="modal-title" id="patentedAddModalLabel"><i class="fas fa-plus-circle pr-2"></i>Add Patented</span>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <div class="modal-body ">
        {{-- <form class="proposal-form" action="{{ route('faculty-profile-view', $proponent->id) }}" method="POST">
          @csrf --}}

        <div class="form-group text-left">
          <label for="InputNameofCommercialProduct" class="modal-title-header pb-2">Name of Commercial Product</label>
          <input type="text" class="form-control" id="InputNameofCommercialProduct" placeholder="Enter Commercial Product" name="product_name" required>
        </div>
       
        <div class="form-group text-left">
          <label for="InputUtilizationInvention" class="modal-title-header pb-2">Utilization of Invention</label>
          <input type="text" class="form-control" id="InputUtilizationInvention" placeholder="Enter Utilization Invention" name="utilization" required>
        </div>

        <div class="d-flex col-12 px-0">
          <div class="form-group text-left col-6 pl-0 ml-0">
            <label for="InputPatentNumber" class="modal-title-header pb-2">Patent Number</label>
            <input type="text" class="form-control" id="InputPatentNumber" placeholder="Enter Patent Number" name="patent_no" required>
          </div>

          <div class="form-group text-left col-6">
            <label for="InputDateIssue" class="modal-title-header pb-2">Date of Issue</label>
            <input type="date" class="form-control" id="InputDateIssue" placeholder="Enter Date of Issue" name="date_issue"required>
          </div>
        </div>
      </div>
        <button class="btn btn-lg btn-primary btn-block text-uppercase my-4 float-right" type="submit">CREATE</button> 
        </form>
    </div>
  </div>
</div>


        <div class="modal fade" id="awardsModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add Award</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <form action="{{ route('faculty-view-profile',$user->id) }}" method="post">
                  @csrf
                  <div class="form-group">
                    <label for="year" class="col-form-label">Year:</label>
                    <input type="text" class="form-control" id="recipient-name" name="year">
                  </div>
                  <div class="form-group">
                    <label for="award-name" class="col-form-label">Award's Name:</label>
                    <input type="text" class="form-control" id="award-name" name="name">
                  </div>
                  <button type="submit" class="btn btn-primary float-lg-right">Add</button>
                  <button type="button" class="btn btn-secondary float-lg-right" data-dismiss="modal">Close</button>
                </form>
              </div>
            </div>
          </div>
        </div>



@stop