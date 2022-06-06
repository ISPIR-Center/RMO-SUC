@extends('index')

@section('content')
<body class="ms-fill">
    <nav class="navbar navbar-light fixed-top bg-light p-0 shadow">
        <div class="container-fluid">
          <div class="py-3 m-0">
           <a href="{{ route('faculty-rbp') }}"><img src="{{ asset('./img/logo/rmo-logo.png') }}" class="navbar-office-logo"></a>
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
          
                <a href="{{ route('faculty-view-profile',$user->id) }}"><p class="sidebar-user-name">{{ $user->fullname }}</p></a>
                      <p class="sidebar-user-email">{{ auth()->user()->email }}</p>
              
                  </div>
              </div>

              <x-navbar.faculty :active="$active"></x-navbar.faculty>
        </div>
        
        <!-- Page content wrapper-->
        <div id="page-content-wrapper">
          <!-- Content Header -->
          <div class="container-fluid">
            <!-- Page Title -->
            <h1 class="page-heading mt-2"><ion-icon name="grid-outline" size="large"></ion-icon> Pending Researches</h1>
            <!-- Search and Create Button -->
            <div class="content-header">
              <div class="container-fluid">
                <div class="row mb-2">
               
                
                </div>
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
        @if($data)
        <!-- Start of content table -->
       <div class="container-fluid py-2">
        <div class="card table-container">
          <div class="card-body card-body-proposal">
            <form class="proposal-form" action="{{ route('faculty-rbp-edit', $data->id) }}" method="POST" enctype="multipart/form-data">
              @csrf
              @method('PUT')
              <div class="row py-1">
                <div class="col-xl-6 ml-4">
                    <div class="form-group text-left">
                      <label for="InputResearchTitle" class="card-heading py-3">Research Title</label>
                      <input type="text" class="form-control" id="InputResearchTitle" name="proposal_title" value= {{ $data->title }} >
                    </div>

                    <div class="d-flex ">
                      <div class="form-group text-left col-xl-6 px-0">
                      <label for="InputProgramComponent" class="card-heading py-3"> Type </label>
                      <div class="input-group" id="InputProgramComponent">
                        <select class="form-control" name="type">
                          <option hidden>{{ $data->type }}</option>
                          <option value="Program">Program</option>
                          <option value="Project">Project</option>
                          <option value="Study">Study</option>
                        </select>                 
                       </div>
                      </div>

                    <div class="form-group text-left col-xl-6 px-0 ml-2">
                      <label for="InputDiscipline" class="card-heading py-3">Discipline Covered</label>
                      <select name="research_discipline_covered" id="research_discipline_covered" class="form-control">
                          <option value="{{ $data->discipline_covered }}">{{ $data->discipline_covered }} </option>
                        @foreach ($research_discipline_covered as $discipline_cov)
                        <option value="{{ $discipline_cov->name }}">{{ $discipline_cov->name }}</option>
                        @endforeach 
                      </select>
                      </div>
                    </div>  
                    <div class="d-flex ">
                      <div class="form-group text-left col-xl-6 px-0">
                        <label for="InputProgramComponent" class="card-heading py-3">Program Component</label>
                      <input type="text" class="form-control" id="InputProgramComponent" name="research_program_component" value= {{ $data->program_component }} required>
                      </div>
                      <div class="form-group text-left col-xl-6 px-0 ml-2">
                        <label for="InputDateCompleted" class="card-heading py-3"> Date Completed</label>
                        <input type="text" class="form-control" id="InputDateCompleted" name="research_date_completed" value={{ $data->date_completed }} >
                    </div>
                    </div>
                 <div class="d-flex ">
                   <div class="form-group text-left col-xl-6 px-0">
                    <label for="InputProgramComponent" class="card-heading py-3"> Funded Year from MOA</label>
                    <p class="card-text2">{{ $data->funded_on }}</p>
                   </div>
                   <div class="form-group text-left col-xl-6 px-0 ml-2">
                    <label for="InputDateCompleted" class="card-heading py-3"> Budget Issued (BSU)</label>
                    <p class="card-text2">{{ $data->budget_bsu }}</p>
                   </div>
                </div> 
                @if ( $data->remarks)
                <div class="form-group text-left col-xl-6 px-0">
                  <label for="InputProgramComponent" class="card-heading py-3"> Remarks from the Evaluator</label>
                  <p class="card-text2">{{ $data->remarks }}</p>
                 </div>
                @endif
             </div>

                <div class="col-xl-5 ml-5">


                  <div class="form-group text-left">
                    <label for="InputUniversityAgenda" class="card-heading py-3">University Research Agenda</label>
                    <input type="text" class="form-control" id="InputUniversityAgenda" name="university_research_agenda" value={{ $data->university_research_agenda }} required>
                    </div>

                    <div class="d-flex ">
                      <div class="form-group text-left col-xl-6 px-0">
                        <label for="InputProjectCost" class="card-heading py-3">Project Cost</label>
                        <input type="text" class="form-control" id="InputProjectCost" name="budget" value={{ $data->budget }} required>
                      </div>
                      <div class="form-group text-left col-xl-6 px-0 ml-2">
                        <label for="InputResearchMember" class="card-heading py-3">Funding Agency</label>
                    <input type="text" class="form-control" id="InputResearchMember" name="research_funding_agency" value={{ $data->funding_agency }} required>
                      </div>
                   </div>

                   <div class="d-flex ">
                    <div class="form-group text-left col-xl-6 px-0">
                      <label for="InputProjectCost" class="card-heading py-3">Contract From</label>
                      <input type="date" class="form-control" id="InputProjectCost" name="budget" value={{ $data->contract_from }} required>
                    </div>
                    <div class="form-group text-left col-xl-6 px-0 ml-2">
                      <label for="InputResearchMember" class="card-heading py-3">Contract To</label>
                  <input type="date" class="form-control" id="InputResearchMember" name="research_funding_agency" value={{ $data->contract_to }} required>
                    </div>
                 </div>

               
                  <h3 class="card-heading py-3">Proposal Files:</h3>
                  <div class="row">
      
                      <div class="proposal-file-link pt-3 pb-5 px-5 text-center">
                        <p class="proposal-file-text">
                          Completed File
                          <a
                            tabindex="0"
                            class="colored"
                            role="button"
                            data-toggle="popover"
                            data-trigger="hover"
                            data-html="true"
                            data-content="This File is Required."
                            ><i class="fa fa-info-circle"></i
                          ></a>
                        </p>
                        <div class="text-center file-upload">
                          <div class="file-upload-cont">
                            <label >
                              <input type="file" accept=".pdf" name="fileInputCF" class="inputFile" value={{ $data->completed_file }}>
                              @if($data)
                                @if ($data->completed_file)
                                  <svg id="proposal-file-icon" xmlns="http://www.w3.org/2000/svg" width="32.524" height="42.698" viewBox="0 0 32.524 42.698">
                                    <path id="Path_930" data-name="Path 930" d="M64.753,42.7H89.771a3.757,3.757,0,0,0,3.753-3.753V12.509H84.767a3.757,3.757,0,0,1-3.753-3.753V0H64.753A3.757,3.757,0,0,0,61,3.753V38.945A3.757,3.757,0,0,0,64.753,42.7Zm5-25.1H84.767a1.251,1.251,0,1,1,0,2.5H69.756a1.251,1.251,0,0,1,0-2.5Zm0,5H84.767a1.251,1.251,0,1,1,0,2.5H69.756a1.251,1.251,0,0,1,0-2.5Zm0,5H84.767a1.251,1.251,0,1,1,0,2.5H69.756a1.251,1.251,0,0,1,0-2.5Zm0,5H79.764a1.251,1.251,0,0,1,0,2.5H69.756a1.251,1.251,0,0,1,0-2.5Z" transform="translate(-61)" fill="#00695C"/>
                                    <path id="Path_931" data-name="Path 931" d="M332.251,18.063h8.023L331,8.789v8.023A1.252,1.252,0,0,0,332.251,18.063Z" transform="translate(-308.483 -8.056)" fill="#00695C"/>
                                  </svg>   
                                  <p class="pt-3" id="fileInputCF">{{ $data->completed_file }}</p>  
                                @else
                                  <svg id="upload-icon" xmlns="http://www.w3.org/2000/svg" width="58.374" height="58.374" viewBox="0 0 58.374 58.374">
                                    <path id="Path_737" data-name="Path 737" d="M0,0H58.374V58.374H0Z" fill="none"/>
                                    <path id="Path_738" data-name="Path 738" d="M47.064,18.691a18.223,18.223,0,0,0-34.051-4.864,14.587,14.587,0,0,0,1.581,29.089H46.212a12.126,12.126,0,0,0,.851-24.225Zm-13.012,7.2v9.729H24.322V25.89h-7.3L29.187,13.729,41.348,25.89Z" transform="translate(0 5.729)" fill="#00695C"/>
                                  </svg>                          
                                  <p class="pt-3" id="fileInputCF">Choose A File</p>  
                                @endif 
                              @else
                                <svg id="upload-icon" xmlns="http://www.w3.org/2000/svg" width="58.374" height="58.374" viewBox="0 0 58.374 58.374">
                                  <path id="Path_737" data-name="Path 737" d="M0,0H58.374V58.374H0Z" fill="none"/>
                                  <path id="Path_738" data-name="Path 738" d="M47.064,18.691a18.223,18.223,0,0,0-34.051-4.864,14.587,14.587,0,0,0,1.581,29.089H46.212a12.126,12.126,0,0,0,.851-24.225Zm-13.012,7.2v9.729H24.322V25.89h-7.3L29.187,13.729,41.348,25.89Z" transform="translate(0 5.729)" fill="#00695C"/>
                                </svg>                          
                                <p class="pt-3" id="fileInputCF">Choose A File</p>   
                              @endif
                            </label>
                          </div>
                        </div>
                        <br>
                        <a href="{{ asset('requirements/' . $data->completed_file) ."#toolbar=0" }}" target="_blank" class="btn btn-secondary" title="View Proposal"><i class="fa fa-eye"></i> View</a>
                      </div>
      
                      <div class="proposal-file-link pt-3 pb-5 px-5 text-center">
                        <p class="proposal-file-text">
                          Contract File
                          <a
                            tabindex="0"
                            class="colored"
                            role="button"
                            data-toggle="popover"
                            data-trigger="hover"
                            data-html="true"
                            data-content="This File is Required."
                            ><i class="fa fa-info-circle"></i
                          ></a>
                        </p>
                        <div class="text-center file-upload">
                          <div class="file-upload-cont">
                            <label >
                              <input type="file" accept=".pdf" name="fileInputPCF" class="inputFile" value={{ $data->partner_contract_file }}>
                              @if($data)
                                @if ($data->partner_contract_file)
                                  <svg id="proposal-file-icon" xmlns="http://www.w3.org/2000/svg" width="32.524" height="42.698" viewBox="0 0 32.524 42.698">
                                    <path id="Path_930" data-name="Path 930" d="M64.753,42.7H89.771a3.757,3.757,0,0,0,3.753-3.753V12.509H84.767a3.757,3.757,0,0,1-3.753-3.753V0H64.753A3.757,3.757,0,0,0,61,3.753V38.945A3.757,3.757,0,0,0,64.753,42.7Zm5-25.1H84.767a1.251,1.251,0,1,1,0,2.5H69.756a1.251,1.251,0,0,1,0-2.5Zm0,5H84.767a1.251,1.251,0,1,1,0,2.5H69.756a1.251,1.251,0,0,1,0-2.5Zm0,5H84.767a1.251,1.251,0,1,1,0,2.5H69.756a1.251,1.251,0,0,1,0-2.5Zm0,5H79.764a1.251,1.251,0,0,1,0,2.5H69.756a1.251,1.251,0,0,1,0-2.5Z" transform="translate(-61)" fill="#00695C"/>
                                    <path id="Path_931" data-name="Path 931" d="M332.251,18.063h8.023L331,8.789v8.023A1.252,1.252,0,0,0,332.251,18.063Z" transform="translate(-308.483 -8.056)" fill="#00695C"/>
                                  </svg>   
                                  <p class="pt-3" id="fileInputPCF">{{ $data->partner_contract_file }}</p>  
                                @else
                                  <svg id="upload-icon" xmlns="http://www.w3.org/2000/svg" width="58.374" height="58.374" viewBox="0 0 58.374 58.374">
                                    <path id="Path_737" data-name="Path 737" d="M0,0H58.374V58.374H0Z" fill="none"/>
                                    <path id="Path_738" data-name="Path 738" d="M47.064,18.691a18.223,18.223,0,0,0-34.051-4.864,14.587,14.587,0,0,0,1.581,29.089H46.212a12.126,12.126,0,0,0,.851-24.225Zm-13.012,7.2v9.729H24.322V25.89h-7.3L29.187,13.729,41.348,25.89Z" transform="translate(0 5.729)" fill="#00695C"/>
                                  </svg>                          
                                  <p class="pt-3" id="fileInputPCF">Choose A File</p>  
                                @endif 
                              @else
                                <svg id="upload-icon" xmlns="http://www.w3.org/2000/svg" width="58.374" height="58.374" viewBox="0 0 58.374 58.374">
                                  <path id="Path_737" data-name="Path 737" d="M0,0H58.374V58.374H0Z" fill="none"/>
                                  <path id="Path_738" data-name="Path 738" d="M47.064,18.691a18.223,18.223,0,0,0-34.051-4.864,14.587,14.587,0,0,0,1.581,29.089H46.212a12.126,12.126,0,0,0,.851-24.225Zm-13.012,7.2v9.729H24.322V25.89h-7.3L29.187,13.729,41.348,25.89Z" transform="translate(0 5.729)" fill="#00695C"/>
                                </svg>                          
                                <p class="pt-3" id="fileInputPCF">Choose A File</p>   
                              @endif
                            </label>
                          </div>
                        </div>
                        <br>
                        <a href="{{ asset('requirements/' . $data->partner_contract_file) ."#toolbar=0" }}" target="_blank" class="btn btn-secondary" title="View Proposal"><i class="fa fa-eye"></i> View</a>
                      </div>
                    </div>
                </div>
              </div>
      
              
                @if ($data->deliverables == "Research Based Paper")
                <!-- ===================================================== Paper Presentation Details ===================================================== -->
                @if ($paperpresenteds->count())
                <hr>
                <div class="card-body mt-3 mb-4">
                  <p class="card-header"><b>Paper Presentation Details</b></p>
                 <table class="table table-hover text-center bg-white">
                   <thead>
                     <tr>
                       <th scope="col" width="22%" >Title</th>
                       <th scope="col" width="12%">Presenter(s)</th>
                       <th scope="col" width="15%">Alternative Title</th>
                       <th scope="col" width="8%">Date</th>
                       <th scope="col" width="15%">Conference Type</th>
                       <th scope="col" width="15%">Rejected by</th>
                       <th scope="col" width="20%">Action</th>
                     </tr>
                   </thead>
                   <tbody>
                    @foreach ($paperpresenteds as $paperpresented)
                     <tr class="unread text-center">
                       <td>{{ $paperpresented->paper_title }}</td>
                       <td>{{ $paperpresented->presenters }}</td>
                       <td>{{ $paperpresented->paper_title_2 }}</td>
                       <td>{{ $paperpresented->date }}</td>
                       <td>{{ $paperpresented->conference_type }}</td>
                       <td>{{ $paperpresented->status }}</td>
                       <td>
                        
                        <a href="/faculty/paper-presented/edit/{{ $data->id }}/{{$paperpresented->id}}" class="btn btn-secondary"><i class="fas fa-edit"></i></a>
                        <a href="#presentedDeleteModal-{{ $paperpresented->id }}" class="btn btn-secondary" data-toggle="modal"><i class="fas fa-trash"></i></a>
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
                   </tbody>
                 </table>
                 {{-- <div class="mt-2">
                  <a href="{{ url('/rmo/paper-presented/create/'.$data->id) }}" class="btn btn-primary float-right px-3" type="submit"><i class="fas fa-plus pr-2"></i> ADD</a>
                </div> --}}
               </div>
           @endif
             
              <!-- ===================================================== Paper Published ===================================================== -->
              @if ($paperpublisheds->count())
              <div class="card-body mt-3 mb-4">
          <hr>
                <p class="card-header"><b> Paper Published Details</b></p>
               <table class="table table-hover text-center bg-white">
                 <thead>
                   <tr>
                     <th scope="col" width="10%" >Year Accepted</th>
                     <th scope="col" width="8%">Year Publication</th>
                     <th scope="col" width="12%">Publisher</th>
                     <th scope="col" width="20%">Publication Title</th>
                     <th scope="col" width="16%">Journal Title</th>
                     <th scope="col" width="9%">Publication</th>
                     <th scope="col" width="9%">Status</th>
                     <th scope="col" width="20%">Action</th>
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
                     <td>{{ $paperpublished->publication }}</td>
                     <td>{{ $paperpublished->status }}</td>
                     <td>
                     
                      <a href="/faculty/paper-published/edit/{{ $data->id }}/{{$paperpublished->id}}" class="btn btn-secondary"><i class="fas fa-edit"></i></a>
                      <a href="#publishedDeleteModal-{{ $paperpublished->id }}" class="btn btn-secondary" data-toggle="modal"><i class="fas fa-trash"></i></a>
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
                 </tbody>
               </table>
             </div>
           @endif  
             <!-- ===================================================== Journal Cited by Other Researcher(s) ===================================================== -->
             @if ($journalciteds->count())
             <div class="card-body my-4">
         <hr>
               <p class="card-header"><b> Journal Cited by Other Researcher(s)</b></p>
              <table class="table table-hover text-center bg-white">
                <thead>
                  <tr>
                    <th scope="col" width="16%" >New Publication Title</th>
                    <th scope="col" width="14%">Author(s)</th>
                    <th scope="col" width="10%">Journal Publisher</th>
                    <th scope="col" width="12%">Cited Link</th>
                    <th scope="col" width="9%">Publication</th>
                    <th scope="col" width="7%">Vol No Issue No</th>
                    <th scope="col" width="4%">Pages</th> 
                    <th scope="col" width="10%">Year of Publication</th>
                    <th scope="col" width="8%">Declined by</th>
                    <th scope="col" width="20%">Action</th>
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
                     <td>
                      {{-- <a href="/rmo/journal-cited/view/{{$journalcited->id}}" class="btn btn-secondary"><i class="fas fa-eye"></i></a> --}}
                      <a href="/faculty/journal-cited/edit/{{ $data->id }}/{{$journalcited->id}}" class="btn btn-secondary"><i class="fas fa-edit"></i></a>
                      <a href="#journalCitedDeleteModal-{{ $journalcited->id }}" class="btn btn-secondary" data-toggle="modal"><i class="fas fa-trash"></i></a>
                     </td>
                   </tr>
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
                </tbody>
              </table>
              {{-- <div class="mt-2">
               <a href="{{ url('/rmo/journal-cited/create/'.$data->id) }}" class="btn btn-primary float-right px-3"><i class="fas fa-plus pr-2"></i> ADD</a>
             </div> --}}
             </div>
             @endif
             
             <!-- ===================================================== Book Cited by Other Researcher(s) ===================================================== -->
             @if ($bookciteds->count())
             <div class="card-body my-4">
             <hr>
             <p class="card-header"><b> Book Cited by Other Researcher(s)</b></p>
             <table class="table table-hover text-center bg-white">
              <thead>
                <tr>
                  <th scope="col" width="16%" >New Book Chapter Title</th>
                  <th scope="col" width="14%">Author(s)</th>
                  <th scope="col" width="10%">Journal Publisher</th>
                  <th scope="col" width="12%">Cited Link</th>
                  <th scope="col" width="9%">Publication Year</th>
                  <th scope="col" width="7%">Vol No Issue No</th>
                  <th scope="col" width="4%">Pages</th>
                  <th scope="col" width="4%">ISBN</th>
                  <th scope="col" width="6%">Declined by</th>
                  <th scope="col" width="20%">Action</th>
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
                   <td>
                    {{-- <a href="/rmo/book-cited/view/{{$bookcited->id}}" class="btn btn-secondary"><i class="fas fa-eye"></i></a> --}}
                    <a href="/faculty/book-cited/edit/{{ $data->id }}/{{$bookcited->id}}" class="btn btn-secondary"><i class="fas fa-edit"></i></a>
                    <a href="#bookcitedDeleteModal-{{ $bookcited->id }}" class="btn btn-secondary" data-toggle="modal"><i class="fas fa-trash"></i></a>
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
              </tbody>
             </table>
             {{-- <div class="mt-2">
             <a href="{{ url('/rmo/book-cited/create/'.$data->id) }}" class="btn btn-primary float-right px-3"><i class="fas fa-plus pr-2"></i> ADD</a>
             </div> --}}
             <br><br>
             </div> 
             @endif
            <!-- -----------------------------------------I N V E N T I O N---------------------------------------------------------- -->
            @elseif ($data->research_deliverables == "Invention")
            <div class="card-body mt-3 mb-4">
             <p class="card-header"><b>Invention Patent Details</b></p>
            <table class="table table-hover text-center bg-white">
              <thead>
                <tr>
                  <th scope="col" width="10%" >Patent No.</th>
                  <th scope="col" width="20%">Name of Commercial Product</th>
                  <th scope="col" width="15%">Utilization</th>
                  <th scope="col" width="15%">Issued Date</th>
                  <th scope="col" width="30%">Status</th>
                  <th scope="col" width="25%">Action</th>
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
                  <td>{{ $patented->status }}</td>
                  <td>
                    <div class="w-28 dropdown pl-1">
                      <a class="more-options-btn" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      </a>
                      <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        @if ($patented->status =="APPROVED")
                        <a href="#patentedEditModal-{{ $patented->id }}" data-toggle="modal" class="dropdown-btn dropdown-item" aria-disabled="true"><i class="fa fa-edit"></i> Edit</a>
                        @else
                        <a href="#patentedEditModal-{{ $patented->id }}" data-toggle="modal" class="dropdown-btn dropdown-item"><i class="fa fa-edit"></i> Edit</a>
                        @endif
                        <hr>
                        <a href="#patentedDeleteModal-{{ $patented->id }}" data-toggle="modal" class="dropdown-btn dropdown-item"  type="button" data-toggle="modal"><i class="fa fa-trash-alt"></i> Remove</a>
                      </div>
                    </div>
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
            {{-- <div class="mt-2">
             <a href="{{ url('/rmo/patented/create/'.$data->id) }}" class="btn btn-primary float-right px-3"  type="submit"><i class="fas fa-plus pr-2"></i> ADD</a>
            
            </div> --}}
            </div>
            
            
            <!-- ===================================================== Utilized ===================================================== -->
            <div class="card-body mt-3 mb-4">
              <br><br><hr>
            <p class="card-header"><b>Invention Utilized Details</b></p>
            <table class="table table-hover text-center bg-white">
             <thead>
               <tr>
                 <th scope="col" width="20%" >Photo</th>
                 <th scope="col" width="20%">MOA</th>
                 <th scope="col" width="20%">Business Permit</th>
                 <th scope="col" width="20%">Status</th>
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
                 <td>{{ $utilized->status }}</td>
                 <td>
                   <div class="w-27 dropdown pl-1">
                     <a class="more-options-btn" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                     </a>
                     <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                       @if ($utilized->status =="APPROVED")
                       <a href="{{ route('faculty-utilized-edit', $utilized->id) }}" class="dropdown-btn dropdown-item" aria-disabled="true"><i class="fa fa-edit"></i> Edit</a>
                       @else
                       <a href="#utilizedEditModal-{{ $utilized->id }}" class="dropdown-btn dropdown-item" data-toggle="modal" ><i class="fa fa-edit"></i> Edit</a>
                       @endif
                       <hr>
                       <a href="#utilizedDeleteModal-{{ $utilized->id }}" data-toggle="modal" class="dropdown-btn dropdown-item" type="button" data-toggle="modal"><i class="fa fa-trash-alt"></i> Remove</a>
                     </div>
                   </div>
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
                                                <p>Are you sure you want to <span class="colored">DELETE</span> this information?</p> 
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
            {{-- <div class="mt-2">
             <a href="#utilizedAddModal" class="btn btn-primary float-right px-3" data-toggle="modal" type="submit"><i class="fas fa-plus pr-2"></i> ADD</a>
            </div> --}}
            
            </div>
                @else
                 @endif
            
                 
            
              </div>
              <div class="py-1">    
                @if($data->status == "REJECTED" || $paperpublisheds->count() || $paperpresenteds->count() || $bookciteds->count() || $journalciteds->count() || $paperpublisheds->count() || $utilizeds->count() || $patenteds->count()  )
                <button class="btn btn-primary float-lg-right text-uppercase" type="submit"><i class="fas fa-paper-plane"></i> Submit</button> 
                @else
                <button class="btn btn-primary float-lg-right text-uppercase" type="submit"><i class="fas fa-paper-plane"></i> Submit</button> 
                {{-- <a href="#" class="btn btn-primary float-lg-right submit-proposal-btn" role="button"><i class="fas fa-paper-plane"></i> SUBMIT</a> --}}
                    @endif 
                  
              </div> 
            </form>
         
              
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
                    <form class="proposal-form" action="{{ route('faculty-rbp-view', $data->id) }}" method="POST">
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
                  <form class="proposal-form" action="{{ route('faculty-rbp-view', $data->id) }}" method="POST" enctype="multipart/form-data">
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
           
          <!-- ======================= New edited oct 19,2021 ======================= -->
          
        @endif
       
      
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
