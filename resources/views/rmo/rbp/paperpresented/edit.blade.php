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
    @if($data)
     <!-- Start of content table -->
     <div class="container-fluid py-2">
        <div class="card table-container">
          <div class="card-body card-body-proposal">
            <form class="proposal-form" action="{{ route('rmo-paperpresented-edit', [$proposalid,$data->id ]) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
              <div class="row pb-5">
                <div class="col-xl-6 ml-4">
                    <div class="form-group text-left">
                      <label for="InputPaperPresentationTitle" class="card-heading py-3">Title</label>
                      <input type="text" class="form-control" id="InputPaperPresentationTitle" name="paper_title" value={{ $data->paper_title }} required>
                    </div>

                    <div class="form-group text-left">
                      <label for="InputPublicationTitle" class="card-heading py-3">Alternative Title</label>
                      <input type="text" class="form-control" id="InputPublicationTitle" name="paper_title_2" value={{ $data->paper_title_2 }} required>
                    </div>

                    <div class="form-group text-left">
                      <label for="InputPresenters" class="card-heading py-3">Presenter/s</label>
                      <input type="text" class="form-control" id="InputPresenters" name="presenters" value={{ $data->presenters }} required>
                    </div>
                </div>


                <div class="col-xl-5 ml-5">

                    <div class="form-group text-left">
                        <label for="InputVenue" class="card-heading py-3">Venue</label>
                        <input type="text" class="form-control" id="InputVenue" name="venue" value={{ $data->venue }}required>
                    </div>

                    <div class="form-group text-left">
                        <label for="InputOrganizer" class="card-heading py-3">Organizer</label>
                        <input type="text" class="form-control" id="InputOrganizer" name="organizer" value={{ $data->organizer }} required>
                    </div>

                    

                    <div class="d-flex">
                        <div class="col-xl-6 form-group text-left">
                            <label for="InputTypeOfConference" class="card-heading py-3">Type of Conference</label>
                            <input type="text" class="form-control" id="InputTypeOfConference" name="conference_type" value={{ $data->conference_type }} required>
                        </div>

                        <div class="col-xl-6 form-group text-left">
                            <label for="InputPaperPresentationDate" class="card-heading py-3">Date</label>
                            <input type="date" class="form-control" id="InputPaperPresentationDate" name="date" value={{ $data->date }} required>
                        </div>
                    </div>
                </div>
            
                <hr>

                <div class="proposal-files-container mt-4 ml-5">
                    <h3 class="card-heading py-3">Attachment Files: <i class="fas fa-info-circle pl-2"></i></h3>
                    <div class="row">

                        <div class="proposal-file-link pt-4 pb-5 px-3 text-center">
                          <div class="text-center file-upload">
                            <div class="file-upload-cont">
                                <label >
                                  <input type="file" accept=".pdf" name="fileInputA" class="inputFile" value={{ $data->file_1 }}>
                                  @if($data)
                                    @if ($data->file_1)
                                      <svg id="proposal-file-icon" xmlns="http://www.w3.org/2000/svg" width="32.524" height="42.698" viewBox="0 0 32.524 42.698">
                                        <path id="Path_930" data-name="Path 930" d="M64.753,42.7H89.771a3.757,3.757,0,0,0,3.753-3.753V12.509H84.767a3.757,3.757,0,0,1-3.753-3.753V0H64.753A3.757,3.757,0,0,0,61,3.753V38.945A3.757,3.757,0,0,0,64.753,42.7Zm5-25.1H84.767a1.251,1.251,0,1,1,0,2.5H69.756a1.251,1.251,0,0,1,0-2.5Zm0,5H84.767a1.251,1.251,0,1,1,0,2.5H69.756a1.251,1.251,0,0,1,0-2.5Zm0,5H84.767a1.251,1.251,0,1,1,0,2.5H69.756a1.251,1.251,0,0,1,0-2.5Zm0,5H79.764a1.251,1.251,0,0,1,0,2.5H69.756a1.251,1.251,0,0,1,0-2.5Z" transform="translate(-61)" fill="#00695C"/>
                                        <path id="Path_931" data-name="Path 931" d="M332.251,18.063h8.023L331,8.789v8.023A1.252,1.252,0,0,0,332.251,18.063Z" transform="translate(-308.483 -8.056)" fill="#00695C"/>
                                      </svg>   
                                      <p class="pt-3" id="fileInputA">{{ $data->file_1 }}</p>  
                                    @else
                                      <svg id="upload-icon" xmlns="http://www.w3.org/2000/svg" width="58.374" height="58.374" viewBox="0 0 58.374 58.374">
                                        <path id="Path_737" data-name="Path 737" d="M0,0H58.374V58.374H0Z" fill="none"/>
                                        <path id="Path_738" data-name="Path 738" d="M47.064,18.691a18.223,18.223,0,0,0-34.051-4.864,14.587,14.587,0,0,0,1.581,29.089H46.212a12.126,12.126,0,0,0,.851-24.225Zm-13.012,7.2v9.729H24.322V25.89h-7.3L29.187,13.729,41.348,25.89Z" transform="translate(0 5.729)" fill="#00695C"/>
                                      </svg>                          
                                      <p class="pt-3" id="fileInputA">Choose A File</p>  
                                    @endif 
                                  @else
                                    <svg id="upload-icon" xmlns="http://www.w3.org/2000/svg" width="58.374" height="58.374" viewBox="0 0 58.374 58.374">
                                      <path id="Path_737" data-name="Path 737" d="M0,0H58.374V58.374H0Z" fill="none"/>
                                      <path id="Path_738" data-name="Path 738" d="M47.064,18.691a18.223,18.223,0,0,0-34.051-4.864,14.587,14.587,0,0,0,1.581,29.089H46.212a12.126,12.126,0,0,0,.851-24.225Zm-13.012,7.2v9.729H24.322V25.89h-7.3L29.187,13.729,41.348,25.89Z" transform="translate(0 5.729)" fill="#00695C"/>
                                    </svg>                          
                                    <p class="pt-3" id="fileInputA">Choose A File</p>   
                                  @endif
                                </label>
                              </div>
                          </div>
                          <br>  <p>Abstract</p>
                          <a href="{{ asset('requirements/' . $data->file_1) ."#toolbar=0" }}" target="_blank" class="btn btn-secondary" title="View Proposal"></i> View</a>
                        </div>

                        <div class="proposal-file-link pt-4 pb-5 px-3 text-center">
                            <div class="text-center file-upload">
                                <div class="file-upload-cont">
                                    <label >
                                      <input type="file" accept=".pdf" name="fileInputCOP" class="inputFile" value={{ $data->file_2 }}>
                                      @if($data)
                                        @if ($data->file_2)
                                          <svg id="proposal-file-icon" xmlns="http://www.w3.org/2000/svg" width="32.524" height="42.698" viewBox="0 0 32.524 42.698">
                                            <path id="Path_930" data-name="Path 930" d="M64.753,42.7H89.771a3.757,3.757,0,0,0,3.753-3.753V12.509H84.767a3.757,3.757,0,0,1-3.753-3.753V0H64.753A3.757,3.757,0,0,0,61,3.753V38.945A3.757,3.757,0,0,0,64.753,42.7Zm5-25.1H84.767a1.251,1.251,0,1,1,0,2.5H69.756a1.251,1.251,0,0,1,0-2.5Zm0,5H84.767a1.251,1.251,0,1,1,0,2.5H69.756a1.251,1.251,0,0,1,0-2.5Zm0,5H84.767a1.251,1.251,0,1,1,0,2.5H69.756a1.251,1.251,0,0,1,0-2.5Zm0,5H79.764a1.251,1.251,0,0,1,0,2.5H69.756a1.251,1.251,0,0,1,0-2.5Z" transform="translate(-61)" fill="#00695C"/>
                                            <path id="Path_931" data-name="Path 931" d="M332.251,18.063h8.023L331,8.789v8.023A1.252,1.252,0,0,0,332.251,18.063Z" transform="translate(-308.483 -8.056)" fill="#00695C"/>
                                          </svg>   
                                          <p class="pt-3" id="fileInputCOP">{{ $data->file_2 }}</p>  
                                        @else
                                          <svg id="upload-icon" xmlns="http://www.w3.org/2000/svg" width="58.374" height="58.374" viewBox="0 0 58.374 58.374">
                                            <path id="Path_737" data-name="Path 737" d="M0,0H58.374V58.374H0Z" fill="none"/>
                                            <path id="Path_738" data-name="Path 738" d="M47.064,18.691a18.223,18.223,0,0,0-34.051-4.864,14.587,14.587,0,0,0,1.581,29.089H46.212a12.126,12.126,0,0,0,.851-24.225Zm-13.012,7.2v9.729H24.322V25.89h-7.3L29.187,13.729,41.348,25.89Z" transform="translate(0 5.729)" fill="#00695C"/>
                                          </svg>                          
                                          <p class="pt-3" id="fileInputCOP">Choose A File</p>  
                                        @endif 
                                      @else
                                        <svg id="upload-icon" xmlns="http://www.w3.org/2000/svg" width="58.374" height="58.374" viewBox="0 0 58.374 58.374">
                                          <path id="Path_737" data-name="Path 737" d="M0,0H58.374V58.374H0Z" fill="none"/>
                                          <path id="Path_738" data-name="Path 738" d="M47.064,18.691a18.223,18.223,0,0,0-34.051-4.864,14.587,14.587,0,0,0,1.581,29.089H46.212a12.126,12.126,0,0,0,.851-24.225Zm-13.012,7.2v9.729H24.322V25.89h-7.3L29.187,13.729,41.348,25.89Z" transform="translate(0 5.729)" fill="#00695C"/>
                                        </svg>                          
                                        <p class="pt-3" id="fileInputCOP">Choose A File</p>   
                                      @endif
                                    </label>
                                  </div>
                            </div>
                            <br>  <p>Certificate of Participation</p>
                            <a href="{{ asset('requirements/' . $data->file_2) ."#toolbar=0" }}" target="_blank" class="btn btn-secondary" title="View Proposal"></i> View</a>
                          </div>
                          
                          <div class="proposal-file-link pt-4 pb-5 px-3 text-center">
                            <div class="text-center file-upload">
                                <div class="file-upload-cont">
                                    <label >
                                      <input type="file" accept=".pdf" name="fileInputCP" class="inputFile" value={{ $data->file_3 }}>
                                      @if($data)
                                        @if ($data->file_3)
                                          <svg id="proposal-file-icon" xmlns="http://www.w3.org/2000/svg" width="32.524" height="42.698" viewBox="0 0 32.524 42.698">
                                            <path id="Path_930" data-name="Path 930" d="M64.753,42.7H89.771a3.757,3.757,0,0,0,3.753-3.753V12.509H84.767a3.757,3.757,0,0,1-3.753-3.753V0H64.753A3.757,3.757,0,0,0,61,3.753V38.945A3.757,3.757,0,0,0,64.753,42.7Zm5-25.1H84.767a1.251,1.251,0,1,1,0,2.5H69.756a1.251,1.251,0,0,1,0-2.5Zm0,5H84.767a1.251,1.251,0,1,1,0,2.5H69.756a1.251,1.251,0,0,1,0-2.5Zm0,5H84.767a1.251,1.251,0,1,1,0,2.5H69.756a1.251,1.251,0,0,1,0-2.5Zm0,5H79.764a1.251,1.251,0,0,1,0,2.5H69.756a1.251,1.251,0,0,1,0-2.5Z" transform="translate(-61)" fill="#00695C"/>
                                            <path id="Path_931" data-name="Path 931" d="M332.251,18.063h8.023L331,8.789v8.023A1.252,1.252,0,0,0,332.251,18.063Z" transform="translate(-308.483 -8.056)" fill="#00695C"/>
                                          </svg>   
                                          <p class="pt-3" id="fileInputCP">{{ $data->file_3 }}</p>  
                                        @else
                                          <svg id="upload-icon" xmlns="http://www.w3.org/2000/svg" width="58.374" height="58.374" viewBox="0 0 58.374 58.374">
                                            <path id="Path_737" data-name="Path 737" d="M0,0H58.374V58.374H0Z" fill="none"/>
                                            <path id="Path_738" data-name="Path 738" d="M47.064,18.691a18.223,18.223,0,0,0-34.051-4.864,14.587,14.587,0,0,0,1.581,29.089H46.212a12.126,12.126,0,0,0,.851-24.225Zm-13.012,7.2v9.729H24.322V25.89h-7.3L29.187,13.729,41.348,25.89Z" transform="translate(0 5.729)" fill="#00695C"/>
                                          </svg>                          
                                          <p class="pt-3" id="file_3">Choose A File</p>  
                                        @endif 
                                      @else
                                        <svg id="upload-icon" xmlns="http://www.w3.org/2000/svg" width="58.374" height="58.374" viewBox="0 0 58.374 58.374">
                                          <path id="Path_737" data-name="Path 737" d="M0,0H58.374V58.374H0Z" fill="none"/>
                                          <path id="Path_738" data-name="Path 738" d="M47.064,18.691a18.223,18.223,0,0,0-34.051-4.864,14.587,14.587,0,0,0,1.581,29.089H46.212a12.126,12.126,0,0,0,.851-24.225Zm-13.012,7.2v9.729H24.322V25.89h-7.3L29.187,13.729,41.348,25.89Z" transform="translate(0 5.729)" fill="#00695C"/>
                                        </svg>                          
                                        <p class="pt-3" id="fileInputCP">Choose A File</p>   
                                      @endif
                                    </label>
                                  </div>
                                  
                            </div>
                          <br>  <p>Conference Proceedings</p>
                          <a href="{{ asset('requirements/' . $data->file_3) ."#toolbar=0" }}" target="_blank" class="btn btn-secondary" title="View Proposal"></i> View</a>
                          </div>

                    
            
            </div>
                </div>
          
        
            </div>  
            <div class="py-2">
             <button type="submit" class="btn btn-primary float-lg-right ">UPDATE</button>
                </div>
            </form>
      

    @endif


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
@stop