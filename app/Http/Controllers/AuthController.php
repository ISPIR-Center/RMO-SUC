<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    public function registerPage() {
        return view('auth.register');
    }
    public function registerUser(Request $request) {
        $this->validate($request, [
            'office_name' => 'required|max:255',
            'email' => 'required|max:255|unique:users|email',
            'password' => 'required|confirmed',
            'image' => 'max:2048|mimes:jpg,jpeg,png',
            'campus' => 'required|max:255',
            'contact' => 'max:255',
            'type' => 'required|max:255'
        ]);

        User::create([
            'office_name' => $request->office_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'image' => $request->image,
            'campus' => $request->campus,
            'contact' => $request->contact,
            'type' => $request->type
        ]);

        $latest = User::latest()->first();

        if($request->type == 'College') {
            $latest->update(['college' => $request->office_name]);
        }

        if($request->image) {
            $newImage = time() . $request->office_name . '.' . $request->image->extension();
            $request->image->move(public_path('img/users/'), $newImage);
            $latest->update(['image' => $newImage]);
        }

        return back();
    }
    public function loginPage() {
        return view('auth.login');
    }

    public function login(Request $request) {

        $creds = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required']
        ]);
        
        if(!auth()->attempt($request->only('email','password'))) {
            return back()->with('status','Invalid Credentials');
        }


        // if(!Auth::attempt($creds)) {
        //     return back()->with('status','Invalid Credentials');
        // }
        if(auth()->user()->type == 'Faculty')
        {
           return redirect()->route('faculty-rbp');
        }

        if(auth()->user()->type == 'Dean')
        {   
           return redirect()->route('dean-rbp');
        }
        if(auth()->user()->type == 'Program Chair')
        {           
           return redirect()->route('programchair-rbp');
        }
        if(auth()->user()->type == 'Chancellor')
        {        
           return redirect()->route('chancellor-rbp');
        }

        if(auth()->user()->type == 'RMO')
        {
            return redirect()->route('rmo-rbp');
        }
    }
    public function logout(Request $request) {
        Auth::logout();
        return redirect()->route('login');

    }
    public function facultyview() {
        $user = auth()->user();
        return view('faculty.profile.changepassword', [
            'user' => $user,
            'active' => 'manageaccount'
        ]);
    }

    public function changepw(Request $request) {

        if (Hash::check($request->currentpw, auth()->user()->password)) {
            $this->validate($request, [
                'password' => 'required|confirmed'
            ]);

            auth()->user()->update([
                'password' => Hash::make($request->password)
            ]);

            return back()->with('success', 'Password Changed');
        }

        return back()->with('alert', 'Invalid Credentials');
    }

    public function viewRmo() {
        $user = auth()->user();
        return view('rmo.changepassword', [
            'user' => $user,
            'active' => 'manageaccount'
        ]);
    }

    public function changepwRmo(Request $request) {

        if (Hash::check($request->currentpw, auth()->user()->password)) {
            $this->validate($request, [
                'password' => 'required|confirmed'
            ]);

            auth()->user()->update([
                'password' => Hash::make($request->password)
            ]);

            return back()->with('success', 'Password Changed');
        }

        return back()->with('alert', 'Invalid Credentials');
    }

    public function viewPc() {
        $user = auth()->user();
        return view('programchair.changepassword', [
            'user' => $user,
            'active' => 'pcchangepassword'
        ]);
    }

    public function changepwPc(Request $request) {

        if (Hash::check($request->currentpw, auth()->user()->password)) {
            $this->validate($request, [
                'password' => 'required|confirmed'
            ]);

            auth()->user()->update([
                'password' => Hash::make($request->password)
            ]);

            return back()->with('success', 'Password Changed');
        }

        return back()->with('alert', 'Invalid Credentials');
    }

    public function viewDean() {
        $user = auth()->user();
        return view('dean.changepassword', [
            'user' => $user,
            'active' => 'deanchangepassword'
        ]);
    }

    public function changepwDean(Request $request) {

        if (Hash::check($request->currentpw, auth()->user()->password)) {
            $this->validate($request, [
                'password' => 'required|confirmed'
            ]);

            auth()->user()->update([
                'password' => Hash::make($request->password)
            ]);

            return back()->with('success', 'Password Changed');
        }

        return back()->with('alert', 'Invalid Credentials');
    }

    public function viewChancellor() {
        $user = auth()->user();
        return view('chancellor.changepassword', [
            'user' => $user,
            'active' => 'chancellorchangepassword'
        ]);
    }

    public function changepwChancellor(Request $request) {

        if (Hash::check($request->currentpw, auth()->user()->password)) {
            $this->validate($request, [
                'password' => 'required|confirmed'
            ]);

            auth()->user()->update([
                'password' => Hash::make($request->password)
            ]);

            return back()->with('success', 'Password Changed');
        }

        return back()->with('alert', 'Invalid Credentials');
    }
}
