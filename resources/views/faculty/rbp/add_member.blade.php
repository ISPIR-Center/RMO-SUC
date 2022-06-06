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
        <div class="card-header">
          <div class="row">
            
          </div>
        </div>
        <div class="card-body card-body-proposal">
          <div class="row ml-2 mb-2 py-3">
            <div class="col-xl-6 col-lg-12 pl-0">
              <h3 class="card-heading py-3">Add Proposal Members:</h3>
                <form action="{{ route('faculty-rbp-addmembers', $proposal->id) }}" method="GET" class="search-form">
                  @csrf
                  <input type="text" class="search-control form-control" placeholder="Search Researchers" name="search">
                  <button type="submit" class="search-btn btn btn-primary"><i class="fa fa-search"></i></button>
                </form>
            </div>
          </div>

          <div class="row">
            <div class="col-xl-6 col-lg-12">
              <div class="ml-2 pt-3 pb-5">
                <div class="card listing-container p-1">
                  <div class="card-body">
                  <table class="table table-rounded">
                    <thead>
                      <tr>
                        <th  class="py-3" scope="col" width="75%">Proponent Information</th>
                        <th  class="py-3" scope="col" width="25%">Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      @if($search) 
                        @if ($faculties->count())
                          @foreach ($faculties as $item)
                            <tr>
                              <td class="d-flex p-1 pl-2">
                                <img src="{{ asset('img/faculty/'. $item->image) }}" height="auto" width="80px" class="my-auto pr-2"/>
                                <div class="member-list my-auto">
                                  <p class="mb-0">{{ $item->fullname }}</p>
                                  <span class="d-block">{{ $item->email }}</span>
                                  <span class="d-block">{{ $item->employee_no }}</span>
                                </div>
                              </td>

                              <form action="{{ route('addmember',[$proposal->id, $item->id]) }}" method="POST">
                                @csrf
                                <input type="hidden" name="employee_no" value="{{ $item->employee_no }}">
                                <input type="hidden" name="fullname" value="{{ $item->fullname }}">
                                <input type="hidden" name="email" value="{{ $item->email }}">
                                <input type="hidden" name="college" value="{{ $item->college }}">
                                @if ($added->contains('employee_no',$item->employee_no))
                                  <td class="p-2"> <button class="btn btn-sm btn-primary btn-remove ml-auto my-auto px-3 added"><i class="fas fa-plus"></i> ADDED</button></td>
                                @else
                                  <td class="p-2"> <button type="submit" class="btn btn-sm btn-primary btn-remove ml-auto my-auto px-3"><i class="fas fa-plus"></i> ADD</button></td>
                                @endif
                              </form>
                            </tr>
                          @endforeach
                        @else
                        <td colspan="2" class="text-center td-noproposals">No Data to Display.</td>
                        @endif
                      @else
                        @if($faculties->count())
                          @foreach ($faculties as $item)
                          
                          <tr>
                            <td class="d-flex p-2 pl-2">
                              <img src="{{ asset('img/users/'. $item->image) }}" height="80px" width="80px" class="rounded-circle my-auto"/>
                              <div class="member-list my-auto">
                                <p class="mb-0">{{ $item->fullname }}</p>
                                <span class="d-block">{{ $item->email }}</span>
                                <span class="d-block">{{ $item->employee_no }}</span>
                              </div>
                            </td>
                            <form action="{{ route('faculty-addmember',[$proposal->id, $item->id]) }}" method="POST">
                              @csrf
                              <input type="hidden" name="employee_no" value="{{ $item->employee_no }}">
                              <input type="hidden" name="fullname" value="{{ $item->fullname }}">
                              <input type="hidden" name="email" value="{{ $item->email }}">
                              <input type="hidden" name="type" value="{{ $item->type }}">
                              <input type="hidden" name="college" value="{{ $item->college }}">
                              @if ($added->contains('employee_no',$item->employee_no))
                                <td class="p-2"> <button class="btn btn-sm btn-primary btn-remove ml-auto my-auto px-3 added"><i class="fas fa-plus"></i> ADDED</button></td>
                              @else
                                <td class="p-2"> <button type="submit" class="btn btn-sm btn-primary btn-remove ml-auto my-auto px-3"><i class="fas fa-plus"></i> ADD</button></td>
                              @endif

                            </form>
                          </tr>
                          @endforeach
                        @else
                          <td colspan="2" class="text-center td-noproposals">No Data to Display.</td>
                        @endif
                      @endif
                    </tbody>
                  </table>
                  <div class="card-footer p-1">
                    <nav aria-label="Pagination" class="float-right ">
                      <ul class="pagination my-auto">
                        {!!  $faculties->links() !!}
                      </ul>
                    </nav>
                  </div>
                  </div>
                </div>
              </div>
            </div>

            <div class="col-xl-6 col-lg-12" >
              <div class="ml-2 pt-3 pb-5">
                <div class="card listing-container p-1">
                  <div class="card-body overflow-auto" style="max-height:68vh">
                  <table class="table table-rounded" >
                    <thead class="sticky-top">
                      <tr>
                        <th  class="py-3" scope="col" width="75%">Proposal Members Added</th>
                        <th  class="py-3" scope="col" width="25%">Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      @if ($proposalMember->count())
                      @foreach ($proposalMember as $item)
                      <tr>
                        <td class="d-flex p-1">
                          <div class="member-list my-auto">
                            <p class="mb-0">{{ $item->fullname }}</p>
                            <span class="d-block">{{ $item->email }}</span>
                            <span class="d-block">{{ $item->employee_no }}</span>
                          </div>
                        </td>
                        
                        <form action="{{ route('faculty-rbp-deletemember',[$proposal->id, $item->user_id]) }}" method="POST">
                          @csrf
                          @method('DELETE')
                            <td class="p-2"> <button class="btn btn-danger btn-remove"><i class="fas fa-trash"></i> REMOVE</button></td>
                        </form>
                      </tr>
                    @endforeach
                      @else
                        <td colspan="2 bg-transparent" class="text-center td-noproposals">No Data to Display.</td>
                      @endif
                    </tbody>
                  </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
<div class="card-footer py-4">
<a href="{{ route('faculty-rbp-view', $proposal->id) }}" class="btn btn-primary float-right submit-proposal-btn"><i class="fas fa-check-circle"></i> DONE</a>
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