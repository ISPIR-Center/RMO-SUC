@extends('index')

@section('content')
    <form action="{{ route('register') }}" method="POST" enctype="multipart/form-data">
      @csrf
      @error('office_name')
          {{ $message }}
      @enderror
      <div>
        <label for="office_name">Office Name</label>
        <input type="text" name="office_name" placeholder="Enter Offfice Name" value="{{ old('office_name') }}">
      </div>
      @error('email')
          {{ $message }}
      @enderror
      <div>
        <label for="email">Email</label>
        <input type="email" name="email" placeholder="Enter Email" value="{{ old('email') }}">
      </div>
      @error('password')
      {{ $message }}
      @enderror
      <div>
        <label for="password">Password</label> 
        <input type="password" name="password" placeholder="Enter Password">
      </div>
      @error('password_confirmation')
      {{ $message }}
      @enderror
      <div>
        <label for="password_confirmation">Confirm Password</label>
        <input type="password" name="password_confirmation" placeholder="Confirm Password">
      </div>
      @error('campus')
      {{ $message }}
      @enderror
      <div>
        <label for="campus">Campus</label>
        <input type="text" name="campus" placeholder="Enter University Campus" value="{{ old('campus') }}">
      </div>
      @error('contact')
      {{ $message }}
      @enderror
      <div>
        <label for="contact">Contact No.</label>
        <input type="numeric" name="contact" placeholder="Contact Number" value="{{ old('contact') }}">
      </div>
      @error('type')
      {{ $message }}
      @enderror
      <div>
        <label for="type">User Type</label>
        <input type="text" name="type" placeholder="Enter User Type (eg. College, RMO, DIO, ESO)" value="{{ old('type') }}">
      </div>
      @error('image')
      {{ $message }}
      @enderror
      <div>
        <label for="image">Office Logo</label>
        <input type="file" name="image" accept="image/*">
      </div>

      <button type="submit">Register</button>
    </form>
@stop