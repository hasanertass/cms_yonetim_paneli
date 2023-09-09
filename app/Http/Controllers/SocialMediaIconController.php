<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SocialMediaIcons;
use App\Models\logo;
use App\Models\Contact;
use App\Models\Menu_Alan;
use App\Models\IletisimForm;


class SocialMediaIconController extends Controller
{
    
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $icons=SocialMediaIcons::all();
        return view('SocialMediaIcon.index',compact('icons'));
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
        $Name = $request->Name;
        $Name = preg_replace('/[^A-Za-z0-9\-]+/', '_', $Name);
        $validatedData = $request->validate([
            'Name' => 'required|string|max:20',
            'Link' => 'required|url',
            'Icon'=>'required'
        ]);
        if ($request->hasFile('Icon')) {
            $file = $request->file('Icon');
            $fileName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME); // Dosya adını al
            $extension = $file->getClientOriginalExtension(); // Uzantıyı al
            $fileNameWithExtension = $Name . '.' . $extension; // Logo adını ve uzantısını birleştir
            $filePath = $file->storeAs('SosyalMedya', $fileNameWithExtension, 'public'); // "public" diskini kullanarak logos klasörüne kaydet
        } else {
            return redirect()->back()->with('warning', 'İcon dosyası seçilmedi.');
        }
        try {
            SocialMediaIcons::create([
            'Name' => $request->Name,
            'Link' => $request->Link,
            'Icon' => '/storage/SosyalMedya/' . $fileNameWithExtension, // Dikkat! Sadece klasör ve dosya adını veriyoruz, public klasörünü dahil etmiyoruz
            ]);
        
            $ıcons = SocialMediaIcons::all();
            return redirect()->route('sosyalmedya.index')->with('success', 'Sosal Medya Bilgileri başarıyla eklendi!');
        } catch (\Throwable $th) {
            dd($th);
            return redirect()->route('sosyalmedya.index')->with('warning', 'Sosal Medya Bilgileri ekleme işleminde bir hata oluştu!');
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
        try {
            $ıcons = SocialMediaIcons::findOrFail($id);
            return response()->json($ıcons); // Logo verisini JSON olarak döndürüyoruz
        } catch (\Exception $e) {
            return response()->json(['error' => 'İcon bilgilerini alırken bir hata oluştu.'], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $validatedData = $request->validate([
            'editIconName' => 'required|string|max:20',
            'editIconLink' => 'required|url',
        ]);
        $ıcon = SocialMediaIcons::findOrFail($id);
        $ıcon->Name = $request->editIconName;
        $ıcon->Link = $request->editIconLink;
        $ıcon->save();
        //return redirect()->route('sosyalmedya.index')->with('success', 'Icon bilgileri başarıyla güncellendi.');
        return redirect()->route('sosyalmedya.index')->with('success', 'Sosal Medya Bilgileri başarıyla eklendi!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $ıcon = SocialMediaIcons::findOrFail($id);

        // Eğer logo bulunursa silme işlemi yapılır, bulunmazsa hata mesajı döndürülür
        if ($ıcon) {
            $ıcon->delete();
            return redirect()->route('sosyalmedya.index')->with('success', 'Icon başarıyla silindi.');
        } else {
            return redirect()->route('sosyalmedya.index')->with('error', 'Icon bulunamadı.');
        }
    }
}
