@extends('index')

@section('content')

    <body class="ms-fill">
        <nav class="navbar navbar-light fixed-top bg-light p-0 shadow">
            <div class="container-fluid">
                <div class="py-3 m-0">
                    <a href="{{ route('faculty-rbp') }}"><img src="{{ asset('./img/logo/rmo-logo.png') }}"
                            class="navbar-office-logo"></a>
                </div>
                <div class="navbar-nav px-3">
                    <a class="text-center navbar-nav-text" href="#logoutModal" type="button" data-toggle="modal"><img
                            src="{{ asset('./img/logo/logout.svg') }}" class="navbar-logout-icon">
                        <p class="mb-0 mt-1">Logout</p>
                    </a>
                </div>
            </div>
        </nav>
        <div class="d-flex wrapper" id="wrapper">
            <!-- Sidebar-->
            <div class="border-end" id="sidebar-wrapper">
                <button class="navbar-toggler toggler-example sidebar-btn" id="sidebarToggle" type="button"
                    data-toggle="collapse" data-target="#navbarSupportedContent1" aria-controls="navbarSupportedContent1"
                    aria-expanded="false" aria-label="Toggle navigation"><span class="dark-blue-text"><i
                            class="fas fa-angle-left fa-1x"></i></span></button>
                <div class="sidebar-heading px-3 mt-4 text-muted row">
                    <!-- If no picture/logo -->
                    <!-- <div class="member-logo my-auto mr-2">C</div> -->
                    <!-- else if have picture/logo -->
                    <img src="{{ asset('img/users/' . $user->image) }}" height="auto" width="80px"
                        class="my-auto pr-2" />
                    <div class="sidebar-user-container m-auto">
                        <a href="{{ route('faculty-view-profile', $user->id) }}">
                            <p class="sidebar-user-name">{{ $user->fullname }}</p>
                        </a>
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
                    <h1 class="page-heading mt-2">
                        <ion-icon name="grid-outline" size="large"></ion-icon> Pending Researches
                    </h1>
                    <!-- Search and Create Button -->
                    <div class="content-header">
                        <div class="container-fluid">
                            <div class="row mb-2">


                            </div>
                        </div>
                    </div>
                </div>
                <!-- End of Content Header -->
                @if (session('updated'))
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
                @if (session('alert'))
                    <div class="alert alert-danger alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <p class="card-alert-text"><i class="icon fas fa-info-circle"></i> {!! \Session::get('alert') !!}</p>
                    </div>
                @endif
                <!-- Start of content table -->
                <div class="container-fluid py-2">
                    <div class="card table-container">
                        <div class="card-header">
                            <h3 class="table-heading">List of Proposals</h3>
                        </div>
                        <div class="card-body">
                            <table class="table table-hover bg-white">
                                <thead>
                                    <tr class="text-center">
                                        <th scope="col" width="25%">Research Title</th>
                                        <th scope="col" width="10%">Deliverables</th>
                                        <th scope="col" width="10%">Discipline Covered</th>
                                        <th scope="col" width="9%">Station</th>
                                        <th scope="col" width="15%">Responsible Person</th>
                                        <th scope="col" width="10%">Date Completed</th>
                                        {{-- <th scope="col" width="9%">Status/Rejected by</th> --}}
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($proposals->count())
                                        @foreach ($proposals as $proposal)
                                            <tr class="clickable-row unread text-center"
                                                data-href="{{ url('/faculty/rbp/view/pending/' . $proposal->id) }}">

                                                <td>{{ $proposal->title }}</td>
                                                <td>{{ $proposal->deliverables }} </td>
                                                <td>{{ $proposal->discipline_covered }}</td>
                                                <td>{{ $proposal->station }}</td>
                                                <td>{{ $proposal->location_to }} </td>
                                                <td>{{ $proposal->date_completed }}</td>

                                            </tr>
                                        @endforeach
                                    @else
                                        <td colspan="9" class="text-center td-noproposals">No Pending Research</td>
                                    @endif

                                </tbody>
                            </table>
                        </div>
                        <div class="card-footer">
                            <nav aria-label="Pagination" class="float-right">
                                <ul class="pagination">
                                    {!! $proposals->links() !!}
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>




        <!-- Logout Modal -->
        <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="logoutModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <img src="../img/logout.svg" class="navbar-logout-icon"><span class="modal-title"
                            id="logoutModalLabel"> LOGOUT ?</span>
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
