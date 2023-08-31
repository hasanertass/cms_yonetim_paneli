<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Logo;
use App\Models\Contact;
use App\Models\Menu_Alan;
use App\Models\IletisimForm;

class LogoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Tüm logoları veritabanından çekiyoruz
        $logos = Logo::all();
        if ($logos==null) {
            $logos=1;
        }
        return view('logo.index', compact('logos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Logo ekleme işlemini gerçekleştiren fonksiyon
        return view('logo.create');
    }

    /**
     * Store a newly created resource in storage.   
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'Name' => 'required|string|max:15',
            'Alt_text' => 'required|string',
            'FilePath' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        
        if ($request->hasFile('FilePath')) {
            $file = $request->file('FilePath');
            $fileName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME); // Dosya adını al
            $extension = $file->getClientOriginalExtension(); // Uzantıyı al
            $fileNameWithExtension = $request->Name . '.' . $extension; // Logo adını ve uzantısını birleştir
            $filePath = $file->storeAs('logos', $fileNameWithExtension, 'public'); // "public" diskini kullanarak logos klasörüne kaydet
        } else {
            return redirect()->back()->with('error', 'Logo dosyası seçilmedi.');
        }
        
        Logo::create([
            'Name' => $request->Name,
            'Alt_text' => $request->Alt_text,
            'FilePath' => '/storage/logos/' . $fileNameWithExtension, // Dikkat! Sadece klasör ve dosya adını veriyoruz, public klasörünü dahil etmiyoruz
        ]);
        
        $logos = Logo::all();
        return response()->json($logo);
        //return redirect()->route('logo.index')->with('success', 'Logo başarıyla Eklendi.');
        
        
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
        try {
            $logo = Logo::findOrFail($id);
            return response()->json($logo); // Logo verisini JSON olarak döndürüyoruz
        } catch (\Exception $e) {
            return response()->json(['error' => 'Logo bilgilerini alırken bir hata oluştu.'], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $request->validate([
            'editLogoName' => 'required|string|max:15',
            'editLogoAltText' => 'required|string',
        ]);
        $logo = Logo::findOrFail($id);
        $logo->Name = $request->editLogoName;
        $logo->Alt_text = $request->editLogoAltText;
    
        $logo->save();
    
        return response()->json($logo);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        
        $logo = Logo::findOrFail($id);

        // Eğer logo bulunursa silme işlemi yapılır, bulunmazsa hata mesajı döndürülür
        if ($logo) {
            $logo->delete();
            return redirect()->route('logo.index')->with('success', 'Logo başarıyla silindi.');
        } else {
            return redirect()->route('logo.index')->with('error', 'Logo bulunamadı.');
        }
    }
    
    public function activate(string $id)
    {
            // Adım 1: Bütün logoların KullanimDurumu özelliğini 0 olarak ayarla
            Logo::where('KullanimDurumu', 1)->update(['KullanimDurumu' => 0]);

            // Adım 2: Seçilen logonun KullanimDurumu özelliğini 1 olarak ayarla
            $logo = Logo::findOrFail($id);
            $logo->KullanimDurumu = 1;
            $logo->save();

            return redirect()->back()->with('success', 'Logo başarıyla etkinleştirildi.');

    }

}
