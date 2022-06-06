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
             <div class="col-sm-9">
               <h3 class="card-heading py-3 d-flex"><ion-icon size="large"></ion-icon> Invention: </h3> 
  
            </div> 
          </div>
        </div>
        <div class="card-body card-body-proposal">
          <form class="proposal-form" action="{{ route('faculty-invention-create') }}" method="POST" enctype="multipart/form-data">
            @csrf
            {{-- @method('POST') --}}
            <div class="row py-1">
              <div class="col-xl-6 ml-4">
                @error('title')
                  {{ $message }}
                   @enderror
                  <div class="form-group text-left">
                    <label for="InputResearchTitle" class="card-heading py-3">Research Title*</label>
                    <input type="text" class="form-control" id="InputResearchTitle" placeholder="" name="title" required>
                  </div>

              <div class="d-flex ">
                <div class="form-group text-left col-xl-6 px-0">
             
                  <label for="InputProgramComponent" class="card-heading py-3"> Program Component* </label>
                  <div class="input-group" id="InputProgramComponent">
                    <input type="text" class="form-control" id="InputProgramComponent" placeholder=""  name="research_program_component" required>
                  </div>
                </div>
                
                @error('research_funding_agency')
                {{ $message }}
               @enderror
                <div class="form-group text-left col-xl-6 px-0 ml-2">
                  <label for="InputFund" class="card-heading py-3"> Funding Agency* </label>
                  <div class="input-group" id="InputFund">
                     <input type="text" class="form-control" id="InputFund" placeholder="" name="research_funding_agency" required>
                  </div>
                </div>
                </div>
            
            </div>
              
            
              <div class="col-xl-5 ml-5">
                

              @error('budget')
                    {{ $message }}
              @enderror
              <div class="d-flex ">
                <div class="form-group text-left col-xl-6 px-0">
                  <label for="InputProjectCost" class="card-heading py-3">Project Cost(PHP)*</label>
                    <input type="text" class="form-control" id="InputProjectCost" name="budget" required>
                </div>
                
                @error('research_date_completed')
                {{ $message }}
               @enderror
                <div class="form-group text-left col-xl-6 px-0 ml-2">
                  <label for="InputDateCompleted" class="card-heading py-3"> Date Completed* </label>
                  <div class="input-group" id="InputDateCompleted">
                     <input type="date" class="form-control" id="InputDateCompleted" placeholder="" name="research_date_completed" required>
                  </div>
                </div>	
                </div>

                @error('research_discipline_covered')
                {{ $message }}
               @enderror
                <div class="form-group text-left col-xl-6 px-0 ml-2">
                  <label for="InputDiscipline" class="card-heading py-3">Discipline Covered*</label>
              <select name="research_discipline_covered" id="research_discipline_covered" class="form-control">
                <option hidden>Select here</option>
                @foreach ($research_discipline_covered as $discipline_cov)
                <option value="{{ $discipline_cov->name }}">{{ $discipline_cov->name }}</option>
                @endforeach 
              </select>
                </div>
               
              </div>

              </div>
             
            </div>

            

            <div class="proposal-files-container mt-4 ml-5">
              <h3 class="card-heading py-3">Attachment Files*: <i class="fas fa-info-circle pl-2"></i></h3>
              <div class="row">

                  <div class="proposal-file-link pt-4 pb-5 px-3 text-center">
                    <div class="text-center file-upload">
                      <div class="file-upload-cont">
                        <label >
                          <input type="file" accept=".pdf" name="fileInputCF" class="inputFile">
                          <svg id="upload-icon" xmlns="http://www.w3.org/2000/svg" width="58.374" height="58.374" viewBox="0 0 58.374 58.374">
                            <path id="Path_737" data-name="Path 737" d="M0,0H58.374V58.374H0Z" fill="none"/>
                            <path id="Path_738" data-name="Path 738" d="M47.064,18.691a18.223,18.223,0,0,0-34.051-4.864,14.587,14.587,0,0,0,1.581,29.089H46.212a12.126,12.126,0,0,0,.851-24.225Zm-13.012,7.2v9.729H24.322V25.89h-7.3L29.187,13.729,41.348,25.89Z" transform="translate(0 5.729)" fill="#1565C0"/>
                          </svg>                          
                          <p class="pt-3" id="fileInputCF">Upload File</p>  
                        </label>
                      </div>
                    </div>
                    <p class="pt-3">Completion File</p>
                  </div>

                  <div class="proposal-file-link pt-4 pb-5 px-3 text-center">
                      <div class="text-center file-upload">
                        <div class="file-upload-cont">
                          <label >
                            <input type="file" accept=".pdf" name="fileInputPCF" class="inputFile">
                            <svg id="upload-icon" xmlns="http://www.w3.org/2000/svg" width="58.374" height="58.374" viewBox="0 0 58.374 58.374">
                              <path id="Path_737" data-name="Path 737" d="M0,0H58.374V58.374H0Z" fill="none"/>
                              <path id="Path_738" data-name="Path 738" d="M47.064,18.691a18.223,18.223,0,0,0-34.051-4.864,14.587,14.587,0,0,0,1.581,29.089H46.212a12.126,12.126,0,0,0,.851-24.225Zm-13.012,7.2v9.729H24.322V25.89h-7.3L29.187,13.729,41.348,25.89Z" transform="translate(0 5.729)" fill="#1565C0"/>
                            </svg>                          
                            <p class="pt-3" id="fileInputPCF">Upload File</p>  
                          </label>
                        </div>
                      </div>
                      <p class="pt-3">Partner Contract/MOA</p>
                    </div>
                    
              </div>
                   
            </div>
{{-- 
            <div class="proposal-members-group pt-5 pb-3">
              <h3 class="card-heading py-3">Proposal Members:</h3>
              <a href="{{ route('rmo-research-addmembers', $proposal->id) }}" class="link"><i class="fas fa-plus-circle"></i> ADD MEMBER</a>
            </div>

            <div class="card listing-container">
              <div class="card-body">
                <ul class="list-unstyled card-listing">
                  @if ($members->count())
                    @foreach ($members as $member)
                      <li class="d-flex align-items-center">
                        <p class="mr-auto">{{ $member->fullname }}</p>
                        <a href="#deleteModal-{{ $member->id }}" class="btn btn-danger btn-remove" style="height:fit-content" type="button" data-toggle="modal"><i class="fa fa-trash"></i> REMOVE</a>
                      </li>

                      <!-- Delete Modal -->
                      <div class="modal fade" id="deleteModal-{{ $member->id }}" tabindex="-1" role="dialog" aria-labelledby="deleteModal" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                          <div class="modal-content">
                            <div class="modal-header">
                              <span class="modal-title" id="deleteModal"><i class="fa fa-edit"></i> DELETE ?</span>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                            <div class="modal-body text-center">
                              <p>Are you sure you want to <span class="colored">DELETE</span> this member?</p>
                              <form action="{{ route('rmo-research-deletemember',[$proposal->id, $member->id]) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <input type="hidden" name="$member_id">
                                <button type="submit" class="btn btn-primary">Yes</button>
                              </form>
                              <a href="#" class="btn btn-secondary" data-dismiss="modal">Cancel</a>
                            </div>
                          </div>
                        </div>
                      </div>
                    @endforeach
                   @else 
                    There is currently 0 member on this proposal.
                    @endif
                </ul>
              </div>
            </div> --}}
                

                <div class="py-1">
                <!-- with disable option -->
             {{-- <a href="#" class="btn btn-primary float-lg-right submit-proposal-btn" role="button" ><i class="fas fa-paper-plane"></i> ADD MEMBERS</a>  --}}
             <button type="submit" class="btn btn-primary float-lg-right ">Add Members</button>
             <br>
                </div><br>
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