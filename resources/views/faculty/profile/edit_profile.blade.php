@extends('index')

@section('navbar')
<nav class="navbar navbar-light fixed-top bg-light p-0 shadow">
  <div class="container-fluid">
    <div class="py-3 m-0">
     <a href="{{ route('faculty-rbp') }}"><img src="{{ asset('img/logo/RMO-logo.png') }}" class="navbar-office-logo"></a>
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
        <a href="{{ route('faculty-view-profile',$user->id) }}"><p class="sidebar-user-name">{{ $user->fullname }}</p></a>
            <p class="sidebar-user-email">{{ $user->email }}</p>
          </div>
        </div>

        <x-navbar.faculty :active="$active">
        </x-navbar.faculty>

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
                    <h1 class="page-heading mt-3"><ion-icon name="settings-outline" size="large"></ion-icon> Edit Profile</h1>    
                </div>
              </div>
            </div>
            <!-- End of Content Header -->

            @if(session('success'))
            <div class="alert alert-success alert-dismissible">
              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
              <p class="card-alert-text"><i class="icon fas fa-info-circle"></i> {!! \Session::get('success') !!}</p>
            </div>
          @endif
  
            <!-- Start of content table -->
          <div class="container-fluid">
            <div class="card table-container">
              <div class="card-body card-body-proposal">
                <form class="proposal-form" action="{{ route('faculty-edit-profile', auth()->user()->id) }}" method="POST" enctype="multipart/form-data">
                   @csrf 
                   @method('PUT')
                  <div class="row py-3">
                    <div class="col-xl-6 ml-4">
                        
                      <div class="proposal-file-link ml-5 pt-3 pb-5">
                        <h3 class="card-heading pb-3">Profile Picture</h3>
                        <div class="text-center file-upload picexist m-0 filePicWidth filePicHeight">
                          <div class="file-upload-cont filePicWidth">
                            <label >
                              <input type="file" name="fileInputPic" class="inputFile" accept="image/png, image/gif, image/jpeg">
                              <svg id="upload-icon" xmlns="http://www.w3.org/2000/svg" width="58.374" height="58.374" viewBox="0 0 58.374 58.374">
                                <path id="Path_737" data-name="Path 737" d="M0,0H58.374V58.374H0Z" fill="none"/>
                                <path id="Path_738" data-name="Path 738" d="M47.064,18.691a18.223,18.223,0,0,0-34.051-4.864,14.587,14.587,0,0,0,1.581,29.089H46.212a12.126,12.126,0,0,0,.851-24.225Zm-13.012,7.2v9.729H24.322V25.89h-7.3L29.187,13.729,41.348,25.89Z" transform="translate(0 5.729)" fill="#800000"/>
                              </svg>      
                              <img src="{{ asset('/img/users/'.$proponent->image) }}" height="100%" width="100%" id="facultyPic" >                      
                              <p class="m-0 colored">Upload Picture</p>
                            </label>  
                          </div>
                        </div>
                      </div>
  
                      <div class="form-group text-left pt-0">
                        <label for="InputFirstName" class="card-heading py-3">First Name</label>
                        <div class="input-group" id="InputEmployeeType">
                          <input type="text" class="form-control" id="InputFirstName" placeholder="Enter First name" name="firstname" value="{{ $proponent->firstname }}" required>
                        </div>
                      </div>
  
                      <div class="form-group text-left pt-0">
                        <label for="InputMiddleName" class="card-heading py-3">Middle Name</label>
                        <div class="input-group" id="InputEmployeePosition">
                          <input type="text" class="form-control" id="InputMiddleName" placeholder="Enter Middle Name" name="middlename" value="{{ $proponent->middlename }}">
                        </div>
                      </div>
  
                      <div class="form-group text-left pt-0">
                        <label for="InputLastName" class="card-heading py-3">Last Name</label>
                        <div class="input-group" id="InputEmployeeDepartment">
                          <input type="text" class="form-control" id="InputLastName" placeholder="Enter Last Name" name="lastname" value="{{ $proponent->lastname }}" required>
                        </div>
                      </div>
  
                      <div class="form-group text-left pt-0">
                        <label for="InputSuffix" class="card-heading py-3">Suffix</label>
                        <div class="input-group" id="InputEmployeeDepartment">
                          <input type="text" class="form-control" id="InputSuffix" placeholder="Enter Suffix" name="suffix" value="{{ $proponent->suffix }}">
                        </div>
                      </div>
  
  
                    </div>
                    
                    <div class="col-xl-5 ml-5">
                      <div class="form-group text-left">
                        <label for="InputEmployeeNo" class="card-heading py-3">Employee No.</label>
                        <div class="input-group" id="InputFirstName">
                          <input type="text" class="form-control" id="InputEmployeeNo" placeholder="Enter Employee Number" name="employee_no" value="{{ $proponent->employee_no }}" required>
                        </div>
                      </div>
  
                      <div class="form-group text-left">
                        <label for="InputMail" class="card-heading py-3">Email</label>
                        <div class="input-group" id="InputMiddleName">
                          <input type="text" class="form-control" id="InputMail" placeholder="Enter Email" name="email" value="{{ $proponent->email }}" required>
                        </div>
                      </div>
  
                      <div class="form-group text-left">
                        <label for="InputMobileNo" class="card-heading py-3">Mobile No.</label>
                        <div class="input-group" id="InputLastName">
                          <input type="text" class="form-control" id="InputMobileNo" placeholder="Enter Mobile Number" name="contact" value="{{ $proponent->contact }}" required>
                        </div>
                      </div>
  
                      <!--==============================-->
                      <div class="form-group text-left pt-5">
                        <label for="InputEmployeeGender" class="card-heading py-3">Gender</label>
                        <div class="input-group" id="InputLastName">
                            <select class="form-control" id="employee-type-form" name="gender">
                                @if($proponent->gender == "Male")
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                @else
                                <option value="Female">Female</option>
                                <option value="Male">Male</option>
                                @endif    
                              </select>
                          </div>
                      </div>
  
                      <div class="form-group text-left">
                        <label for="InputEmployeeType" class="card-heading py-3"
                          >Employee Type</label
                        >
                        <select class="form-control" id="employee-type-form" name="employee_type">
                          @foreach ($type as $item)
                            @if ($proponent->employee_type == $item->type) 
                              <option value="{{ $item->type }}" selected>{{ $item->type }}</option>
                            @else
                              <option value="{{ $item->type }}">{{ $item->type }}</option>
                            @endif
                          @endforeach
                        </select>
                      </div>
                      
                      <div class="form-group text-left">
                        <label for="InputFacultyPosition" class="card-heading py-3"
                          >Faculty Position</label
                        >
                        
                        <select class="form-control" id="faculty-position-form" name="position">
                          @foreach ($position as $item)
                            @if ($proponent->position == $item->position) 
                              <option value="{{ $item->position }}" selected>{{ $item->position }}</option>
                            @else
                              <option value="{{ $item->position }}">{{ $item->position }}</option>
                            @endif
                          @endforeach
                        </select>
                      </div>
                      
                      <div class="form-group text-left">
                        <label for="InputDepartment" class="card-heading py-3">Department</label>
                        <select class="form-control" name="department">
                          <option hidden>Enter department</option>
                          @foreach ($departments as $item)
                            @if ($proponent->department == $item->name)
                                <option value="{{ $item->name }}" selected>{{ $item->name }}</option>       
                            @else
                                <option value="{{ $item->name }}">{{ $item->name }}</option>           
                            @endif
                          @endforeach
                        </select>
                      </div>
                      
  
                     <!-- <div class="form-group text-left">
                        <label for="InputEmployeeType" class="card-heading py-3">Employee Type</label>
                        <select class="form-control">
                          <option hidden>Enter employee type </option>
                          <option value="Regular">Regular</option>
                          <option value="Part-Timer">Part-Timer</option>
                        </select>
                      </div>-->
  
                      <button type="submit" class="btn btn-primary px-5 my-5 float-right">UPDATE</button>
                  </div>
  
                  
  
  
  
              </div>
  
  
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