<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Users;
use Illuminate\Support\Facades\Hash;


class LoginController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        //Auth::logout();
        return view('Admin.log_in');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {   
        $email = $request->input('email');
        $password = $request->input('password');
        $remember = $request->has('remember'); // 'remember' adında bir alanın formda olduğunu varsayalım
        
        $user = Users::where('email', $email)->first();
        //dd($remember);
        if ($user && Hash::check($password, $user->password)) {
            if (Auth::attempt(['email' => $email, 'password' => $password], $remember)) {
                return redirect()->route('admin.show', ['admin' => $user->id]);
            } else {
                // Giriş başarısız, şifre kontrolü başarısız oldu
                return back()->withErrors([
                    'email' => 'Girilen bilgiler hatalı.',
                ])->withInput(['email']);
            }
        } else {
            // Giriş başarısız, kullanıcı bulunamadı
            return back()->withErrors([
                'email' => 'Girilen bilgiler hatalı.',
            ])->withInput();
        }
    }
    public function signOut(){
        Auth::logout();
        return redirect()->route('login.index');
    }
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
