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
                <h1 class="page-heading mt-2"><ion-icon name="person-outline" size="large"></ion-icon> Researcher</h1>
                <!-- Search and Create Button -->
                <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                      <img src="{{ asset('/img/faculty/' . $faculties->image) }}" height="auto" width="80px" class="my-auto pr-2"/>
                      <!-- else if have picture/logo -->
                      <!-- <img src="../img/dict-logo.png" height="auto" width="80px" class="my-auto pr-2"/>  -->
                      <div class="member-list my-auto">
                      <p class="mb-0">{{ $faculties->firstname }} {{ $faculties->middlename }} {{ $faculties->lastname }} {{ $faculties->suffix }}</p>
                      <span class="d-block">{{ $faculties->email }}</span>
                      <span class="d-block">Proposal Leader Count: <b>{{ $leader }}</b></span>
                      <span class="d-block">Proposal Member Count: <b>{{ $member }}</b></span>
                      <span class="d-block">Proposal Total Count: <b>{{ $total }}</b></span>
                      </div>
                    {{-- <div class="col-lg-9 col-12 pl-0">
    
                        <form action="#" class="search-form">
                            <input type="text" class="search-control form-control" placeholder="Search Proposal .." name="search">
                            <button type="submit" class="search-btn btn btn-primary"><i class="fa fa-search"></i></button>
                        </form>
    
                    </div> --}}
                    {{-- <div class="col-lg-3 col-12">
                        {{-- <a href="{{ route('create') }}" class="btn btn-lg btn-light float-lg-right">CREATE <i class="fas fa-plus"></i></a> 
                    </div> --}}
                    </div>
                </div>
                </div>
            </div>
            <!-- End of Content Header -->
    
            <!-- Start of content table -->
            <div class="container-fluid py-2">
              <div class="card table-container">
                <div class="card-header">
                  <h3 class="table-heading">List of Researches</h3>
                </div>
                <div class="card-body">
                <table class="table table-hover bg-white">
                  <thead>
                    <tr>
                      <th scope="col">Proposal Title</th>
                      <th scope="col">Leader</th>
                      <th scope="col">Deliverables</th>
                      <th scope="col">Discipline Covered</th>
                      <th scope="col">Status</th>
                      <th scope="col">Date</th>
                    </tr>
                  </thead>
                  <tbody>
                    @if ($proposals->count())
                      @foreach ($proposals as $proposal)
                        <tr class="clickable-row unread" data-href="{{ url('/rmo/rbp/view/'.$proposal->id) }}">
                        
                            <td class="tblink" >{{ $proposal->title }}</td>
                            <td >{{ $proposal->leader }}</td>
                            <td >{{ $proposal->research_deliverables }} </td>
                            <td >{{ $proposal->research_discipline_covered }} </td>
                            @if ($proposal->is_presented =="1" and $proposal->is_published =="0" and $proposal->status =="COMPLETED")
                              <td><span class="badge status-ongoing">PRESENTED</span></td>
                              @elseif ($proposal->is_published =="1" and $proposal->is_presented =="0" and $proposal->status =="COMPLETED")
                              <td><span class="badge status-compliant">PUBLISHED</span></td>
                              @elseif ($proposal->is_utilized =="1" and $proposal->is_patented =="0" and $proposal->status =="COMPLETED")
                              <td><span class="badge status-noncompliant">UTILIZED</span></td>
                              @elseif ($proposal->is_patented =="1" and $proposal->is_utilized =="0" and $proposal->status =="COMPLETED")
                              <td><span class="badge status-completed">PATENTED</span></td>
                              @elseif ($proposal->is_utilized =="1" AND $proposal->is_patented =="1" and $proposal->status =="COMPLETED")
                              <td><span class="badge status-pending">UTILIZED & PATENTED</span></td>
                              @elseif ($proposal->is_published =="1" AND $proposal->is_presented =="1" and $proposal->status =="COMPLETED")
                              <td><span class="badge status-draft">PUBLISHED & PRESENTED</span></td>
                              @elseif ($proposal->is_published =="1" AND $proposal->is_presented =="1" and $proposal->status =="COMPLETED")
                              <td><span class="badge status-forrevision">PENDING</span></td>
                              @else
                              <td><span class="badge status-inprogress">COMPLETED</span></td>
                              @endif
                            <td style="width: 15%">{{ $proposal->date_completed }}</td>

                        </tr>
                      @endforeach
                    @else
                        <td colspan="7" class="text-center td-noproposals">No Researches</td>
                    @endif
                    
                  </tbody>
                </table>
                </div>
                <div class="card-footer">
                  <nav aria-label="Pagination" class="float-right">
                    <ul class="pagination">
                      {!!  $proposals->links() !!}
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
      
      
          <!-- Delete Modal -->
          <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModal" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <span class="modal-title" id="deleteModal"><i class="fa fa-edit"></i> DELETE ?</span>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body text-center">
                  <p>Are you sure you want to <span class="colored">DELETE</span> this faculty?</p>
                  <a href="#" class="btn btn-primary">Yes</a>
                  <a href="#" class="btn btn-secondary" data-dismiss="modal">Cancel</a>
                </div>
              </div>
            </div>
          </div>
@endsection