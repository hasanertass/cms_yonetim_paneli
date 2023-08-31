<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File; 
use App\Models\Contact;
use App\Models\Logo;
use App\Models\Menu_Alan;
use App\Models\IletisimForm;
use App\Models\Users;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $admin = auth()->User();
        return view('Admin.profile',compact('admin'));
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $admin=Users::findOrFail($id);
        return view('Admin.profile',compact('admin'));
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
        //dd($request);
        $validatedData = $request->validate([
            'name' => 'required|string|max:25',
            'lastname' => 'required|string|max:25',
            'username' => 'required|string|max:25',
            'email' => 'required|string|max:60',
        ]);
        $admin=Users::findorFail($id);
        try {
            $data=$request->only(['name','lastname','username','mail','address','city','county']);
            $admin->update($data);
            return redirect()->route('admin.show', ['admin' => $admin->id])->with('success', 'Kişisel bilgileriniz başarıyla güncellendi.');
        } catch (\Throwable $th) {
            //throw $th;
            //dd($th);
            return redirect()->route('admin.show', ['admin' => $admin->id])->with('warning', 'Kişisel bilgilerinizin güncelleme işleminde bir hata oluştu lütfen tekrar deneyiniz.');

        }
    }
    public function changePassword(Request $request, int $id) {
        $user = Users::findOrFail($id);
    
        // Form verilerini al
        $oldPassword = $request->input('current_password');
        $newPassword = $request->input('new_password');
        $confirmNewPassword = $request->input('new_password_confirmation');
    
        // Eski şifre doğrulaması
        if (!Hash::check($oldPassword, $user->password)) {
            return back()->withErrors(['current_password' => 'Eski şifre hatalı'])->withInput();
        }
    
        // Yeni şifre eşleşme kontrolü
        if ($newPassword !== $confirmNewPassword) {
            return back()->withErrors(['new_password_confirmation' => 'Yeni şifreler eşleşmiyor'])->withInput();
        }
    
        // Yeni şifre oluşturma ve güncelleme
        $user->password = Hash::make($newPassword);
        $user->save();
    
        return redirect()->route('admin.show', ['admin' => $id])->with('current_password', 'Şifre değiştirildi.');
    }
    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
