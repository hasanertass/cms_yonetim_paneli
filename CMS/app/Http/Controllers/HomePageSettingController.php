<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contact;
use App\Models\Logo;
use App\Models\Menu_Alan;
use App\Models\IletisimForm;
use App\Models\HomePageContent;
use App\Models\Page;
use App\Models\MenüList;

class HomePageSettingController extends Controller
{
    
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $homepages=HomePageContent::all();
        $menu=Menu_Alan::all();
        $menülist=MenüList::first();
        return view('AnasayfaSetting.index',compact('homepages','menu','menülist'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $page=Page::all();
        return view('AnasayfaSetting.create',compact('page'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $validatedData = $request->validate([
            'title' => 'required|string|max:70',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        try {
            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $fileName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME); // Dosya adını al
                $extension = $file->getClientOriginalExtension(); // Uzantıyı al
                $fileNameWithExtension = $request->title.'Görsel'.$extension; // Logo adını ve uzantısını birleştir
                $filePath = $file->storeAs('AnaSayfa', $fileNameWithExtension, 'public'); // "public" diskini kullanarak logos klasörüne kaydet
            } else {    
                return redirect()->back()->with('warning', 'Görsel dosyası seçilmedi.');
            }
            HomePageContent::create([
                'title' => $request->title,
                'description' => $request->description,
                'buton_link' => $request->buton,
                'image' => '/storage/anasayfa/' . $fileNameWithExtension,
            ]);
            return redirect()->route('homepage.index')->with('success', 'Hakkımızda Bilgileri Kayıt Edildi.');
        } catch (\Throwable $th) {
            dd($th);
           return  redirect()->route('homepage.create')->with('warning', 'Hakkımızda bilgileri kayıt işleminde bir hata oluştu.');
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
        $homepage=HomePageContent::findOrFail($id);
        $page=Page::all();
        return view('AnasayfaSetting.edit',compact('homepage','page'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        try {
            $homepage = HomePageContent::findOrFail($id);

            // Eğer yeni görsel seçildiyse
            if ($request->hasFile('image')) {
                $görsel = $request->file('image');
                $eskiGörselYolu = storage_path('app/public/anasayfa/' . $homepage->title);
            
                // Eski görseli sil
                if (file_exists($eskiGörselYolu)) {
                    unlink($eskiGörselYolu);
                }
            
                // Yeni görseli kaydet  
                $görselAdi = $homepage->title . 'Görsel.' . $görsel->getClientOriginalExtension();
                $görsel->storeAs('public/AnaSayfa', $görselAdi);
            
                // Veritabanındaki görsel adını güncelle
                $homepage->image = '/storage/AnaSayfa/' .$görselAdi;
            }
            
            $homepage->title = $request->title;
            $homepage->description = $request->description;
            $homepage->buton_link = $request->buton_link;
            
            $homepage->save();
            
            return redirect()->route('homepage.index')->with('success', 'Görsel bilgileri başarıyla güncellendi.');
            
        } catch (\Throwable $th) {
            //throw $th;
            dd($th);
            return redirect()->route('homepage.index')->with('success', 'Görsel bilgileri güncelleme işleminde bir hata oluştu.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $image=HomePageContent::findOrFail($id);
        try {
            $image->delete();
            return redirect()->route('homepage.index')->with('success', 'Görsel bilgileri silme işlemi başarılı');
        } catch (\Throwable $th) {
            return redirect()->route('homepage.index')->with('warning', 'Görsel bilgileri silme işleminde bir hata oluştu.');
        }
    }
    public function status(string $id)
    {
        //
        $image=HomePageContent::findOrFail($id);
        try {
            if($image->status==0)
                $image->status=1;
            else
                $image->status=0;

            $image->save();
            return redirect()->route('homepage.index');
        } catch (\Throwable $th) {
            //throw $th;
            return redirect()->route('homepage.index')->with('warning', 'Görsel durum bilgisi değiştirmede bir hata oluştu.');
        }
    }
    public function otherpage(string $id)
    {
        try {
            HomePageContent::where('otherpageimage', 1)->update(['otherpageimage' => 0]);
            $image=HomePageContent::findOrFail($id);
            $image->otherpageimage=1;
            $image->save();
            return redirect()->route('homepage.index');
        } catch (\Throwable $th) {
            //throw $th;
            return redirect()->route('homepage.index')->with('warning', 'Görsel durum bilgisi değiştirmede bir hata oluştu.');
        }        
    }
    public function menü(Request $request, string $id)
    {
        //
        
        $menülist=MenüList::findOrFail($id);
        try {
            $menülist->anasayfa_menü=$request->anaSayfaMenuGrubu;
            $menülist->footer_menü=$request->footerMenuGrubu;
            $menülist->save();
            return redirect()->route('homepage.index')->with('success', 'Menü bilgileri başarıyla güncellendi.');
        } catch (\Throwable $th) {
            return redirect()->route('homepage.index')->with('warning', 'menü bilgileri güncelleme işleminde bir hata oluştu.');
        }
    }
}
