<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Logo;
use App\Models\IletisimForm;
use App\Models\Contact;
use App\Models\Menu_Alan;
use App\Models\iletisim_ui;

class iletisim_uiController extends Controller
{
   
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $iletisimler=iletisim_ui::all();
        return view('İletisimUi.index',compact('iletisimler'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $forms=IletisimForm::all();
        return view('İletisimUi.create',compact('forms'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $validatedData = $request->validate([
                'title' => 'required|string|max:60',
                'description' => 'required|string|max:150',
                'contact_form' => 'required',
            ]);
        try {
            // Formdan gelen verileri alalım
            $data = $request->only(['title', 'description', 'contact_form']);
            // Veritabanında güncelleme yapalım
            iletisim_ui::create($data);
            return redirect()->route('iletisimsection.index')->with('success', 'İletişim bilgileri kayıt edildi.');  
        } catch (\Throwable $th) {
            //throw $th;
            return redirect()->route('iletisimsection.index')->with('warning', 'İletişim bilgileri kayıt işleminde bir hata oluştu lütfen tekar deneyin.');  
        }
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
        $forms=IletisimForm::all();
        $iletisim=iletisim_ui::findOrFail($id);
        return view('İletisimUi.edit',compact('iletisim','forms'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $iletisim = iletisim_ui::findOrFail($id);
        $validatedData = $request->validate([
                'title' => 'required|string|max:60',
                'description' => 'required|string|max:150',
                'contact_form' => 'required',
            ]);
        try {
            // Formdan gelen verileri alalım
            $data = $request->only(['title', 'description', 'contact_form']);
            // Veritabanında güncelleme yapalım
            $iletisim->update($data);
            return redirect()->route('iletisimsection.index')->with('success', 'İletişim bilgileri başarıyla güncellendi.');  
        } catch (\Throwable $th) {
            //throw $th;
            return redirect()->route('iletisimsection.index')->with('warning', 'İletişim bilgilerini güncelleme işleminde bir hata oluştu lütfen tekar deneyin.');  
        }
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $iletisim=iletisim_ui::findOrFail($id);
        try {
            $iletisim->delete();
            return redirect()->route('iletisimsection.index')->with('success', 'İletişimi bilgileri başarıyla silindi.');
        } catch (\Throwable $th) {
            return redirect()->route('iletisimsection.index')->with('success', 'İletişimi bilgileri silme işleminde bir hata oluştu lütfen takrar deneyin.');
        }
    }
}
