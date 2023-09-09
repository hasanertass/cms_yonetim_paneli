<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Logo;
use App\Models\Marka;
use App\Models\Contact;
use App\Models\Menu_Alan;
use App\Models\IletisimForm;


class MarkaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $markalar=Marka::all();
        return view('Marka.index',compact('markalar'));
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
        
        $MarkaName = $request->MarkaName;
        $MarkaName = preg_replace('/[^A-Za-z0-9\-]+/', '_', $MarkaName);
        $validatedData = $request->validate([
            'MarkaName' => 'required|string|max:100',
            'MarkaLogo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $fileNameWithExtension = '';
        if ($request->hasFile('MarkaLogo')) {
            $file = $request->file('MarkaLogo');
            $fileName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME); // Dosya adını al
            $extension = $file->getClientOriginalExtension(); // Uzantıyı al
            $fileNameWithExtension = $MarkaName . '.' . $extension; // Logo adını ve uzantısını birleştir
            $filePath = $file->storeAs('Marka', $fileNameWithExtension, 'public'); // "public" diskini kullanarak logos klasörüne kaydet
        } else {
            return redirect()->back()->with('error', 'Marka logo dosyası seçilmedi.');
        }
        
        Marka::create([
            'MarkaName' => $request->MarkaName,
            'MarkaLogo' => '/storage/Marka/' . $fileNameWithExtension, // Dikkat! Sadece klasör ve dosya adını veriyoruz, public klasörünü dahil etmiyoruz
        ]);
        
        $markalar = Marka::all();
        return response()->json($markalar);
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
        $markalar = Marka::findOrFail($id);

        // Eğer logo bulunursa silme işlemi yapılır, bulunmazsa hata mesajı döndürülür
        if ($markalar) {
            $markalar->delete();
            return redirect()->route('marka.index')->with('success', 'Logo başarıyla silindi.');
        } else {
            return redirect()->route('marka.index')->with('error', 'Logo bulunamadı.');
        }
    }
    
    public function status(int $id){
        $marka=Marka::findOrFail($id);
        if ($marka->status==0) {
            $marka->status=1;
        }else {
            $marka->status=0;
        }
        $marka->save();
        return redirect()->route('marka.index');
    }
    public function home_page_status(int $id){
        $marka=marka::findOrFail($id);
        if ($marka->home_page_status==0) {
            $marka->home_page_status=1;
        }else {
            $marka->home_page_status=0;
        }
        $marka->save();
        return redirect()->route('marka.index');
    }
}
