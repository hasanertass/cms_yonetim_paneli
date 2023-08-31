<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File; 
use App\Models\Contact;
use App\Models\Logo;
use App\Models\Menu_Alan;
use App\Models\AboutUs;
use App\Models\IletisimForm;

class AboutUsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $abouts=AboutUs::all();
        return view('AboutUs.index',compact('abouts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('AboutUs.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $validatedData = $request->validate([
            'baslik' => 'required|string|max:80',
            'aciklama1' => 'required|string|max:1000',
            'aciklama2' => 'required|string|max:1000',
            'prop1' => 'string|max:30',
            'prop2' => 'string|max:30',
            'prop3' => 'string|max:30',
            'prop4' => 'string|max:30',
            'prop5' => 'string|max:30',
            'prop6' => 'string|max:30',
            'prop7' => 'string|max:30',
            'prop8' => 'string|max:30',
            'görsel' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'görsel2' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        try {
            if ($request->hasFile('görsel')) {
                $file = $request->file('görsel');
                $fileName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME); // Dosya adını al
                $extension = $file->getClientOriginalExtension(); // Uzantıyı al
                $fileNameWithExtension = $request->baslik.' Görsel 1' . '.' . $extension; // Logo adını ve uzantısını birleştir
                $filePath = $file->storeAs('About', $fileNameWithExtension, 'public'); // "public" diskini kullanarak logos klasörüne kaydet
            } else {
                return redirect()->back()->with('warning', 'Görsel dosyası seçilmedi.');
            }
            if ($request->hasFile('görsel2')) {
                $file = $request->file('görsel2');
                $fileName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME); // Dosya adını al
                $extension = $file->getClientOriginalExtension(); // Uzantıyı al
                $fileNameWithExtension2 = $request->baslik.' Görsel 2' . '.' . $extension; // Logo adını ve uzantısını birleştir
                $filePath = $file->storeAs('About', $fileNameWithExtension2, 'public'); // "public" diskini kullanarak logos klasörüne kaydet
                $fileNameWithExtension2='/storage/about/' . $fileNameWithExtension2;
            } else {
                $fileNameWithExtension2='';
            }
            AboutUs::create([
                'baslik' => $request->baslik,
                'aciklama1' => $request->aciklama1,
                'aciklama2' => $request->aciklama2,
                'prop1' => $request->prop1,
                'prop2' => $request->prop2,
                'prop3' => $request->prop3,
                'prop4' => $request->prop4,
                'prop5' => $request->prop5,
                'prop6' => $request->prop6,
                'prop7' => $request->prop7,
                'prop8' => $request->prop8,
                'görsel' => '/storage/about/' . $fileNameWithExtension,
                'görsel2' =>$fileNameWithExtension2, // Dikkat! Sadece klasör ve dosya adını veriyoruz, public klasörünü dahil etmiyoruz
            ]);
            return redirect()->route('about.index')->with('success', 'Hakkımızda Bilgileri Kayıt Edildi.');
        } catch (\Throwable $th) {
            dd($th);
           return view('AboutUs.create')->with('warning', 'Hakkımızda bilgileri kayıt işleminde bir hata oluştu.');
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
        $about=AboutUs::findOrFail($id);
        return view('AboutUs.edit',compact('about'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $about = AboutUs::findOrFail($id);
    
        // Eğer yeni görsel seçildiyse
        if ($request->hasFile('görsel')) {
            $görsel = $request->file('görsel');
            $eskiGörselYolu = storage_path('app/public/About/' . $about->baslik. 'Görsel 1');
    
            // Eski görseli sil
            if (file_exists($eskiGörselYolu)) {
                unlink($eskiGörselYolu);
            }
    
            // Yeni görseli kaydet
            $görselAdi = $about->baslik . 'Görsel 1.' . $görsel->getClientOriginalExtension();
            $görsel->storeAs('public/About', $görselAdi);
    
            // Veritabanındaki görsel adını güncelle
            $about->görsel = '/storage/About/' .$görselAdi;
        }
        if ($request->hasFile('görsel2')) {
            $görsel = $request->file('görsel2');
            $eskiGörselYolu = storage_path('app/public/About/' . $about->baslik .'Görsel 2');
    
            // Eski görseli sil
            if ($about->görsel2&&file_exists($eskiGörselYolu)) {
                unlink($eskiGörselYolu);
            }
    
            // Yeni görseli kaydet
            $görselAdi = $about->baslik . 'Görsel 2.' . $görsel->getClientOriginalExtension();
            $görsel->storeAs('public/About', $görselAdi);
    
            // Veritabanındaki görsel adını güncelle
            $about->görsel2 = '/storage/About/' .$görselAdi;
        }
    
        // Diğer güncelleme işlemlerini gerçekleştirin
        $about->baslik = $request->baslik;
        $about->aciklama1 = $request->aciklama1;
        $about->aciklama2 = $request->aciklama2;
        $about->prop1= $request->prop1;
        $about->prop2= $request->prop2;
        $about->prop3= $request->prop3;
        $about->prop4= $request->prop4;
        $about->prop5= $request->prop5;
        $about->prop6= $request->prop6;
        $about->prop7= $request->prop7;
        $about->prop8= $request->prop8;
        // Diğer alanları da güncelleyin
    
        // Veritabanında güncellemeyi kaydet
        $about->save();
    
        return redirect()->route('about.index')->with('success', 'Haber başarıyla güncellendi.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $about = AboutUs::findOrFail($id);

        if ($about) {
            $about->delete();
            return redirect()->route('about.index')->with('success', 'Hakkımızda bilgileri başarıyla silindi.');
        } else {
            return redirect()->route('about.index')->with('error', 'Hakkımızda bilgileri bulunamadı.');
        }
    }
    public function kullanımdurumu(string $id){
        AboutUs::where('durum',1)->update(['durum' => 0]);
        $about=AboutUs::findOrFail($id);
        if($about){
            $about->durum=1;
            $about->save();
            return redirect()->Route('about.index');
        }
        else{
            return redirect()->Route('about.index')->with('warning','Sistemsel bir hata oluştu lütfen tekrar deneyiniz.');
        }

    }
}
