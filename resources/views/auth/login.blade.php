@extends('index')

@section('content')
    <div class="login-container">
        <div class="container text-center pt-4">
        <h2 class="login-subheader">BULACAN STATE UNIVERSITY</h2>
        <h1 class="login-office-header">RESEARCH MANAGEMENT OFFICE</h1>
        <div class="row">
            <div class="col-sm-9 col-md-8 col-lg-5 pt-4 mx-auto">
                <div class="card card-login my-5">
                    <div class="card-container">
                        <img src="{{ asset('img/logo/bulsu-logo.png') }}" alt="Bulsu Logo" class="card-img"/>

                        <h5 class="card-title text-center">LOGIN</h5>
                        <p class="card-subtitle text-center">Enter your email address and password below to login to RMO Management System.</p>
                        <form class="form-login" action="{{ route('login') }}" method="post">
                            @csrf
                            @if (session('status'))
                                <div class="alert alert-danger alert-dismissible">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                    <p class="card-alert-text"><i class="icon fas fa-info-circle"></i> Invalid Credentials! Please enter correct Email Address and Password.</p>
                                </div>
                            @endif
                            <div class="form-group text-left">
                                <label for="email" class="form-label-txt">Email Address</label>
                                <input type="email" class="form-control" id="InputEmail1" name="email" placeholder="Enter your email address" value="{{ old('email') }}">
                                </div>
                                <div class="form-group text-left pt-1">
                                <label for="password" class="form-label-txt">Password</label>
                                <input type="password" id="inputPassword" class="form-control" name="password" placeholder="Enter your password" value="">
                            </div>
                            <button class="btn btn-lg btn-primary btn-block text-uppercase my-4" type="submit">Login</button>      
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <p class="card-subtitle text-center"><b>Note:</b> This is the login page for Research Management Office (RMO) Management System, only employees of Bulacan State University and Research Management Office (RMO) can access this system. If you are outside personnel of Bulacan State University, kindly close this window immediately.</p>
        </div>
    
    </div>
@endsection

