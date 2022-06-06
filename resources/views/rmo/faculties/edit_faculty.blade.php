@extends('index')

@section('content')
<body class="ms-fill">
    <nav class="navbar navbar-light fixed-top bg-light p-0 shadow">
        <div class="container-fluid">
          <div class="py-3 m-0">
           <a href="{{ route('rmo-research') }}"><img src="{{ asset('./img/logo/rmo-logo.png') }}" class="navbar-office-logo"></a>
            </div>
          <div class="navbar-nav px-3">
              <a class="text-center navbar-nav-text" href="#logoutModal" type="button" data-toggle="modal"><img src="{{ asset('./img/logo/logout.svg') }}" class="navbar-logout-icon"><p class="mb-0 mt-1">Logout</p></a>
          </div>
        </div>
      </nav>
      <div class="d-flex wrapper" id="wrapper">
        <!-- Sidebar-->
        <div class="border-end" id="sidebar-wrapper">
            <button class="navbar-toggler toggler-example sidebar-btn" id="sidebarToggle" type="button" data-toggle="collapse" data-target="#navbarSupportedContent1"
            aria-controls="navbarSupportedContent1" aria-expanded="false" aria-label="Toggle navigation"><span class="dark-blue-text"><i
                class="fas fa-angle-left fa-1x"></i></span></button>
                <div class="sidebar-heading px-3 mt-4 text-muted row">
                  <!-- If no picture/logo -->
                  <!-- <div class="member-logo my-auto mr-2">C</div> -->
                  <!-- else if have picture/logo -->
                  <img src="../img/COE.png" height="auto" width="80px" class="my-auto pr-2"/> 
                    <div class="sidebar-user-container m-auto">
                        <p class="sidebar-user-name">{{ auth()->user()->name }}</p>
                        <p class="sidebar-user-email">{{ auth()->user()->email }}</p>
                    </div>
                  </div>
    
            <nav id="sidebar">
              <div class="pt-3">
    
                <ul class="nav flex-column list-group">
                  <li class="nav-item " >
                    <a class="nav-item-link" href="{{ route('rmo-research') }}"><ion-icon name="grid-outline" size="large"></ion-icon> Dashboard</a>
                  </li>
      
                  <li class="nav-item ">
                    <a class="nav-item-link" href="{{ route('rmo-pending') }}"><ion-icon name="people-outline" size="large"></ion-icon> Pending </a>
                  </li>
      
                  <li class="nav-item active">
                    <a class="nav-item-link" href="{{ route('rmo-faculty') }}"><ion-icon name="people-outline" size="large"></ion-icon> Researchers</a>
                  </li>
      
                  <li class="nav-item">
                    <a class="nav-item-link" href="{{ route('rmo-generate-sheet') }}"><ion-icon name="person-outline" size="large"></ion-icon> Generate Summary Sheet</a>
                  </li>
      
                  <li class="nav-item ">
                    <a class="nav-item-link" href="{{ route('rmo-generate-report') }}"><ion-icon name="people-outline" size="large"></ion-icon> Generate Report </a>
                  </li>
      
      
                  <li class="nav-item">
                    <a class="nav-item-link" href={{ route('rmo-change') }}><ion-icon name="lock-open-outline" size="large"></ion-icon> Change Password</a>
                  </li>
                </ul>
                <!-- <footer class="page-footer font-small rgba-white-slight pt-3 fixed-bottom">
                  <div class="">
                    <a class="nav-item-link" href="drafts.html"><ion-icon name="document-outline" size="large"></ion-icon> Drafts</a>
                  </div>
                </footer>      -->
              </div>
            </nav>
            <footer class="page-footer pt-3">
              <div class="footer-nav-item">
                <a class="footer-nav-item-link" href="https://help.bulsu-ovprde.com/" target="_blank"
                  ><ion-icon name="help-circle-outline" size="large"></ion-icon>Need Help?<span
                    class="footer-subtitle"
                    >Open our Help Center</span
                  ></a
                >
              </div>
            </footer>
        </div>

      <!-- Page content wrapper-->
      <div id="page-content-wrapper">
        <!-- Content Header -->
        <div class="container-fluid">
          <!-- Page Title -->
          <div class="row mb-2">
            <div class="col-sm-9 pl-0">
              <h1 class="page-heading mt-2">
                <ion-icon name="people-outline" size="large"></ion-icon> Researcher
              </h1>
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
        @if($data)
        <!-- Start of content table -->
        <div class="container-fluid py-2">
          <div class="card table-container">
            <div class="card-header">
              <div class="row">
                <div class="col-sm-9">
                  <h3 class="card-heading py-3 d-flex">
                    <ion-icon name="person-outline" size="large"></ion-icon>
                    Update Faculty
                  </h3>
                </div>
              </div>
            </div>
            <div class="card-body card-body-proposal">
              <form class="proposal-form" action="{{ route('rmo-faculty-edit', $data->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="row py-5">
                  <div class="col-xl-6 col-sm-12">
                    <div class="proposal-file-link ml-5 pt-3 pb-5">
                      <h3 class="card-heading pb-4">Profile Picture</h3>
                      <div
                        class="
                          text-center
                          file-upload
                          picexist
                          m-0
                          filePicWidth
                          filePicHeight
                        "
                      >
                        <div class="file-upload-cont filePicWidth">
                          <label>
                            <input
                              type="file"
                              name="fileInputPic"
                              class="inputFile"
                              accept="image/png, image/gif, image/jpeg"
                            />
                            <svg
                              id="upload-icon"
                              xmlns="http://www.w3.org/2000/svg"
                              width="58.374"
                              height="58.374"
                              viewBox="0 0 58.374 58.374"
                            >
                              <path
                                id="Path_737"
                                data-name="Path 737"
                                d="M0,0H58.374V58.374H0Z"
                                fill="none"
                              />
                              <path
                                id="Path_738"
                                data-name="Path 738"
                                d="M47.064,18.691a18.223,18.223,0,0,0-34.051-4.864,14.587,14.587,0,0,0,1.581,29.089H46.212a12.126,12.126,0,0,0,.851-24.225Zm-13.012,7.2v9.729H24.322V25.89h-7.3L29.187,13.729,41.348,25.89Z"
                                transform="translate(0 5.729)"
                                fill="maroon"
                              />
                            </svg>
                            <img
                              src="{{ asset('img/faculty/'.$data->image) }}"
                              height="100%"
                              width="100%" 
                              id="facultyPic"   
                            />
                            <p class="m-0 colored">Upload Picture</p>
                          </label>
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="col-xl-6 col-sm-12">
                    <div class="form-group text-left">
                      <label for="InputFirstName" class="card-heading py-3"
                        >First Name</label
                      >
                      <div class="input-group" id="InputFirstName">
                        <input
                          type="text"
                          class="form-control"
                          id="InputFirstName"
                          placeholder="Enter faculty first name"
                          name="firstname"
                          value="{{ $data->firstname }}"
                          required
                        />
                      </div>
                    </div>

                    <div class="form-group text-left">
                      <label for="InputMiddleName" class="card-heading py-3"
                        >Middle Name</label
                      >
                      <div class="input-group" id="InputMiddleName">
                        <input
                          type="text"
                          class="form-control"
                          id="InputMiddleName"
                          placeholder="Enter faculty middle name"
                          name="middlename"
                          value="{{ $data->middlename }}"
                          required
                        />
                      </div>
                    </div>

                    <div class="form-group text-left">
                      <label for="InputLastName" class="card-heading py-3"
                        >Last Name</label
                      >
                      <div class="input-group" id="InputLastName">
                        <input
                          type="text"
                          class="form-control"
                          id="InputLastName"
                          placeholder="Enter faculty last name"
                          name="lastname"
                          value="{{ $data->lastname }}"
                          required
                        />
                      </div>
                    </div>

                    <div class="form-group text-left pt-5">
                      <label for="InputEmployeeNo" class="card-heading py-3"
                        >Employee No.</label
                      >
                      <div class="input-group" id="InputEmployeeNo">
                        <input
                          type="text"
                          class="form-control"
                          id="InputEmployeeNo"
                          placeholder="Enter employee number"
                          name="employee_no"
                          value="{{ $data->employee_no }}"
                          required
                        />
                      </div>
                    </div>

                    <div class="form-group text-left">
                      <label for="InputEmployeeEmail" class="card-heading py-3"
                        >Employee Email</label
                      >
                      <div class="input-group" id="InputEmployeeEmail">
                        <input
                          type="text"
                          class="form-control"
                          id="InputEmployeeEmail"
                          placeholder="Enter employee email"
                          name="email"
                          value="{{ $data->email }}"
                          required
                        />
                      </div>
                    </div>

                    <div class="form-group text-left">
                      <label for="InputEmployeeType" class="card-heading py-3">Employee Type</label>
                      <select class="form-control" id="employee-type-form" name="employee_type">

                        @if($data->employee_type == 'Regular')
                            <option value="Regular" selected>Regular</option>
                            <option value="Part-Timer">Part-Timer</option>
                            <option value="Permanent">Permanent</option>
                            <option value="Temporary">Temporary</option>
                        @elseif($data->employee_type == 'Part-Timer')
                            <option value="Part-Timer" selected>Part-Timer</option>
                            <option value="Regular">Regular</option>
                            <option value="Permanent">Permanent</option>
                            <option value="Temporary">Temporary</option>
                        @elseif($data->employee_type == 'Permanent')
                            <option value="Permanent" selected>Permanent</option>
                            <option value="Regular">Regular</option>
                            <option value="Part-Timer">Part-Timer</option>
                            <option value="Temporary">Temporary</option>
                        @else
                            <option value="Temporary" selected>Temporary</option>
                            <option value="Regular">Regular</option>
                            <option value="Part-Timer">Part-Timer</option>
                            <option value="Permanent">Permanent</option>

                        @endif
                      </select>
                    </div>


                    <div class="form-group text-left">
                      <label for="InputEmployeeType" class="card-heading py-3">Faculty Position</label>
                      <select class="form-control" id="faculty-position-form" disabled name="position">
                        <option value="{{ $data->position }}">{{ $data->position }} </option>
                        <option value="Instructor I">Instructor I</option>
                        <option value="Instructor II">Instructor II</option>
                        <option value="Instructor III">Instructor III</option>
                        <option value="Instructor IV">Instructor IV</option>
                        <option value="Assistant Professor I">Assistant Professor I</option>
                        <option value="Assistant Professor II">Assistant Professor II</option>
                        <option value="Assistant Professor III">Assistant Professor III</option>
                        <option value="Assistant Professor IV">Assistant Professor IV</option>
                        <option value="Associate Professor I">Associate Professor I</option>
                        <option value="Associate Professor II">Associate Professor II</option>
                        <option value="Associate Professor III">Associate Professor III</option>
                        <option value="Associate Professor IV">Associate Professor IV</option>
                        <option value="Associate Professor V">Associate Professor V</option>
                        <option value="Professor I">Professor I</option>
                        <option value="Professor II">Professor II</option>
                        <option value="Professor III">Professor III</option>
                        <option value="Professor IV">Professor IV</option>
                        <option value="Professor V">Professor V</option>
                        <option value="Professor VI">Professor VI</option>
                        <option value="College University Professor">College University Professor</option>
                      </select>
                      <br><br>
                    <button type="submit" class="btn btn-primary px-5 my-5">
                      UPDATE
                    </button>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
        @endif
      </div>
    </div>

    <!-- Logout Modal -->
    <div
      class="modal fade"
      id="logoutModal"
      tabindex="-1"
      role="dialog"
      aria-labelledby="logoutModalLabel"
      aria-hidden="true"
    >
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <img src="../img/logout.svg" class="navbar-logout-icon" /><span
              class="modal-title"
              id="logoutModalLabel"
            >
              LOGOUT ?</span
            >
            <button
              type="button"
              class="close"
              data-dismiss="modal"
              aria-label="Close"
            >
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body text-center">
            <p>
              Are you sure you want to <span class="colored">LOGOUT</span> into
              your account now?
            </p>
            <button type="button" class="btn btn-primary">Yes</button>
            <button
              type="button"
              class="btn btn-secondary"
              data-dismiss="modal"
            >
              Cancel
            </button>
          </div>
        </div>
      </div>
    </div>
@endsection