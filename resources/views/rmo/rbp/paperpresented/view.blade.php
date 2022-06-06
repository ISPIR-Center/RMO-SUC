@extends('index')

@section('navbar')
<nav class="navbar navbar-light fixed-top bg-light p-0 shadow">
  <div class="container-fluid">
    <div class="py-3 m-0">
     <a href="{{ route('rmo-rbp') }}"><img src="{{ asset('img/logo/rmo-logo.png') }}" class="navbar-office-logo"></a>
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
            <p class="sidebar-user-name">{{ $user->office_name }}</p>
            <p class="sidebar-user-email">{{ $user->email }}</p>
          </div>
        </div>

        <x-navbar.rmo :active="$active"></x-navbar.rmo>
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
  <!-- Start of content table -->
  <div class="container-fluid py-2">
    <div class="card table-container">
      <div class="card-body card-body-proposal">
        <form class="proposal-form" action="">
          <div class="row pb-5">
            <div class="col-xl-6 ml-4">
                <div class="form-group text-left">
                  <label for="InputPaperPresentationTitle" class="card-heading py-3">Title</label>
                  <p>{{ $paperpresenteds->paper_title }}</p>
                </div>

                <div class="form-group text-left">
                  <label for="InputPublicationTitle" class="card-heading py-3">Alternative Title</label>
                  <p>{{ $paperpresenteds->paper_title_2 }}</p>
                </div>

                <div class="form-group text-left">
                  <label for="InputPresenters" class="card-heading py-3">Presenter</label>
                  <p>{{ $paperpresenteds->presenters }}</p>
                </div>
            </div>


            <div class="col-xl-5 ml-5">

                <div class="d-flex">

                <div class="col-xl-6 form-group text-left">
                    <label for="InputVenue" class="card-heading py-3">Venue</label>
                    <p>{{ $paperpresenteds->venue }}</p>
                </div>

                <div class="col-xl-6 form-group text-left">
                    <label for="InputOrganizer" class="card-heading py-3">Organizer</label>
                    <p>{{ $paperpresenteds->organizer }}</p>
                </div>

                </div>

                

                <div class="d-flex">
                    <div class="col-xl-6 form-group text-left">
                        <label for="InputTypeOfConference" class="card-heading py-3">Type of Conference</label>
                        <p>{{ $paperpresenteds->conference_type }}</p>
                    </div>

                    <div class="col-xl-6 form-group text-left">
                        <label for="InputPaperPresentationDate" class="card-heading py-3">Date</label>
                        <p>{{ $paperpresenteds->date }}</p>
                    </div>
                </div>
            </div>
        
            <hr>

            <div class="proposal-files-container mt-4 ml-5">
                <h3 class="card-heading py-3">Attachment Files:</h3>
                <div class="row">

                    <div class="proposal-file-link pt-4 pb-5 px-3 text-center">
                        <div class="text-center proposal-file">
                            <form action="#">
                            <div class="proposal-cont">
                              <svg id="proposal-file-icon" xmlns="http://www.w3.org/2000/svg" width="32.524" height="42.698" viewBox="0 0 32.524 42.698">
                                <path id="Path_930" data-name="Path 930" d="M64.753,42.7H89.771a3.757,3.757,0,0,0,3.753-3.753V12.509H84.767a3.757,3.757,0,0,1-3.753-3.753V0H64.753A3.757,3.757,0,0,0,61,3.753V38.945A3.757,3.757,0,0,0,64.753,42.7Zm5-25.1H84.767a1.251,1.251,0,1,1,0,2.5H69.756a1.251,1.251,0,0,1,0-2.5Zm0,5H84.767a1.251,1.251,0,1,1,0,2.5H69.756a1.251,1.251,0,0,1,0-2.5Zm0,5H84.767a1.251,1.251,0,1,1,0,2.5H69.756a1.251,1.251,0,0,1,0-2.5Zm0,5H79.764a1.251,1.251,0,0,1,0,2.5H69.756a1.251,1.251,0,0,1,0-2.5Z" transform="translate(-61)" fill="#00695C"/>
                                <path id="Path_931" data-name="Path 931" d="M332.251,18.063h8.023L331,8.789v8.023A1.252,1.252,0,0,0,332.251,18.063Z" transform="translate(-308.483 -8.056)" fill="#00695C"/>
                              </svg>                        
                              <p id="fileInputTxtCF">Abstract File</p>
                              <a href="{{ asset('requirements/' . $paperpresenteds->file_1) ."#toolbar=0" }}" target="_blank" class="btn btn-secondary" title="View Proposal"></i> View</a>
                            </div>
                          </div> 
                    </div>

                    <div class="proposal-file-link pt-4 pb-5 px-3 text-center">
                        <div class="text-center proposal-file">
                            <form action="#">
                            <div class="proposal-cont">
                              <svg id="proposal-file-icon" xmlns="http://www.w3.org/2000/svg" width="32.524" height="42.698" viewBox="0 0 32.524 42.698">
                                <path id="Path_930" data-name="Path 930" d="M64.753,42.7H89.771a3.757,3.757,0,0,0,3.753-3.753V12.509H84.767a3.757,3.757,0,0,1-3.753-3.753V0H64.753A3.757,3.757,0,0,0,61,3.753V38.945A3.757,3.757,0,0,0,64.753,42.7Zm5-25.1H84.767a1.251,1.251,0,1,1,0,2.5H69.756a1.251,1.251,0,0,1,0-2.5Zm0,5H84.767a1.251,1.251,0,1,1,0,2.5H69.756a1.251,1.251,0,0,1,0-2.5Zm0,5H84.767a1.251,1.251,0,1,1,0,2.5H69.756a1.251,1.251,0,0,1,0-2.5Zm0,5H79.764a1.251,1.251,0,0,1,0,2.5H69.756a1.251,1.251,0,0,1,0-2.5Z" transform="translate(-61)" fill="#00695C"/>
                                <path id="Path_931" data-name="Path 931" d="M332.251,18.063h8.023L331,8.789v8.023A1.252,1.252,0,0,0,332.251,18.063Z" transform="translate(-308.483 -8.056)" fill="#00695C"/>
                              </svg>                        
                              <p id="fileInputTxtCF">Cerficate of Participation</p>
                              <a href="{{ asset('requirements/' . $paperpresenteds->file_2) ."#toolbar=0" }}" target="_blank" class="btn btn-secondary" title="View Proposal"></i> View</a>
                            </div>
                          </div> 
                      </div>
                      
                      <div class="proposal-file-link pt-4 pb-5 px-3 text-center">
                        <div class="text-center proposal-file">
                            <form action="#">
                            <div class="proposal-cont">
                              <svg id="proposal-file-icon" xmlns="http://www.w3.org/2000/svg" width="32.524" height="42.698" viewBox="0 0 32.524 42.698">
                                <path id="Path_930" data-name="Path 930" d="M64.753,42.7H89.771a3.757,3.757,0,0,0,3.753-3.753V12.509H84.767a3.757,3.757,0,0,1-3.753-3.753V0H64.753A3.757,3.757,0,0,0,61,3.753V38.945A3.757,3.757,0,0,0,64.753,42.7Zm5-25.1H84.767a1.251,1.251,0,1,1,0,2.5H69.756a1.251,1.251,0,0,1,0-2.5Zm0,5H84.767a1.251,1.251,0,1,1,0,2.5H69.756a1.251,1.251,0,0,1,0-2.5Zm0,5H84.767a1.251,1.251,0,1,1,0,2.5H69.756a1.251,1.251,0,0,1,0-2.5Zm0,5H79.764a1.251,1.251,0,0,1,0,2.5H69.756a1.251,1.251,0,0,1,0-2.5Z" transform="translate(-61)" fill="#00695C"/>
                                <path id="Path_931" data-name="Path 931" d="M332.251,18.063h8.023L331,8.789v8.023A1.252,1.252,0,0,0,332.251,18.063Z" transform="translate(-308.483 -8.056)" fill="#00695C"/>
                              </svg>                        
                              <p id="fileInputTxtCF">Conference Proceedings</p>
                              <a href="{{ asset('requirements/' . $paperpresenteds->file_3) ."#toolbar=0" }}" target="_blank" class="btn btn-secondary" title="View Proposal"></i> View</a>
                            </div>
                          </div> 
                      </div>

                     
  </div>
</div>
    </div>
  </div>
</div>
  </div>
</form>





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