@extends('index')

@section('navbar')
<nav class="navbar navbar-light fixed-top bg-light p-0 shadow">
  <div class="container-fluid">
    <div class="py-3 m-0">
     <a href="{{ route('programchair-rbp') }}"><img src="{{ asset('img/logo/rmo-logo.png') }}" class="navbar-office-logo"></a>
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

        <x-navbar.program-chair :active="$active"></x-navbar.program-chair>
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
            <h1 class="card-title2 py-3">Research Details</h1>
          </div>
          <div class="col py-3">
            <p class="status-text float-right m-0">Status: <span class="badge status-pending">PENDING</span></p>
          </div>
        </div>
      </div>
      <div class="card-body card-body-proposal">
        <form class="proposal-form" action="">
          <div class="row pb-5">
            <div class="col-xl-5 ml-4">
                <div class="form-group text-left">
                  <label for="InputResearchTitle" class="card-heading py-3">Research Title</label>
                  <p class="card-text2">{{ $proposal->title }}</p>
                </div>
  
                <div class="form-group text-left">
                  <label for="InputUniversityAgenda" class="card-heading py-3">University Research Agenda</label>
                  <p class="card-text2">{{ $proposal->university_research_agenda }}</p>
                </div>
  
                <div class="form-group text-left">
                  <label for="InputResearchProponent" class="card-heading py-3">Research Proponent</label>
                  <p class="card-text2">{{ $proposal->leader }}</p>
                </div>
  
                <div class="form-group text-left">
                  <label for="InputResearchMember" class="card-heading py-3">Research Members</label>
                  <p class="card-text2">
                    @foreach ($members as $item)
                    {{ $item->fullname }} <br>
                @endforeach</p>
              </div>

              @if ($proposal->remarks)
            
                <div class=" form-group text-left">
                  <label for="InputOutputDeliverables" class="card-heading py-3">Remarks of the Evaluator</label>
                  <p class="card-text2">{{ $proposal->remarks }}</p>
                </div>
                @endif
  
            </div>
  
  
            <div class="col-xl-6 ml-6">
  
              <div class="d-flex">
                <div class="col-6 form-group text-left">
                    <label for="InputDateCompleted" class="card-heading py-3">Date Completed</label>
                    <p class="card-text2">{{ date('M d Y', strtotime($proposal->date_completed)) }}</p>
                </div>
  
                <div class="col-6 form-group text-left">
                    <label for="InputProgjectCost" class="card-heading py-3">Project Cost</label>
                    <p class="card-text2">{{ $proposal->budget }}</p>
                </div>
              </div>
  
              <div class="d-flex">
                <div class="col-6 form-group text-left">
                    <label for="InputDisciplineCovered" class="card-heading py-3">Discipline Covered</label>
                    <p class="card-text2">{{ $proposal->discipline_covered }}</p>
                </div>
  
                <div class="col-6 form-group text-left">
                    <label for="InputProgramComponent" class="card-heading py-3">Program Component</label>
                    <p class="card-text2">{{ $proposal->program_component }}</p>
                </div>
              </div>
  
              <div class="d-flex">
                <div class="col-6 form-group text-left">
                <label for="InputResearchMember" class="card-heading py-3">Funding Agency</label>
                <p class="card-text2">{{ $proposal->funding_agency }}</p>
              </div>

              <div class="col-6 form-group text-left">
                <label for="InputOutputDeliverables" class="card-heading py-3">Deliverables</label>
                <p class="card-text2">{{ $proposal->deliverables }}</p>
              </div>
              </div>
              {{-- @if ($proposal->remarks)
              <div class="d-flex">
                <div class="col-6 form-group text-left">
                  <label for="InputOutputDeliverables" class="card-heading py-3">Remarks</label>
                  <p class="card-text2">{{ $proposal->remarks }}</p>
                </div>
                @endif --}}

              {{-- <div class="col-6 proposal-file-link pt-3 pb-3 text-left"> --}}
               @if ($proposal->deliverables == "Research Based Paper")
               <div class="col-12 proposal-file-link pt-3 pb-3 text-left">
                <p class="card-heading pb-3">Attachment Files</p>
                <div class="d-flex">
                  <div class="text-center proposal-file col-xl-5 mr-2">
                    <form action="#">
                    <div class="proposal-cont">
                      <svg id="proposal-file-icon" xmlns="http://www.w3.org/2000/svg" width="32.524" height="42.698" viewBox="0 0 32.524 42.698">
                        <path id="Path_930" data-name="Path 930" d="M64.753,42.7H89.771a3.757,3.757,0,0,0,3.753-3.753V12.509H84.767a3.757,3.757,0,0,1-3.753-3.753V0H64.753A3.757,3.757,0,0,0,61,3.753V38.945A3.757,3.757,0,0,0,64.753,42.7Zm5-25.1H84.767a1.251,1.251,0,1,1,0,2.5H69.756a1.251,1.251,0,0,1,0-2.5Zm0,5H84.767a1.251,1.251,0,1,1,0,2.5H69.756a1.251,1.251,0,0,1,0-2.5Zm0,5H84.767a1.251,1.251,0,1,1,0,2.5H69.756a1.251,1.251,0,0,1,0-2.5Zm0,5H79.764a1.251,1.251,0,0,1,0,2.5H69.756a1.251,1.251,0,0,1,0-2.5Z" transform="translate(-61)" fill="#00695C"/>
                        <path id="Path_931" data-name="Path 931" d="M332.251,18.063h8.023L331,8.789v8.023A1.252,1.252,0,0,0,332.251,18.063Z" transform="translate(-308.483 -8.056)" fill="#00695C"/>
                      </svg>                        
                      <p id="fileInputTxtCF">Completion File</p>
                      <a href="{{ asset('requirements/' . $proposal->completed_file) ."#toolbar=0" }}" target="_blank" class="btn btn-secondary" title="View Proposal"></i> View</a>
                    </div>
                  </div> 
  
                  <div class="text-center proposal-file col-xl-5 ml-2">
                    <form action="#">
                    <div class="proposal-cont">
                      <svg id="proposal-file-icon" xmlns="http://www.w3.org/2000/svg" width="32.524" height="42.698" viewBox="0 0 32.524 42.698">
                        <path id="Path_930" data-name="Path 930" d="M64.753,42.7H89.771a3.757,3.757,0,0,0,3.753-3.753V12.509H84.767a3.757,3.757,0,0,1-3.753-3.753V0H64.753A3.757,3.757,0,0,0,61,3.753V38.945A3.757,3.757,0,0,0,64.753,42.7Zm5-25.1H84.767a1.251,1.251,0,1,1,0,2.5H69.756a1.251,1.251,0,0,1,0-2.5Zm0,5H84.767a1.251,1.251,0,1,1,0,2.5H69.756a1.251,1.251,0,0,1,0-2.5Zm0,5H84.767a1.251,1.251,0,1,1,0,2.5H69.756a1.251,1.251,0,0,1,0-2.5Zm0,5H79.764a1.251,1.251,0,0,1,0,2.5H69.756a1.251,1.251,0,0,1,0-2.5Z" transform="translate(-61)" fill="#00695C"/>
                        <path id="Path_931" data-name="Path 931" d="M332.251,18.063h8.023L331,8.789v8.023A1.252,1.252,0,0,0,332.251,18.063Z" transform="translate(-308.483 -8.056)" fill="#00695C"/>
                      </svg>                        
                      <p id="fileInputTxtCF">Partner Contract</p>
                      <a href="{{ asset('requirements/' . $proposal->partner_contract_file) ."#toolbar=0" }}" target="_blank" class="btn btn-secondary" title="View Proposal"></i> View</a>
                    </div>
                  </div>
                </div>
              </div>
                 @endif
                    </form>
                  </div>
               </div>
          {{-- </form> --}}
       <hr>
    @if ($proposal->deliverables == "Research Based Paper")
    <!-- ===================================================== Paper Presentation Details ===================================================== -->
    <div class="card-body mt-3 mb-4">
      <p class="card-header"><b>Paper Presented Details</b></p>
     <table class="table table-hover text-center bg-white">
       <thead>
         <tr>
           <th scope="col" width="22%" >Title</th>
           <th scope="col" width="18%">Presenter(s)</th>
           <th scope="col" width="17%">Alternative Title</th>
           <th scope="col" width="12%">Venue</th>
           <th scope="col" width="10%">Date</th>
           <th scope="col" width="9%">Conference Type</th>
           <th scope="col" width="30%">Action</th>
         </tr>
       </thead>
       <tbody>
        @if ($paperpresenteds->count())
        @foreach ($paperpresenteds as $paperpresented)
         <tr class="unread text-center">
           <td>{{ $paperpresented->paper_title }}</td>
           <td>{{ $paperpresented->presenters }}</td>
           <td>{{ $paperpresented->paper_title_2 }}</td>
           <td>{{ $paperpresented->venue }}</td>
           <td>{{ $paperpresented->date }}</td>
           <td>{{ $paperpresented->conference_type }}</td>
           <td>
            <a href="#reviseModal-{{ $paperpresented->id }}" data-toggle="modal" class="btn btn-secondary float-lg-right"><i class="fas fa-times"></i></a>
               <!-- DELETE UTILIZED -->
   <div class="modal fade" id="reviseModal-{{ $paperpresented->id }}" tabindex="-1" role="dialog" aria-labelledby="reviseModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <span class="modal-title" id="reviseModalLabel"><i class="fa fa-edit"></i> REJECT ?</span>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body text-center">
          <p>Are you sure you want to <span class="colored">REJECT</span> this information?</p> 
          <form action="{{ route('programchair-paperpresented-reject', $paperpresented->id) }}" method="post">
            @csrf
            @method('PATCH')
            <input type="hidden" name="status" value="Rejected by the Program Chair">
            <button type="submit" class="btn btn-primary">Yes</button>
          </form>   
           <a href="" class="btn btn-secondary" data-dismiss="modal">No</a>
        </div>
      </div>
    </div>
  </div>
        <form action="{{ route('programchair-paperpresented-approve', $paperpresented->id) }}" method="POST">
          @csrf
          @method('PUT')
          <input type="hidden" name="status" value="Approved by the Program Chair">
          <button type="submit" class="btn btn-secondary float-lg-right"><i class="fas fa-check"></i></button>
        </form>
        <a href="/programchair/paper-presented/view/{{$paperpresented->id}}/{{ $proposal->id }}" class="btn btn-secondary float-lg-right"><i class="fas fa-eye"></i></a>
           </td>
         </tr>
          <!-- DELETE UTILIZED -->
   <div class="modal fade" id="presentedDeleteModal-{{ $paperpresented->id }}" tabindex="-1" role="dialog" aria-labelledby="presentedDeleteModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <span class="modal-title" id="presentedDeleteModalLabel"><i class="fa fa-edit"></i> DELETE ?</span>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body text-center">
          <p>Are you sure you want to <span class="colored">DELETE</span> this information?</p> 
          <form action="{{ route('faculty-presented-delete', $paperpresented->id) }}" method="post">
            @csrf
            <button type="submit" class="btn btn-primary">Yes</button>
          </form>   
           <a href="" class="btn btn-primary" data-dismiss="modal">No</a>
        </div>
      </div>
    </div>
  </div>
         @endforeach
            @else
                <td colspan="9" class="text-center td-noproposals">No information added yet.</td>
            @endif
       </tbody>
     </table>
    
   </div>

 
  <!-- ===================================================== Paper Published ===================================================== -->
  <div class="card-body mt-3 mb-4">

    <p class="card-header"><b> Paper Published Details</b></p>
   <table class="table table-hover text-center bg-white">
     <thead>
       <tr>
        <th scope="col" width="22%">Publication Title</th>
        <th scope="col" width="18%">Journal Title</th>
         <th scope="col" width="17%" >Year Accepted</th>
         <th scope="col" width="12%">Year Publication</th>
         <th scope="col" width="9%">Publisher</th>
         <th scope="col" width="8%">Publication</th>
         <th scope="col" width="30%">Action</th>
       </tr>
     </thead>
     <tbody>
      @if ($paperpublisheds->count())
      @foreach ($paperpublisheds as $paperpublished)
       <tr class="unread text-center">
        <td>{{ $paperpublished->publication_title }}</td>
        <td>{{ $paperpublished->journal_title }}</td>
         <td>{{ $paperpublished->year_accepted }}</td>
         <td>{{ $paperpublished->year_published }}</td>
         <td>{{ $paperpublished->publisher }}</td>
         <td>{{ $paperpublished->publication }}</td>
         <td>
          <a href="#publishedreviseModal-{{ $paperpublished->id }}" data-toggle="modal" class="btn btn-secondary float-lg-right"><i class="fas fa-times"></i></a>
             <!-- DELETE UTILIZED -->
 <div class="modal fade" id="publishedreviseModal-{{ $paperpublished->id }}" tabindex="-1" role="dialog" aria-labelledby="publishedreviseModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <span class="modal-title" id="publishedreviseModalLabel"><i class="fa fa-edit"></i> REJECT ?</span>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body text-center">
        <p>Are you sure you want to <span class="colored">REJECT</span> this information?</p> 
        <form action="{{ route('programchair-paperpublished-reject', $paperpublished->id) }}" method="post">
          @csrf
          @method('PATCH')
          <input type="hidden" name="status" value="Rejected by the Program Chair">
          <button type="submit" class="btn btn-primary ">Yes</button>
        </form>   
         <a href="" class="btn btn-secondary" data-dismiss="modal">No</a>
      </div>
    </div>
  </div>
</div>
      <form action="{{ route('programchair-paperpublished-approve', $paperpublished->id) }}" method="POST">
        @csrf
        @method('PUT')
        <input type="hidden" name="status" value="Approved by the Program Chair">
        <button type="submit" class="btn btn-secondary float-lg-right"><i class="fas fa-check"></i></button>
      </form>
      <a href="/programchair/paper-published/view/{{$paperpublished->id}}/{{ $proposal->id }}" class="btn btn-secondary float-lg-right"><i class="fas fa-eye"></i></a>
         </td>
       </tr>
      <!-- DELETE UTILIZED -->
<div class="modal fade" id="publishedDeleteModal-{{ $paperpublished->id }}" tabindex="-1" role="dialog" aria-labelledby="publishedDeleteModalLabel" aria-hidden="true">
<div class="modal-dialog" role="document">
  <div class="modal-content">
    <div class="modal-header">
      <span class="modal-title" id="publishedDeleteModalLabel"><i class="fa fa-edit"></i> DELETE ?</span>
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
    <div class="modal-body text-center">
      <p>Are you sure you want to <span class="colored">DELETE</span> this information?</p> 
      <form action="{{ route('faculty-published-delete', $paperpublished->id) }}" method="post">
        @csrf
        <button type="submit" class="btn btn-primary">Yes</button>
      </form>   
       <a href="" class="btn btn-primary" data-dismiss="modal">No</a>
    </div>
  </div>
</div>
</div>
       @endforeach
       @else
           <td colspan="11" class="text-center td-noproposals">No information added yet.</td>
       @endif
     </tbody>
   </table>
 
 </div>
 
 <!-- ===================================================== Journal Cited by Other Researcher(s) ===================================================== -->
 <div class="card-body mt-3 mb-4">
 
   <p class="card-header"><b> Journal Cited by Other Researcher(s)</b></p>
  <table class="table table-hover text-center bg-white">
    <thead>
      <tr>
        <th scope="col" width="20%" >Title of New Publication</th>
        <th scope="col" width="16%">Author(s)</th>
        <th scope="col" width="13%">Journal Publisher</th>
        <th scope="col" width="12%">Cited Link</th>
        <th scope="col" width="9%">Publication</th>
        <th scope="col" width="10%">Year of Publication</th>
        <th scope="col" width="6%">Vol. No</th>
        <th scope="col" width="5%">Pages</th>
        <th scope="col" width="20%">Action</th>
      </tr>
    </thead>
    <tbody>
      @if ($journalciteds->count())
      @foreach ($journalciteds as $journalcited)
       <tr class=" unread text-center" >
         <td>{{ $journalcited->journal_title }}</td>
         <td>{{ $journalcited->authors }}</td>
         <td>{{ $journalcited->publisher }}</td>
         <td><a href="{{ $journalcited->link }}" target="_blank">{{ $journalcited->link }}</a> </td>
         <td>{{ $journalcited->publication }}</td>
         <td>{{ $journalcited->year_published }}</td>
         <td>{{ $journalcited->vol_no }}</td>
         <td>{{ $journalcited->pages }}</td>
         <td>
          <a href="#journalcitedreviseModal-{{ $journalcited->id }}" data-toggle="modal" class="btn btn-secondary float-lg-right"><i class="fas fa-times"></i></a>
             <!-- DELETE UTILIZED -->
 <div class="modal fade" id="journalcitedreviseModal-{{ $journalcited->id }}" tabindex="-1" role="dialog" aria-labelledby="journalcitedreviseModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <span class="modal-title" id="journalcitedreviseModalLabel"><i class="fa fa-edit"></i> REJECT ?</span>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body text-center">
        <p>Are you sure you want to <span class="colored">REJECT</span> this information?</p> 
        <form action="{{ route('programchair-journalcited-reject', $journalcited->id) }}" method="post">
          @csrf
          @method('PATCH')
          <input type="hidden" name="status" value="Rejected by the Program Chair">
          <button type="submit" class="btn btn-primary">Yes</button>
        </form>   
         <a href="" class="btn btn-secondary" data-dismiss="modal">No</a>
      </div>
    </div>
  </div>
</div>
      <form action="{{ route('programchair-journalcited-approve', $journalcited->id) }}" method="POST">
        @csrf
        @method('PUT')
        <input type="hidden" name="status" value="Approved by the Program Chair">
        <button type="submit" class="btn btn-secondary float-lg-right"><i class="fas fa-check"></i></button>
      </form>
         </td>
       </tr>
      <!-- DELETE UTILIZED -->
<div class="modal fade" id="journalCitedDeleteModal-{{ $journalcited->id }}" tabindex="-1" role="dialog" aria-labelledby="journalCitedDeleteModalLabel" aria-hidden="true">
<div class="modal-dialog" role="document">
  <div class="modal-content">
    <div class="modal-header">
      <span class="modal-title" id="journalCitedDeleteModalLabel"><i class="fa fa-edit"></i> DELETE ?</span>
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
    <div class="modal-body text-center">
      <p>Are you sure you want to <span class="colored">DELETE</span> this information?</p> 
      <form action="{{ route('faculty-journalcited-delete', $journalcited->id) }}" method="post">
        @csrf
        <button type="submit" class="btn btn-primary">Yes</button>
      </form>   
       <a href="" class="btn btn-primary" data-dismiss="modal">No</a>
    </div>
  </div>
</div>
</div>
       @endforeach
       @else
           <td colspan="9" class="text-center td-noproposals">No information added yet.</td>
       @endif
    </tbody>
  </table>
 
 </div>
 
 <!-- ===================================================== Book Cited by Other Researcher(s) ===================================================== -->
 <div class="card-body mt-3 mb-4">
  
 <p class="card-header"><b> Book Cited by Other Researcher(s)</b></p>
 <table class="table table-hover text-center bg-white">
  <thead>
    <tr>
      <th scope="col" width="20%" >Title of New Book Chapter</th>
      <th scope="col" width="16%">Author(s)</th>
      <th scope="col" width="15%">Journal Publisher</th>
      <th scope="col" width="12%">Cited Link</th>
      <th scope="col" width="8%">Year of Publication</th>
      <th scope="col" width="8%">Vol. No</th>
      <th scope="col" width="6%">Pages</th>
      <th scope="col" width="6%">ISBN</th>
      <th scope="col" width="30%">Action</th>
    </tr>
  </thead>
  <tbody>
    @if ($bookciteds->count())
    @foreach ($bookciteds as $bookcited)
     <tr class="unread text-center">
       <td>{{ $bookcited->book_title }}</td>
       <td>{{ $bookcited->authors }}</td>
       <td>{{ $bookcited->publisher }}</td>
       <td><a href="{{ $bookcited->link }}" target="_blank">{{ $bookcited->link }}</a> </td>
       <td>{{ $bookcited->year_published }}</td>
       <td>{{ $bookcited->vol_no }}</td>
       <td>{{ $bookcited->pages }}</td>
       <td>{{ $bookcited->isbn }}</td>
       <td>
          <a href="#bookcitedreviseModal-{{ $bookcited->id }}" data-toggle="modal" class="btn btn-secondary float-lg-right"><i class="fas fa-times"></i></a>
             <!-- DELETE UTILIZED -->
 <div class="modal fade" id="bookcitedreviseModal-{{ $bookcited->id }}" tabindex="-1" role="dialog" aria-labelledby="bookcitedreviseModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <span class="modal-title" id="bookcitedreviseModalLabel"><i class="fa fa-edit"></i> REJECT ?</span>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body text-center">
        <p>Are you sure you want to <span class="colored">REJECT</span> this information?</p> 
        <form action="{{ route('programchair-bookcited-reject', $bookcited->id) }}" method="post">
          @csrf
          @method('PATCH')
          <input type="hidden" name="status" value="Rejected by the Program Chair">
          <button type="submit" class="btn btn-primary">Yes</button>
        </form>   
         <a href="" class="btn btn-secondary" data-dismiss="modal">No</a>
      </div>
    </div>
  </div>
</div>
      <form action="{{ route('programchair-bookcited-approve', $bookcited->id) }}" method="POST">
        @csrf
        @method('PUT')
        <input type="hidden" name="status" value="Approved by the Program Chair">
        <button type="submit" class="btn btn-secondary float-lg-right"><i class="fas fa-check"></i></button>
      </form>
       </td>
     </tr>
    </tr>
    <!-- DELETE UTILIZED -->
<div class="modal fade" id="bookcitedDeleteModal-{{ $bookcited->id }}" tabindex="-1" role="dialog" aria-labelledby="bookcitedDeleteModalLabel" aria-hidden="true">
<div class="modal-dialog" role="document">
<div class="modal-content">
  <div class="modal-header">
    <span class="modal-title" id="bookcitedDeleteModalLabel"><i class="fa fa-edit"></i> DELETE ?</span>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>
  <div class="modal-body text-center">
    <p>Are you sure you want to <span class="colored">DELETE</span> this information?</p> 
    <form action="{{ route('faculty-bookcited-delete', $bookcited->id) }}" method="post">
      @csrf
      <button type="submit" class="btn btn-primary">Yes</button>
    </form>   
     <a href="" class="btn btn-primary" data-dismiss="modal">No</a>
  </div>
</div>
</div>
</div>
     @endforeach
     @else
         <td colspan="9" class="text-center td-noproposals">No information added yet.</td>
     @endif
  </tbody>
 </table>

 </div> 
<!-- -----------------------------------------I N V E N T I O N---------------------------------------------------------- -->
@elseif ($proposal->research_deliverables == "Invention")
<div class="card-body mt-3 mb-4">
 <p class="card-header"><b>Invention Patent Details</b></p>
<table class="table table-hover text-center bg-white">
  <thead>
    <tr>
      <th scope="col" width="10%" >Patent No.</th>
      <th scope="col" width="20%">Name of Commercial Product</th>
      <th scope="col" width="15%">Utilization</th>
      <th scope="col" width="15%">Issued Date</th>
      <th scope="col" width="8%">Action</th>
    </tr>
  </thead>
  <tbody>
   @if ($patenteds->count())
   @foreach ($patenteds as $patented)
    <tr class="unread text-center">
      <td>{{ $patented->patent_no }}</td>
      <td>{{ $patented->product_name }}</td>
      <td>{{ $patented->utilization }}</td>
      <td>{{ $patented->date_issue }}</td>
      <td>
        <a href="/programchair/rbp/view/{{$proposal->id}}" class="btn btn-secondary"><i class="fas fa-eye"></i></a>
        <a href="/programchair/rbp/view/{{$proposal->id}}" class="btn btn-secondary"><i class="fas fa-check"></i></a>
        <a href="/programchair/rbp/view/{{$proposal->id}}" class="btn btn-secondary"><i class="fas fa-times"></i></a>
      </td>
    </tr>
    <!-- Patented Modal Edit -->
<div class="modal fade" id="patentedEditModal-{{ $patented->id }}" tabindex="-1" role="dialog" aria-labelledby="patentedEditModalLabel" aria-hidden="true">
 <div class="modal-dialog modal-lg" role="document">
   <div class="modal-content">
     <div class="modal-header">
       <span class="modal-title" id="patentedEditModalLabel"><i class="fas fa-pen pr-2"></i>Edit Patented</span>
       <button type="button" class="close" data-dismiss="modal" aria-label="Close">
         <span aria-hidden="true">&times;</span>
       </button>
     </div>

     <div class="modal-body mx-0 pb-0 pt-3">
       <form class="proposal-form" action="{{ route('faculty-rbp-view', $patented->id) }}" method="POST">
         @csrf
         @method('PUT')
       <div class="form-group text-left">
         <label for="InputNameofCommercialProduct" class="modal-title-header pb-2">Name of Commercial Product</label>
         <input type="text" class="form-control" id="InputNameofCommercialProduct" placeholder="Enter Commercial Product" name="product_name" value={{ $patented->product_name }} required>
       </div>

       <div class="form-group text-left">
         <label for="InputUtilizationInvention" class="modal-title-header pb-2">Utilization of Invention</label>
         <input type="text" class="form-control" id="InputUtilizationInvention" placeholder="Enter Utilization Invention" name="utilization" value={{ $patented->utilization }} required>
       </div>

       <div class="d-flex col-12 px-0">
         <div class="form-group text-left col-6 pl-0 ml-0">
           <label for="InputPatentNumber" class="modal-title-header pb-2">Patent Number</label>
           <input type="text" class="form-control" id="InputPatentNumber" placeholder="Enter Patent Number" name="patent_no" value={{ $patented->patent_no }} required>
         </div>

         <div class="form-group text-left col-6">
           <label for="InputDateIssue" class="modal-title-header pb-2">Date of Issue</label>
           <input type="text" class="form-control" id="InputDateIssue" placeholder="Enter Date of Issue" name="date_issue" value={{ $patented->date_issue }} required>
         </div>
       </div>
     
     <div class="card-footer pb-3">
       <button class="btn btn-lg btn-primary btn-block text-uppercase my-4 float-right" type="submit"><i class="fas fa-pen pr-2"></i>UPDATE</button> 
     </div>
       </form>
     </div>
   </div>
 </div>
</div>

     <!-- DELETE UTILIZED -->
<div class="modal fade" id="patentedDeleteModal-{{ $patented->id }}" tabindex="-1" role="dialog" aria-labelledby="patentedDeleteModalLabel" aria-hidden="true">
 <div class="modal-dialog" role="document">
 <div class="modal-content">
   <div class="modal-header">
     <span class="modal-title" id="patentedDeleteModalLabel"><i class="fa fa-edit"></i> DELETE ?</span>
     <button type="button" class="close" data-dismiss="modal" aria-label="Close">
       <span aria-hidden="true">&times;</span>
     </button>
   </div>
   <div class="modal-body text-center">
     <p>Are you sure you want to <span class="colored">DELETE</span> this information?</p> 
     <form action="{{ route('faculty-patented-delete', $patented->id) }}" method="post">
       @csrf
       <button type="submit" class="btn btn-primary">Yes</button>
     </form>   
      <a href="" class="btn btn-primary" data-dismiss="modal">No</a>
   </div>
 </div>
 </div>
 </div>
    @endforeach
       @else
           <td colspan="9" class="text-center td-noproposals">No information added yet.</td>
       @endif
  </tbody>
</table>

</div>


<!-- ===================================================== Utilized ===================================================== -->
<div class="card-body mt-3 mb-4">
 
<p class="card-header"><b>Invention Utilized Details</b></p>
<table class="table table-hover text-center bg-white">
 <thead>
   <tr>
     <th scope="col" width="20%" >Photo</th>
     <th scope="col" width="20%">MOA</th>
     <th scope="col" width="20%">Business Permit</th>
     <th scope="col" width="20%">Action</th>
   </tr>
 </thead>
 <tbody>
  @if ($utilizeds->count())
  @foreach ($utilizeds as $utilized)
   <tr class="unread text-center">
     <td><a href="{{ asset('requirements/' . $utilized->file_1) ."#toolbar=0" }}" target="_blank" class="btn btn-secondary" title="View Proposal">{{ $utilized->file_1 }} </td>
     <td><a href="{{ asset('requirements/' . $utilized->file_2) ."#toolbar=0" }}" target="_blank" class="btn btn-secondary" title="View Proposal">{{ $utilized->file_2 }}</td>
     <td><a href="{{ asset('requirements/' . $utilized->file_3) ."#toolbar=0" }}" target="_blank" class="btn btn-secondary" title="View Proposal">{{ $utilized->file_3 }}</td>
     <td>
      <a href="/programchair/rbp/view/{{$proposal->id}}" class="btn btn-secondary"><i class="fas fa-eye"></i></a>
      <a href="/programchair/rbp/view/{{$proposal->id}}" class="btn btn-secondary"><i class="fas fa-check"></i></a>
      <a href="/programchair/rbp/view/{{$proposal->id}}" class="btn btn-secondary"><i class="fas fa-times"></i></a>
     </td>
   </tr>
   <!-- Utilized Modal Edit -->
<div class="modal fade" id="utilizedEditModal-{{ $utilized->id }}" tabindex="-1" role="dialog" aria-labelledby="utilizedEditModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <span class="modal-title" id="utilizedEditModalLabel"><i class="fas fa-pen pr-2"></i>Commercialized / Utilized but not Patented</span>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div> 
      <form class="proposal-form" action="{{ route('faculty-utilized-update', $utilized->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
      <div class="modal-body row mx-0 pb-0 pt-3">
        
          <div class="proposal-file-link pt-3 pb-5 text-center col-4">
              <p class="proposal-file-text">Photo</p>
              <div class="text-center file-upload">
                <div class="file-upload-cont">
                  <label >
                    <input type="file" accept=".pdf" name="fileInputPhoto" class="inputFile" value={{ $utilized->file_1 }}>
                                  @if($utilized)
                                    @if ($utilized->file_1)
                                      <svg id="proposal-file-icon" xmlns="http://www.w3.org/2000/svg" width="32.524" height="42.698" viewBox="0 0 32.524 42.698">
                                        <path id="Path_930" data-name="Path 930" d="M64.753,42.7H89.771a3.757,3.757,0,0,0,3.753-3.753V12.509H84.767a3.757,3.757,0,0,1-3.753-3.753V0H64.753A3.757,3.757,0,0,0,61,3.753V38.945A3.757,3.757,0,0,0,64.753,42.7Zm5-25.1H84.767a1.251,1.251,0,1,1,0,2.5H69.756a1.251,1.251,0,0,1,0-2.5Zm0,5H84.767a1.251,1.251,0,1,1,0,2.5H69.756a1.251,1.251,0,0,1,0-2.5Zm0,5H84.767a1.251,1.251,0,1,1,0,2.5H69.756a1.251,1.251,0,0,1,0-2.5Zm0,5H79.764a1.251,1.251,0,0,1,0,2.5H69.756a1.251,1.251,0,0,1,0-2.5Z" transform="translate(-61)" fill="#00695C"/>
                                        <path id="Path_931" data-name="Path 931" d="M332.251,18.063h8.023L331,8.789v8.023A1.252,1.252,0,0,0,332.251,18.063Z" transform="translate(-308.483 -8.056)" fill="#00695C"/>
                                      </svg>   
                                      <p class="pt-3" id="fileInputPhoto">{{ $utilized->file_1 }}</p>  
                                    @else
                                      <svg id="upload-icon" xmlns="http://www.w3.org/2000/svg" width="58.374" height="58.374" viewBox="0 0 58.374 58.374">
                                        <path id="Path_737" data-name="Path 737" d="M0,0H58.374V58.374H0Z" fill="none"/>
                                        <path id="Path_738" data-name="Path 738" d="M47.064,18.691a18.223,18.223,0,0,0-34.051-4.864,14.587,14.587,0,0,0,1.581,29.089H46.212a12.126,12.126,0,0,0,.851-24.225Zm-13.012,7.2v9.729H24.322V25.89h-7.3L29.187,13.729,41.348,25.89Z" transform="translate(0 5.729)" fill="#00695C"/>
                                      </svg>                          
                                      <p class="pt-3" id="fileInputPhoto">Choose A File</p>  
                                    @endif 
                                  @else
                                    <svg id="upload-icon" xmlns="http://www.w3.org/2000/svg" width="58.374" height="58.374" viewBox="0 0 58.374 58.374">
                                      <path id="Path_737" data-name="Path 737" d="M0,0H58.374V58.374H0Z" fill="none"/>
                                      <path id="Path_738" data-name="Path 738" d="M47.064,18.691a18.223,18.223,0,0,0-34.051-4.864,14.587,14.587,0,0,0,1.581,29.089H46.212a12.126,12.126,0,0,0,.851-24.225Zm-13.012,7.2v9.729H24.322V25.89h-7.3L29.187,13.729,41.348,25.89Z" transform="translate(0 5.729)" fill="#00695C"/>
                                    </svg>                          
                                    <p class="pt-3" id="fileInputPhoto">Choose A File</p>   
                                  @endif
                  </label>
                </div>
              </div>
            </div>

            <div class="proposal-file-link pt-3 pb-5 text-center col-4">
              <p class="proposal-file-text">MOA</p>
              <div class="text-center file-upload">
                <div class="file-upload-cont">
                  <label >
                    <input type="file" accept=".pdf" name="fileInputMoa" class="inputFile" value={{ $utilized->file_2 }}>
                    @if($utilized)
                    @if ($utilized->file_2)
                      <svg id="proposal-file-icon" xmlns="http://www.w3.org/2000/svg" width="32.524" height="42.698" viewBox="0 0 32.524 42.698">
                        <path id="Path_930" data-name="Path 930" d="M64.753,42.7H89.771a3.757,3.757,0,0,0,3.753-3.753V12.509H84.767a3.757,3.757,0,0,1-3.753-3.753V0H64.753A3.757,3.757,0,0,0,61,3.753V38.945A3.757,3.757,0,0,0,64.753,42.7Zm5-25.1H84.767a1.251,1.251,0,1,1,0,2.5H69.756a1.251,1.251,0,0,1,0-2.5Zm0,5H84.767a1.251,1.251,0,1,1,0,2.5H69.756a1.251,1.251,0,0,1,0-2.5Zm0,5H84.767a1.251,1.251,0,1,1,0,2.5H69.756a1.251,1.251,0,0,1,0-2.5Zm0,5H79.764a1.251,1.251,0,0,1,0,2.5H69.756a1.251,1.251,0,0,1,0-2.5Z" transform="translate(-61)" fill="#00695C"/>
                        <path id="Path_931" data-name="Path 931" d="M332.251,18.063h8.023L331,8.789v8.023A1.252,1.252,0,0,0,332.251,18.063Z" transform="translate(-308.483 -8.056)" fill="#00695C"/>
                      </svg>   
                      <p class="pt-3" id="fileInputMoa">{{ $utilized->file_2 }}</p>  
                    @else
                      <svg id="upload-icon" xmlns="http://www.w3.org/2000/svg" width="58.374" height="58.374" viewBox="0 0 58.374 58.374">
                        <path id="Path_737" data-name="Path 737" d="M0,0H58.374V58.374H0Z" fill="none"/>
                        <path id="Path_738" data-name="Path 738" d="M47.064,18.691a18.223,18.223,0,0,0-34.051-4.864,14.587,14.587,0,0,0,1.581,29.089H46.212a12.126,12.126,0,0,0,.851-24.225Zm-13.012,7.2v9.729H24.322V25.89h-7.3L29.187,13.729,41.348,25.89Z" transform="translate(0 5.729)" fill="#00695C"/>
                      </svg>                          
                      <p class="pt-3" id="fileInputMoa">Choose A File</p>  
                    @endif 
                  @else
                    <svg id="upload-icon" xmlns="http://www.w3.org/2000/svg" width="58.374" height="58.374" viewBox="0 0 58.374 58.374">
                      <path id="Path_737" data-name="Path 737" d="M0,0H58.374V58.374H0Z" fill="none"/>
                      <path id="Path_738" data-name="Path 738" d="M47.064,18.691a18.223,18.223,0,0,0-34.051-4.864,14.587,14.587,0,0,0,1.581,29.089H46.212a12.126,12.126,0,0,0,.851-24.225Zm-13.012,7.2v9.729H24.322V25.89h-7.3L29.187,13.729,41.348,25.89Z" transform="translate(0 5.729)" fill="#00695C"/>
                    </svg>                          
                    <p class="pt-3" id="fileInputMoa">Choose A File</p>   
                  @endif
                  </label>
                </div>
              </div>
            </div>

            <div class="proposal-file-link pt-3 pb-5 text-center col-4">
              <p class="proposal-file-text">Business Permit</p>
              <div class="text-center file-upload">
                <div class="file-upload-cont">
                  <label >
                    <input type="file" accept=".pdf" name="fileInputBP" class="inputFile" value={{ $utilized->file_3 }}>
                    @if($utilized)
                    @if ($utilized->file_3)
                      <svg id="proposal-file-icon" xmlns="http://www.w3.org/2000/svg" width="32.524" height="42.698" viewBox="0 0 32.524 42.698">
                        <path id="Path_930" data-name="Path 930" d="M64.753,42.7H89.771a3.757,3.757,0,0,0,3.753-3.753V12.509H84.767a3.757,3.757,0,0,1-3.753-3.753V0H64.753A3.757,3.757,0,0,0,61,3.753V38.945A3.757,3.757,0,0,0,64.753,42.7Zm5-25.1H84.767a1.251,1.251,0,1,1,0,2.5H69.756a1.251,1.251,0,0,1,0-2.5Zm0,5H84.767a1.251,1.251,0,1,1,0,2.5H69.756a1.251,1.251,0,0,1,0-2.5Zm0,5H84.767a1.251,1.251,0,1,1,0,2.5H69.756a1.251,1.251,0,0,1,0-2.5Zm0,5H79.764a1.251,1.251,0,0,1,0,2.5H69.756a1.251,1.251,0,0,1,0-2.5Z" transform="translate(-61)" fill="#00695C"/>
                        <path id="Path_931" data-name="Path 931" d="M332.251,18.063h8.023L331,8.789v8.023A1.252,1.252,0,0,0,332.251,18.063Z" transform="translate(-308.483 -8.056)" fill="#00695C"/>
                      </svg>   
                      <p class="pt-3" id="fileInputBP">{{ $utilized->file_3 }}</p>  
                    @else
                      <svg id="upload-icon" xmlns="http://www.w3.org/2000/svg" width="58.374" height="58.374" viewBox="0 0 58.374 58.374">
                        <path id="Path_737" data-name="Path 737" d="M0,0H58.374V58.374H0Z" fill="none"/>
                        <path id="Path_738" data-name="Path 738" d="M47.064,18.691a18.223,18.223,0,0,0-34.051-4.864,14.587,14.587,0,0,0,1.581,29.089H46.212a12.126,12.126,0,0,0,.851-24.225Zm-13.012,7.2v9.729H24.322V25.89h-7.3L29.187,13.729,41.348,25.89Z" transform="translate(0 5.729)" fill="#00695C"/>
                      </svg>                          
                      <p class="pt-3" id="fileInputBP">Choose A File</p>  
                    @endif 
                  @else
                    <svg id="upload-icon" xmlns="http://www.w3.org/2000/svg" width="58.374" height="58.374" viewBox="0 0 58.374 58.374">
                      <path id="Path_737" data-name="Path 737" d="M0,0H58.374V58.374H0Z" fill="none"/>
                      <path id="Path_738" data-name="Path 738" d="M47.064,18.691a18.223,18.223,0,0,0-34.051-4.864,14.587,14.587,0,0,0,1.581,29.089H46.212a12.126,12.126,0,0,0,.851-24.225Zm-13.012,7.2v9.729H24.322V25.89h-7.3L29.187,13.729,41.348,25.89Z" transform="translate(0 5.729)" fill="#00695C"/>
                    </svg>                          
                    <p class="pt-3" id="fileInputBP">Choose A File</p>   
                  @endif
                  </label>
                </div>
              </div>
            </div>

      </div>
     
      <div class="card-footer pb-9">
    
        <button class="btn btn-primary float-lg-right" type="submit">UPDATE</button> 
      </div>  
      <br>
      </form>
    </div>
  </div>
</div>
          <!-- DELETE UTILIZED -->
   <div class="modal fade" id="utilizedDeleteModal-{{ $utilized->id }}" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
                              <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                  <div class="modal-header">
                                    <span class="modal-title" id="deleteModalLabel"><i class="fa fa-edit"></i> DELETE ?</span>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                      <span aria-hidden="true">&times;</span>
                                    </button>
                                  </div>
                                  <div class="modal-body text-center">
                                    <p>Are you sure you want to <span class="colored">DELETE</span> this faculty?</p> 
                                    <form action="{{ route('faculty-utilized-delete', $utilized->id) }}" method="post">
                                      @csrf
                                      <button type="submit" class="btn btn-primary">Yes</button>
                                    </form>   
                                     <a href="" class="btn btn-primary" data-dismiss="modal">No</a>
                                  </div>
                                </div>
                              </div>
                            </div>
   @endforeach
   @else
       <td colspan="10" class="text-center td-noproposals">No information added yet.</td>
   @endif
 </tbody>
</table>

</div>
    @else
     @endif
     <form action="{{ route('programchair-rbp-reject',$proposal->id) }}" method="post">
      @csrf
      @method('PUT')
     <div class="col-xl-12 ml-0">
     <div class="form-group text-left">
      <label for="InputUniversityAgenda" class="card-heading py-2">Remarks</label>
      <textarea class="form-control" id="remarks" onkeyup="putremarks()" onkeydown="submitapprove()" name="remarks"></textarea>
    </div>
  </div>

  <div class="mt-3 mb-4">
      {{-- <input type="hidden" name="logout"> --}}
      @if($paperpresenteds->count() || $paperpublisheds->count() || $bookciteds->count() || $journalciteds->count() || $utilizeds->count() || $patenteds->count())
      <button type="submit" id="rejectbutton" class="btn btn-primary float-right px-2" disabled>For Revision</button>
      @else
      <button type="submit" id="rejectbutton" class="btn btn-primary float-right px-2" disabled>For Revision</button>
      @endif
    </form>
    <form action="{{ route('programchair-rbp-approve',$proposal->id) }}" method="post">
      @csrf
      @method('PUT')
      @if($paperpresenteds->count() || $paperpublisheds->count() || $bookciteds->count() || $journalciteds->count() || $utilizeds->count() || $patenteds->count())
    <button type="submit" id="acceptbutton" class="btn btn-primary float-right px-3" disabled>Submit</button>
    @else
    <button type="submit" id="acceptbutton" class="btn btn-primary float-right px-3" >Submit</button>
    @endif
    </form>
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

<!-- Patented Modal Add -->
<div class="modal fade" id="patentedAddModal" tabindex="-1" role="dialog" aria-labelledby="patentedAddModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <span class="modal-title" id="patentedAddModalLabel"><i class="fas fa-plus-circle pr-2"></i>Add Patented</span>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <div class="modal-body ">
        <form class="proposal-form" action="{{ route('faculty-rbp-view', $proposal->id) }}" method="POST">
          @csrf

        <div class="form-group text-left">
          <label for="InputNameofCommercialProduct" class="modal-title-header pb-2">Name of Commercial Product</label>
          <input type="text" class="form-control" id="InputNameofCommercialProduct" placeholder="Enter Commercial Product" name="product_name" required>
        </div>
       
        <div class="form-group text-left">
          <label for="InputUtilizationInvention" class="modal-title-header pb-2">Utilization of Invention</label>
          <input type="text" class="form-control" id="InputUtilizationInvention" placeholder="Enter Utilization Invention" name="utilization" required>
        </div>

        <div class="d-flex col-12 px-0">
          <div class="form-group text-left col-6 pl-0 ml-0">
            <label for="InputPatentNumber" class="modal-title-header pb-2">Patent Number</label>
            <input type="text" class="form-control" id="InputPatentNumber" placeholder="Enter Patent Number" name="patent_no" required>
          </div>

          <div class="form-group text-left col-6">
            <label for="InputDateIssue" class="modal-title-header pb-2">Date of Issue</label>
            <input type="date" class="form-control" id="InputDateIssue" placeholder="Enter Date of Issue" name="date_issue"required>
          </div>
        </div>
      </div>
        <button class="btn btn-lg btn-primary btn-block text-uppercase my-4 float-right" type="submit">CREATE</button> 
        </form>
    </div>
  </div>
</div>


<!-- Utilized Modal Add -->
<div class="modal fade" id="utilizedAddModal" tabindex="-1" role="dialog" aria-labelledby="utilizedAddModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <span class="modal-title" id="utilizedAddModalLabel"><i class="fas fa-plus-circle pr-2"></i>Commercialized / Utilized but not Patented</span>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form class="proposal-form" action="{{ route('faculty-rbp-view', $proposal->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
      <div class="modal-body row mx-0 pb-0 pt-3">
        
          <div class="proposal-file-link pt-3 pb-5 text-center col-4">
              <p class="proposal-file-text">Photo</p>
              <div class="text-center file-upload">
                <div class="file-upload-cont">
                  <label >
                    <input type="file" accept=".pdf" name="file_1" class="inputFile">
                    <svg id="upload-icon" xmlns="http://www.w3.org/2000/svg" width="58.374" height="58.374" viewBox="0 0 58.374 58.374">
                      <path id="Path_737" data-name="Path 737" d="M0,0H58.374V58.374H0Z" fill="none"/>
                      <path id="Path_738" data-name="Path 738" d="M47.064,18.691a18.223,18.223,0,0,0-34.051-4.864,14.587,14.587,0,0,0,1.581,29.089H46.212a12.126,12.126,0,0,0,.851-24.225Zm-13.012,7.2v9.729H24.322V25.89h-7.3L29.187,13.729,41.348,25.89Z" transform="translate(0 5.729)" fill="#1565C0"/>
                    </svg>                          
                    <p class="pt-3" id="file_1">Choose A File</p>  
                  </label>
                </div>
              </div>
            </div>

            <div class="proposal-file-link pt-3 pb-5 text-center col-4">
              <p class="proposal-file-text">MOA</p>
              <div class="text-center file-upload">
                <div class="file-upload-cont">
                  <label >
                    <input type="file" accept=".pdf" name="file_2" class="inputFile">
                    <svg id="upload-icon" xmlns="http://www.w3.org/2000/svg" width="58.374" height="58.374" viewBox="0 0 58.374 58.374">
                      <path id="Path_737" data-name="Path 737" d="M0,0H58.374V58.374H0Z" fill="none"/>
                      <path id="Path_738" data-name="Path 738" d="M47.064,18.691a18.223,18.223,0,0,0-34.051-4.864,14.587,14.587,0,0,0,1.581,29.089H46.212a12.126,12.126,0,0,0,.851-24.225Zm-13.012,7.2v9.729H24.322V25.89h-7.3L29.187,13.729,41.348,25.89Z" transform="translate(0 5.729)" fill="#1565C0"/>
                    </svg>                          
                    <p class="pt-3" id="file_2">Choose A File</p>  
                  </label>
                </div>
              </div>
            </div>

            <div class="proposal-file-link pt-3 pb-5 text-center col-4">
              <p class="proposal-file-text">Business Permit</p>
              <div class="text-center file-upload">
                <div class="file-upload-cont">
                  <label >
                    <input type="file" accept=".pdf" name="file_3" class="inputFile">
                    <svg id="upload-icon" xmlns="http://www.w3.org/2000/svg" width="58.374" height="58.374" viewBox="0 0 58.374 58.374">
                      <path id="Path_737" data-name="Path 737" d="M0,0H58.374V58.374H0Z" fill="none"/>
                      <path id="Path_738" data-name="Path 738" d="M47.064,18.691a18.223,18.223,0,0,0-34.051-4.864,14.587,14.587,0,0,0,1.581,29.089H46.212a12.126,12.126,0,0,0,.851-24.225Zm-13.012,7.2v9.729H24.322V25.89h-7.3L29.187,13.729,41.348,25.89Z" transform="translate(0 5.729)" fill="#1565C0"/>
                    </svg>                          
                    <p class="pt-3" id="file_3">Choose A File</p>  
                  </label>
                </div>
              </div>
            </div>
      </div>
            <div class="card-footer pb-9">
              {{-- <a href="" class="btn btn-secondary float-right" data-dismiss="modal"><i class="fas fa-plus pr-2"></i>ADD</a> --}}
              <button class="btn btn-secondary float-right" type="submit">CREATE</button> 
            </div>  
            <br><br>
        </form>
          </div>
          
    </div>
  </div>



@stop