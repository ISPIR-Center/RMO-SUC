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
    <div class="row mb-2">
      <div class="col-sm-9 pl-3 mt-3">
          <h1 class="page-heading mt-3"><ion-icon name="grid-outline" size="large"></ion-icon> Research View</h1>    
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
            <h3 class="card-heading py-3">PAP No:
              @if($proposal->paps_no)
               {{ $proposal->paps_no }}
              @else
               ----
              @endif
              </h3>
          </div>
          <div class="col py-3">
            <p class="status-text float-right m-0">Status: <span class="badge status-inprogress">{{ $proposal->status }}</span></p>
          </div>
        </div>
      </div>
      <div class="card-body card-body-proposal">
        <form class="proposal-form" action="dashboard.html">
          <div class="row pb-5">
            <div class="col-xl-6 ml-4">
                <div class="form-group text-left">
                  <label for="InputResearchTitle" class="card-heading py-3">Research Title</label>
                  <p class="card-text">{{ $proposal->title }}</p>
                </div>
  
                <div class="form-group text-left">
                  <label for="InputUniversityAgenda" class="card-heading py-3">University Research Agenda</label>
                  <p class="card-text">{{ $proposal->university_research_agenda }}</p>
                </div>
  
                <div class="form-group text-left">
                  <label for="InputResearchProponent" class="card-heading py-3">Research Proponent</label>
                  <p class="card-text">{{ $proposal->leader }}</p>
                </div>
  
                
  
                <div class="form-group text-left">
                  <label for="InputOutputDeliverables" class="card-heading py-3">List of Outputs/Deliverables</label>
                  <p class="card-text">{{ $proposal->research_deliverables }}</p>
                </div>
  
                <div class="form-group text-left">
                  <label for="InputResearchMember" class="card-heading py-3">Research Member</label>
                  <p class="card-text">
                    @foreach ($members as $item)
                    {{ $item->fullname }} <br>
                @endforeach</p>
              </div>
  
            </div>
  
  
            <div class="col-xl-5 ml-5">
  
              <div class="d-flex">
                <div class="col-6 form-group text-left">
                    <label for="InputDateCompleted" class="card-heading py-3">Date Completed</label>
                    <p class="card-text">{{ date('M d Y', strtotime($proposal->date_completed)) }}</p>
                </div>
  
                <div class="col-6 form-group text-left">
                    <label for="InputProgjectCost" class="card-heading py-3">Project Cost</label>
                    <p class="card-text">{{ $proposal->budget }}</p>
                </div>
              </div>
  
              <div class="d-flex">
                <div class="col-6 form-group text-left">
                    <label for="InputDisciplineCovered" class="card-heading py-3">Discipline Covered</label>
                    <p class="card-text">{{ $proposal->research_discipline_covered }}</p>
                </div>
  
                <div class="col-6 form-group text-left">
                    <label for="InputProgramComponent" class="card-heading py-3">Program Component</label>
                    <p class="card-text">{{ $proposal->research_program_component }}</p>
                </div>
              </div>
  
              <div class="col-12 form-group text-left">
                <label for="InputResearchMember" class="card-heading py-3">Funding Agency</label>
                <p class="card-text">{{ $req->suc_contract_name }}</p>
              </div>
  
              <div class="col-6 proposal-file-link pt-3 pb-3 text-left">
                <p class="card-heading pb-3">Technical Review</p>
                  <div class="text-center proposal-file">
                    <form action="#">
                    <div class="proposal-cont">
                      <svg id="proposal-file-icon" xmlns="http://www.w3.org/2000/svg" width="32.524" height="42.698" viewBox="0 0 32.524 42.698">
                        <path id="Path_930" data-name="Path 930" d="M64.753,42.7H89.771a3.757,3.757,0,0,0,3.753-3.753V12.509H84.767a3.757,3.757,0,0,1-3.753-3.753V0H64.753A3.757,3.757,0,0,0,61,3.753V38.945A3.757,3.757,0,0,0,64.753,42.7Zm5-25.1H84.767a1.251,1.251,0,1,1,0,2.5H69.756a1.251,1.251,0,0,1,0-2.5Zm0,5H84.767a1.251,1.251,0,1,1,0,2.5H69.756a1.251,1.251,0,0,1,0-2.5Zm0,5H84.767a1.251,1.251,0,1,1,0,2.5H69.756a1.251,1.251,0,0,1,0-2.5Zm0,5H79.764a1.251,1.251,0,0,1,0,2.5H69.756a1.251,1.251,0,0,1,0-2.5Z" transform="translate(-61)" fill="#00695C"/>
                        <path id="Path_931" data-name="Path 931" d="M332.251,18.063h8.023L331,8.789v8.023A1.252,1.252,0,0,0,332.251,18.063Z" transform="translate(-308.483 -8.056)" fill="#00695C"/>
                      </svg>                        
                      <p id="fileInputTxtCRP">Technical-Review.pdf</p>
                      <a href="" class="btn btn-secondary" title="View Proposal"><i class="fas fa-eye"></i> View</a>
                    </div>
                  </div> 
                    </form>
                  </div>
               </div>
          </form>
       <hr>
 <!-- ===================================================== Paper Published ===================================================== -->
       <div class="card-body mt-3 mb-4">
        <p class="card-header">Paper Published Details</p>
       <table class="table table-hover text-center bg-white">
         <thead>
           <tr>
             <th scope="col" width="10%" >Year Accepted</th>
             <th scope="col" width="8%">Year Publication</th>
             <th scope="col" width="12%">Author(s)</th>
             <th scope="col" width="20%">Publication Title</th>
             <th scope="col" width="16%">Journal Title</th>
             <th scope="col" width="10%">Vol. No. Issue No.</th>
             <th scope="col" width="8%">No. of Pages</th>
             <th scope="col" width="9%">Publication</th>
             <th scope="col" width="8%">Action</th>
           </tr>
         </thead>
         <tbody>
     
           <tr class="unread text-center">
             <td>January 14, 2006</td>
             <td>March 05, 2006</td>
             <td>Dr. Feliciano T. Villavicencio</td>
             <td>Positive academic emotions moderate the relationship between self-regulation and academic achievement</td>
             <td>Journal of Education Psychology</td>
             <td>Vol 83 No 2</td>
             <td>12</td>
             <td>International</td>
             <td>
               <div class="w-25 dropdown pl-4">
                 <a class="more-options-btn" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                 </a>
                 <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                   <a href="paper-published-details-view.html" class="dropdown-btn dropdown-item"><i class="fa fa-eye"></i> View</a>
                   <a href="paper-published-details-edit.html" class="dropdown-btn dropdown-item"><i class="fa fa-edit"></i> Edit</a>
                   <hr>
                   <a href="#deleteModal" class="dropdown-btn dropdown-item" type="button" data-toggle="modal"><i class="fa fa-trash-alt"></i> Remove</a>
                 </div>
               </div>
             </td>
           </tr>
           
           <tr class="unread text-center">
             <td>January 14, 2006</td>
             <td>March 05, 2006</td>
             <td>Dr. Feliciano T. Villavicencio</td>
             <td>Positive academic emotions moderate the relationship between self-regulation and academic achievement</td>
             <td>Journal of Education Psychology</td>
             <td>Vol 83 No 2</td>
             <td>12</td>
             <td>International</td>
             <td>
               <div class="w-25 dropdown pl-4">
                 <a class="more-options-btn" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                 </a>
                 <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                   <a href="paper-published-details-view.html" class="dropdown-btn dropdown-item"><i class="fa fa-eye"></i> View</a>
                   <a href="paper-published-details-edit.html" class="dropdown-btn dropdown-item"><i class="fa fa-edit"></i> Edit</a>
                   <hr>
                   <a href="#deleteModal" class="dropdown-btn dropdown-item" type="button" data-toggle="modal"><i class="fa fa-trash-alt"></i> Remove</a>
                 </div>
               </div>
             </td>
           </tr>
         </tbody>
       </table>
       <div class="mt-2">
         <a href="Book-cited-add.html" class="btn btn-primary float-right px-3"><i class="fas fa-plus pr-2"></i> ADD</a>
       </div>
     </div>
     
     <!-- ===================================================== Journal Cited by Other Researcher(s) ===================================================== -->
     <div class="card-body my-4">
       <p class="card-header">Journal Cited by Other Researcher(s)</p>
      <table class="table table-hover text-center bg-white">
        <thead>
          <tr>
            <th scope="col" width="22%" >Title of New Publication</th>
            <th scope="col" width="15%">Author(s)</th>
            <th scope="col" width="15%">Journal Publisher</th>
            <th scope="col" width="9%">Vol. No. Issue No.</th>
            <th scope="col" width="8%">No. of Pages</th>
            <th scope="col" width="9%">Publication</th>
            <th scope="col" width="10%">Year of Publication</th>
            <th scope="col" width="6%">Action</th>
          </tr>
        </thead>
        <tbody>
     
          <tr class="unread text-center">
            <td>Building on the positive in children’s lives: co-partifipatory study on the social construction of children’s sense of agency</td>
            <td>Kristina Kumpulainen, Lasse Lipponen, Jaakko Hilppo, Anna Mikkola</td>
            <td>Early Child Development and Care</td>
            <td>Vol 83 No 2</td>
            <td>12</td>
            <td>International</td>
            <td>2014</td>
            <td>
              <div class="w-25 dropdown pl-4">
                <a class="more-options-btn" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                </a>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                  <a href="journal-cited-view.html" class="dropdown-btn dropdown-item"><i class="fa fa-eye"></i> View</a>
                  <a href="journal-cited-edit.html" class="dropdown-btn dropdown-item"><i class="fa fa-edit"></i> Edit</a>
                  <hr>
                  <a href="#deleteModal" class="dropdown-btn dropdown-item"  type="button" data-toggle="modal"><i class="fa fa-trash-alt"></i> Remove</a>
                </div>
              </div>
            </td>
          </tr>
     
          <tr class="unread text-center">
           <td>Building on the positive in children’s lives: co-partifipatory study on the social construction of children’s sense of agency</td>
           <td>Kristina Kumpulainen, Lasse Lipponen, Jaakko Hilppo, Anna Mikkola</td>
           <td>Early Child Development and Care</td>
           <td>Vol 83 No 2</td>
           <td>12</td>
           <td>International</td>
           <td>2014</td>
           <td>
             <div class="w-25 dropdown pl-4">
               <a class="more-options-btn" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
               </a>
               <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                 <a href="journal-cited-view.html" class="dropdown-btn dropdown-item"><i class="fa fa-eye"></i> View</a>
                 <a href="journal-cited-edit.html" class="dropdown-btn dropdown-item"><i class="fa fa-edit"></i> Edit</a>
                 <hr>
                 <a href="#deleteModal" class="dropdown-btn dropdown-item"  type="button" data-toggle="modal"><i class="fa fa-trash-alt"></i> Remove</a>
               </div>
             </div>
           </td>
         </tr>
        </tbody>
      </table>
      <div class="mt-2">
       <a href="Book-cited-add.html" class="btn btn-primary float-right px-3"><i class="fas fa-plus pr-2"></i> ADD</a>
     </div>
     </div>
     
     <!-- ===================================================== Book Cited by Other Researcher(s) ===================================================== -->
     <div class="card-body my-4">
     <p class="card-header">Book Cited by Other Researcher(s)</p>
     <table class="table table-hover text-center bg-white">
      <thead>
        <tr>
          <th scope="col" width="22%" >Title of New Book Chapter</th>
          <th scope="col" width="16%">Author(s)</th>
          <th scope="col" width="16%">Journal Publisher</th>
          <th scope="col" width="10%">Vol. No. Issue No.</th>
          <th scope="col" width="8%">No. of Pages</th>
          <th scope="col" width="10%">Year of Publication</th>
          <th scope="col" width="10%">ISBN</th>
          <th scope="col" width="6%">Action</th>
        </tr>
      </thead>
      <tbody>
     
        <tr class="unread text-center">
          <td>Building on the positive in children’s lives: co-partifipatory study on the social construction of children’s sense of agency</td>
          <td>Kristina Kumpulainen, Lasse Lipponen, Jaakko Hilppo, Anna Mikkola</td>
          <td>Early Child Development and Care</td>
          <td>Vol 83 No 2</td>
          <td>12</td>
          <td>2015</td>
          <td>1-4786-2200-8</td>
          <td>
            <div class="w-25 dropdown pl-4">
              <a class="more-options-btn" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              </a>
              <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                <a href="book-cited-view.html" class="dropdown-btn dropdown-item"><i class="fa fa-eye"></i> View</a>
                <a href="book-cited-edit.html" class="dropdown-btn dropdown-item"><i class="fa fa-edit"></i> Edit</a>
                <hr>
                <a href="#deleteModal" class="dropdown-btn dropdown-item"  type="button" data-toggle="modal"><i class="fa fa-trash-alt"></i> Remove</a>
              </div>
            </div>
          </td>
        </tr>
     
        <tr class="clickable-row unread text-center" data-href="research-view.html">
         <td>Building on the positive in children’s lives: co-partifipatory study on the social construction of children’s sense of agency</td>
         <td>Kristina Kumpulainen, Lasse Lipponen, Jaakko Hilppo, Anna Mikkola</td>
         <td>Early Child Development and Care</td>
         <td>Vol 83 No 2</td>
         <td>12</td>
         <td>2015</td>
         <td>1-4786-2200-8</td>
         <td>
           <div class="w-25 dropdown pl-4">
             <a class="more-options-btn" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
             </a>
             <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
               <a href="researcher-view.html" class="dropdown-btn dropdown-item"><i class="fa fa-eye"></i> View</a>
               <a href="faculty-edit.html" class="dropdown-btn dropdown-item"><i class="fa fa-edit"></i> Edit</a>
               <hr>
               <a href="#deleteModal" class="dropdown-btn dropdown-item"  type="button" data-toggle="modal"><i class="fa fa-trash-alt"></i> Remove</a>
             </div>
           </div>
         </td>
       </tr>
      </tbody>
     </table>
     <div class="mt-2">
     <a href="Book-cited-add.html" class="btn btn-primary float-right px-3"><i class="fas fa-plus pr-2"></i> ADD</a>
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

  