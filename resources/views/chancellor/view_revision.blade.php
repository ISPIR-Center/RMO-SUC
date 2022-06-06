@extends('index')

@section('navbar')
<nav class="navbar navbar-light fixed-top bg-light p-0 shadow">
  <div class="container-fluid">
    <div class="py-3 m-0">
     <a href="{{ route('chancellor-rbp') }}"><img src="{{ asset('img/logo/rmo-logo.png') }}" class="navbar-office-logo"></a>
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

        <x-navbar.chancellor :active="$active"></x-navbar.chancellor>
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
            @if ($proposal->is_presented =="1" and $proposal->is_published =="0" and $proposal->status =="APPROVED")
            <p class="status-text float-right m-0">Status: <span class="badge status-ongoing">PRESENTED</span></p>
            @elseif ($proposal->is_published =="1" and $proposal->is_presented =="0" and $proposal->status =="APPROVED")
            <p class="status-text float-right m-0">Status: <span class="badge status-compliant">PUBLISHED</span></p>
            @elseif ($proposal->is_utilized =="1" and $proposal->is_patented =="0" and $proposal->status =="APPROVED")
            <p class="status-text float-right m-0">Status: <span class="badge status-noncompliant">UTILIZED</span></p>
            @elseif ($proposal->is_patented =="1" and $proposal->is_utilized =="0" and $proposal->status =="APPROVED")
            <p class="status-text float-right m-0">Status: <span class="badge status-completed">PATENTED</span></p>
            @elseif ($proposal->is_utilized =="1" AND $proposal->is_patented =="1" and $proposal->status =="APPROVED")
            <p class="status-text float-right m-0">Status: <span class="badge status-pending">UTILIZED & PATENTED</span></p>
            @elseif ($proposal->is_published =="1" AND $proposal->is_presented =="1" and $proposal->status =="APPROVED")
            <p class="status-text float-right m-0">Status: <span class="badge status-draft">PUBLISHED & PRESENTED</span></p>
            @elseif ($proposal->status =="PENDING")
            <p class="status-text float-right m-0">Status: <span class="badge status-pending">PENDING</span></p>
            @else
            <p class="status-text float-right m-0">Status: <span class="badge status-inprogress">Declined by {{ $proposal->status }}</span></p>
            @endif
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
    <!-- ===================================================== Paper Presentation Details ===================================================== -->
    @if ($paperpresenteds->count())
    <div class="card-body mt-3 mb-4">
      <p class="card-header"><b>Paper Presentation Details</b></p>
     <table class="table table-hover text-center bg-white">
       <thead>
         <tr>
           <th scope="col" width="22%" >Title</th>
           <th scope="col" width="12%">Presenter(s)</th>
           <th scope="col" width="15%">Alternative Title</th>
           <th scope="col" width="15%">Venue</th>
           <th scope="col" width="10%">Date</th>
           <th scope="col" width="8%">Organizer</th>
           <th scope="col" width="9%">Type of Conference</th>
           <th scope="col" width="10%">Status</th>
           <th scope="col" width="8%">Action</th>
         </tr>
       </thead>
       <tbody>
       
        @foreach ($paperpresenteds as $paperpresented)
         <tr class="unread text-center">
           <td>{{ $paperpresented->paper_title }}</td>
           <td>{{ $paperpresented->presenters }}</td>
           <td>{{ $paperpresented->paper_title_2 }}</td>
           <td>{{ $paperpresented->venue }}</td>
           <td>{{ $paperpresented->date }}</td>
           <td>{{ $paperpresented->organizer }}</td>
           <td>{{ $paperpresented->conference_type }}</td>
           <td>{{ $paperpresented->status }}</td>
           <td>
            <a href="/chancellor/paper-presented/view/{{$paperpresented->id}}/{{ $proposal->id }}" class="btn btn-secondary float-center"><i class="fas fa-eye"></i></a>
           </td>
         </tr>
         @endforeach
       </tbody>
     </table>
   </div>
    @else
  
      @endif
 
  <!-- ===================================================== Paper Published ===================================================== -->
  @if ($paperpublisheds->count())
  <div class="card-body mt-3 mb-4">

    <p class="card-header"><b> Paper Published Details</b></p>
   <table class="table table-hover text-center bg-white">
     <thead>
       <tr>
         <th scope="col" width="10%" >Year Accepted</th>
         <th scope="col" width="8%">Year Publication</th>
         <th scope="col" width="12%">Publisher</th>
         <th scope="col" width="20%">Publication Title</th>
         <th scope="col" width="16%">Journal Title</th>
         <th scope="col" width="10%">Vol. No. Issue No.</th>
         <th scope="col" width="8%">No. of Pages</th>
         <th scope="col" width="9%">Publication</th>
         <th scope="col" width="9%">Status</th>
         <th scope="col" width="8%">Action</th>
       </tr>
     </thead>
     <tbody>
      @foreach ($paperpublisheds as $paperpublished)
       <tr class="unread text-center">
         <td>{{ $paperpublished->year_accepted }}</td>
         <td>{{ $paperpublished->year_published }}</td>
         <td>{{ $paperpublished->publisher }}</td>
         <td>{{ $paperpublished->publication_title }}</td>
         <td>{{ $paperpublished->journal_title }}</td>
         <td>{{ $paperpublished->vol_no }}</td>
         <td>{{ $paperpublished->pages }}</td>
         <td>{{ $paperpublished->publication }}</td>
         <td>{{ $paperpublished->status }}</td>
         <td>
          <a href="/chancellor/paper-published/view/{{$paperpublished->id}}/{{ $proposal->id }}" class="btn btn-secondary float-center"><i class="fas fa-eye"></i></a>
         </td>
       </tr>
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
      <form action="{{ route('chancellor-published-delete', $paperpublished->id) }}" method="post">
        @csrf
        <button type="submit" class="btn btn-primary">Yes</button>
      </form>   
       <a href="" class="btn btn-primary" data-dismiss="modal">No</a>
    </div>
  </div>
</div>
</div>
       @endforeach
     </tbody>
   </table>
  
 </div>
       @else
        
       @endif
 
 <!-- ===================================================== Journal Cited by Other Researcher(s) ===================================================== -->
 @if ($journalciteds->count())
 <div class="card-body mt-3 mb-4">
 
   <p class="card-header"><b> Journal Cited by Other Researcher(s)</b></p>
  <table class="table table-hover text-center bg-white">
    <thead>
      <tr>
        <th scope="col" width="16%" >Title of New Publication</th>
        <th scope="col" width="15%">Author(s)</th>
        <th scope="col" width="10%">Journal Publisher</th>
        <th scope="col" width="12%">Cited Link</th>
        <th scope="col" width="9%">Publication</th>
        <th scope="col" width="8%">Vol No Issue No</th>
        <th scope="col" width="4%">Pages</th> 
        <th scope="col" width="10%">Year of Publication</th>
        <th scope="col" width="8%">Status</th>
        
      </tr>
    </thead>
    <tbody>
      
      @foreach ($journalciteds as $journalcited)
       <tr class=" unread text-center" >
         <td>{{ $journalcited->journal_title }}</td>
         <td>{{ $journalcited->authors }}</td>
         <td>{{ $journalcited->publisher }}</td>
         <td><a href="{{ $journalcited->link }}" target="_blank">{{ $journalcited->link }}</a> </td>
         <td>{{ $journalcited->publication }}</td>
         <td>{{ $journalcited->vol_no }}</td>
         <td>{{ $journalcited->pages }}</td>
         <td>{{ $journalcited->year_published }}</td>
         <td>{{ $journalcited->status }}</td>
       </tr>
      <!-- DELETE UTILIZED -->

       @endforeach
    </tbody>
  </table>
 </div>
      @else
           
       @endif
 
 <!-- ===================================================== Book Cited by Other Researcher(s) ===================================================== -->
 @if ($bookciteds->count())
 <div class="card-body mt-3 mb-4">
  
 <p class="card-header"><b> Book Cited by Other Researcher(s)</b></p>
 <table class="table table-hover text-center bg-white">
  <thead>
    <tr>
      <th scope="col" width="18%" >Title of New Book Chapter</th>
      <th scope="col" width="16%">Author(s)</th>
      <th scope="col" width="12%">Journal Publisher</th>
      <th scope="col" width="12%">Cited Link</th>
      <th scope="col" width="8%">Year of Publication</th>
      <th scope="col" width="7%">Vol No Issue No</th>
      <th scope="col" width="4%">Pages</th>
      <th scope="col" width="6%">ISBN</th>
      <th scope="col" width="6%">Status</th>  
    </tr>
  </thead>
  <tbody>
    
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
       <td>{{ $bookcited->status }}</td>
    </tr>
     @endforeach
    
  </tbody>
 </table>
 </div> 
    @else
     
     @endif
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
        <form class="proposal-form" action="{{ route('dean-rbp-view', $proposal->id) }}" method="POST">
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


@stop