@extends('index')

@section('content')
<body class="ms-fill">
    <nav class="navbar navbar-light fixed-top bg-light p-0 shadow">
        <div class="container-fluid">
          <div class="py-3 m-0">
           <a href="{{ route('rmo-rbp') }}"><img src="{{ asset('./img/logo/rmo-logo.png') }}" class="navbar-office-logo"></a>
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
              <img src="{{ asset('img/users/'.$user->image) }}" height="auto" width="80px" class="my-auto pr-2"/> 
              <div class="sidebar-user-container m-auto">
                @if ($user->type == "Faculty")
                   <a href="">   <p class="sidebar-user-name">{{ auth()->user()->fullname }}</p> </a>
                      <p class="sidebar-user-email">{{ auth()->user()->email }}</p>
                @elseif ($user->type == "College")
                      <p class="sidebar-user-name">{{ auth()->user()->office_name }}</p>
                      <p class="sidebar-user-email">{{ auth()->user()->email }}</p>
                @elseif ($user->type == "Chancellor")
                      <p class="sidebar-user-name">Office of the Chancellor</p>
                      <p class="sidebar-user-email">{{ auth()->user()->email }}</p>
                @else
                      <p class="sidebar-user-name">RMO</p>
                      <p class="sidebar-user-email">{{ auth()->user()->email }}</p>
                @endif
                  </div>
              </div>

              <x-navbar.rmo :active="$active"></x-navbar.rmo>
        </div>
            <!-- Page content wrapper-->
            <div id="page-content-wrapper">
              <!-- Content Header -->
              <div class="container-fluid">
                <!-- Page Title -->
                <h1 class="page-heading mt-2"><ion-icon name="people-outline" size="large"></ion-icon> Faculty</h1>
                <!-- Search and Create Button -->
                <div class="content-header">
                  <div class="container-fluid">
                    <div class="row mb-2">
                      <div class="col-sm-6 pl-0">
    
                          <form action="#" class="search-form">
                            <input type="text" class="search-control form-control" placeholder="Search here" name="search">
                            <button type="submit" class="search-btn btn btn-primary"><i class="fa fa-search"></i></button>
                          </form>
    
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              {{-- @include('backend.faculties.create_faculty') --}}
              <!-- End of Content Header -->
              @if(session('updated'))
              <div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">??</button>
                <p class="card-alert-text"><i class="icon fas fa-info-circle"></i> {!! \Session::get('updated') !!}</p>
              </div>
            @endif
        
            @if (session('success'))
            <div class="alert alert-success alert-dismissible">
              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">??</button>
              <p class="card-alert-text"><i class="icon fas fa-info-circle"></i> {!! \Session::get('success') !!}</p>
            </div>
          @endif
            @if(session('alert'))
              <div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">??</button>
                <p class="card-alert-text"><i class="icon fas fa-info-circle"></i> {!! \Session::get('alert') !!}</p>
              </div>
            @endif
              <!-- Start of content table -->
                <div class="container-fluid py-2">
                  <div class="card table-container">
                    <div class="card-header">
                      <h3 class="table-heading">List of Faculty</h3>
                    </div>
                    <div class="card-body">
                    <table class="table bg-white">
                      <thead>
                        <tr>
                          <th scope="col" width="25%">Name</th>
                          <th scope="col">Email</th>
                          <th scope="col">College</th>
                          <th scope="col">Employee Type</th>
                          <th scope="col">Plantilla Position</th>
                        </tr>
                      </thead>
                      <tbody>
                        
                        @if ($faculties->count())
                          @foreach ($faculties as $faculty)
                          {{-- <tr class="clickable-row unread" data-href="{{ url('/college/faculties/view/'.$faculty->id) }}"> --}}
                          {{-- <tr data-url="{{ route('college-faculty-delete', $faculty->id) }}"> --}}
                            <tr class="clickable-row unread" data-href="{{ url('/rmo/faculties/view/'.$faculty->id) }}">
                              <td class="d-flex p-2"> 
                                <!-- If no picture/logo -->
                                {{-- <div class="member-logo my-auto mr-2">JD</div> --}}
                                <!-- else if have picture/logo -->
                                <img src="{{ asset('/img/faculty/' . $faculty->image) }}" height="auto" width="80px" class="my-auto pr-2"/>
                                <div class="member-list my-auto">
                                  <p class="mb-0">{{ $faculty->fullname }}</p>
                                  <span class="d-block">{{ $faculty->employee_no }}</span>
                                </div>
                              </td>
                              <td>{{ $faculty->email }}</td>
                              <td>{{ $faculty->college }}</td>
                              <td>{{ $faculty->employee_type }}</td>
                              <td>{{ $faculty->position }}</td>
                            </tr>
                      
                          @endforeach
                        @else
                          <td colspan="7" class="text-center td-noproposals">No Faculty</td>
                        @endif
                      </tbody>
                     
                    </table>
                    </div>
                    <div class="card-footer">
                      <nav aria-label="Pagination" class="float-right">
                        <ul class="pagination">
                          {!!  $faculties->links() !!}
                        </ul>
                      </nav>
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




