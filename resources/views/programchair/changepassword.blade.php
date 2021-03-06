@extends('index')

@section('navbar')
<nav class="navbar navbar-light fixed-top bg-light p-0 shadow">
  <div class="container-fluid">
    <div class="py-3 m-0">
    <a href="{{ route('programchair-rbp') }}"><img src="{{ asset('img/logo/RMO-logo.png') }}" class="navbar-office-logo"></a>
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
        <img src="{{ asset('/img/users/'.$user->image) }}" height="auto" width="80px" class="my-auto pr-2"/> 
          <div class="sidebar-user-container m-auto">
            <p class="sidebar-user-name">{{ $user->fullname }}</p>
            <p class="sidebar-user-email">{{ $user->email }}</p>
          </div>
        </div>

        <x-navbar.program-chair :active="$active">
        </x-navbar.program-chair>
        
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
                <div class="col-sm-9 pl-0">
                  <h1 class="page-heading mt-2"><ion-icon name="settings-outline" size="large"></ion-icon> Manage Account</h1>    
                </div>
              </div>
            </div>
            <!-- End of Content Header -->
            @if(session('success'))
                <div class="alert alert-success alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">??</button>
                    <p class="card-alert-text"><i class="icon fas fa-info-circle"></i> Password Changed</p>
                </div>
            @endif
            @if(session('alert'))
                <div class="alert alert-danger alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">??</button>
                    <p class="card-alert-text"><i class="icon fas fa-info-circle"></i> Invalid Credentials.</p>
                </div>
            @endif

            @error('password')
            <div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">??</button>
                <p class="card-alert-text"><i class="icon fas fa-info-circle"></i> New password does'nt match.</p>
            </div>
            
        @enderror
            <!-- Start of content table -->
            <div class="container-fluid py-2">
              <div class="card table-container">
                <div class="card-header">
                  <div class="row">
                    <div class="col-sm-9">
                      <h3 class="card-heading py-3 d-flex"><ion-icon name="lock-open-outline" size="large"></ion-icon> Change Password</h3>
                    </div>
                  </div>
                </div>
                <div class="card-body card-body-proposal">

            <form class="proposal-form" action="{{ route('programchair-change') }}" method="POST">
                @csrf
                @method('PUT')
                <div class="row pb-5">
                    <div class="col-xl-7 col-sm-12">
                    <div class="form-group text-left">
                        <label for="InputCurrentPassword" class="card-heading py-3">Current Password:</label>
                        <div class="input-group" id="InputCurrentPassword">
                        <input type="password" class="form-control" id="InputCurrentPassword" name="currentpw" placeholder="Enter your current password" required>
                        <div class="input-group-addon">
                            <a href=""><i class="fa fa-eye-slash" aria-hidden="true"></i></a>
                        </div>
                        </div>
                    </div>
                </div>

                    <div class="col-xl-7 col-sm-12">
                    <div class="form-group text-left">
                        <label for="InputNewPassword" class="card-heading py-3">New Password:</label>
                        <div class="input-group" id="InputNewPassword">
                        <input type="password" class="form-control" id="InputNewPassword" name="password" placeholder="Enter your new password" required>
                        <div class="input-group-addon">
                            <a href=""><i class="fa fa-eye-slash" aria-hidden="true"></i></a>
                        </div>
                        </div>
                    </div>
                </div>
                

                <div class="col-xl-7 col-sm-12">
                    <div class="form-group text-left">
                    <label for="InputConfirmPassword" class="card-heading py-3">Confirm Password:</label>
                    <div class="input-group" id="InputConfirmPassword">
                        <input type="password" class="form-control" id="InputConfirmPassword" name="password_confirmation" placeholder="Enter your new password" required>
                        <div class="input-group-addon">
                        <a href=""><i class="fa fa-eye-slash" aria-hidden="true"></i></a>
                        </div>
                    </div>
                    </div>
                </div>

                </div>
                <button type="submit" class="btn btn-primary px-4 mb-5">CHANGE PASSWORD</button>
  
            </form>
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
@stop