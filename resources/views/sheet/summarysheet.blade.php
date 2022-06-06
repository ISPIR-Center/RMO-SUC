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
            <h1 class="page-heading mt-2"><ion-icon name="grid-outline" size="large"></ion-icon> Generate Summary Sheet</h1>
          
          </div>
          <!-- End of Content Header -->
 <!-- Start of content table -->
 <form class="proposal-form" action="{{ route('rmo-view-sheet') }}" method="GET">
  @csrf
  <div class="container-fluid py-2 px-4">
    <div class="card table-container">
      <div class="card-header">
        <h3 class="table-heading pb-4"> </h3>
          <div class="row ">
            <div class="col-lg-6 mb-2">
              <select class="form-control" id="select_form" name="report">
                @foreach ($sheets as $sheet)
                <option value="{{ $sheet->id }}">{{ $sheet->name }}</option>
              @endforeach 
              </select>
            </div>
            <div class="col-lg-6">
              <select id="year" name="year" class="form-control ">
                {{-- {{ $last= date('Y')-10 }} --}}
                {{ $now = date('Y') }}
            
                @for ($i = $now; $i >= "2000"; $i--)
                    <option value="{{ $i }}">{{ $i }}</option>
                @endfor
            </select>
            <br>
            </div>
            <div class="col-lg-3 float-center ">
              <input type="text" class="form-control" id="InputFacultyNo" placeholder="Total No of Plantilla Faculties" hidden name="faculty_no" >
          </div>
        </div>
        <!-- new code here for generate output -->
        <br><br>
        <div class="card-footer pb-3">
            <input type="submit" value="Generate" class="btn btn-generate float-right" id="generateBtn">
            {{-- <button type="submit" class="btn btn-generate float-right">Add Members<i class="fas fa-plus"></i></a></button> --}}
         {{-- <a href="{{ url('/rmo/generate-summarysheet/'.$sheet->id.'/'.$i) }}" class="btn btn-lg btn-light float-right">Generate <i class="fas fa-plus"></i></a> --}}
         {{-- <a href="{{ route('rmo-view-sheet') }}" class="btn btn-lg btn-light float-right">Generate <i class="fas fa-plus"></i></a>
        </div> --}}
      <!-- new code here for generate ouput -->
      </div>
  </div>
</form>
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
        <form action="{{ route('logout') }}" method="POST">
          @csrf
          {{-- <input type="hidden"> --}}
          <button type="submit" class="btn btn-primary">Yes</button>
        </form>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
      </div>
    </div>
  </div>
</div>
@endsection