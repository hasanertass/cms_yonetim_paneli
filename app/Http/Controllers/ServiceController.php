<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\logo;
use App\Models\MenuItem;
use App\Models\Contact;
use App\Models\Menu;
use App\Models\Menu_Alan;
use App\Models\Service;
use App\Models\icon;
use App\Models\IletisimForm;


class ServiceController extends Controller
{
    
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $services=Service::all();
        return view('Service.index',compact('services'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $icons=icon::all();
        return view('Service.create',compact('icons'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $title = $request->title;
        $title = preg_replace('/[^A-Za-z0-9\-]+/', '_', $title);
        //dd($request);
        $validatedData = $request->validate([
            'title' => 'required|string|max:75',
            'short_description' => 'required|string|max:250',
            'icon'=>'required',
            'content'=>'required',
            'small_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'meta_title'=>'required|string|max:250',
            'meta_description'=>'required|string|max:500',
            'meta_keywords'=>'required|string|max:250'
        ]);
        if ($request->hasFile('small_image')) {
            $file = $request->file('small_image');
            $fileName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME); // Dosya adını al
            $extension = $file->getClientOriginalExtension(); // Uzantıyı al
            $fileNameWithExtension = $title . '-Görsel-1.' . $extension; //  adını ve uzantısını birleştir
            $filePath = $file->storeAs('Services', $fileNameWithExtension, 'public'); // "public" diskini kullanarak  klasöre kaydet
        } else {
            return redirect()->back()->with('warning', 'Görsel dosyası seçilmedi.');
        }
        if ($request->hasFile('large_image')) {
            $file = $request->file('large_image');
            $fileName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME); // Dosya adını al
            $extension = $file->getClientOriginalExtension(); // Uzantıyı al
            $fileNameWithExtension2 = $title . '-Görsel-2.' . $extension; //  adını ve uzantısını birleştir
            $filePath = $file->storeAs('Services', $fileNameWithExtension2, 'public'); // "public" diskini kullanarak  klasöre  kaydet
            $fileNameWithExtension2='/storage/services/'. $fileNameWithExtension2;
        } else {
            $fileNameWithExtension2 = ''; 
        }
        try {
            Service::create([
                'title' => $request->title,
                'short_description' => $request->short_description,
                'long_description'=> $request->content,
                'small_image' => '/storage/services/' . $fileNameWithExtension, // Dikkat! Sadece klasör ve dosya adını veriyoruz, public klasörünü dahil etmiyoruz
                'large_image'=>$fileNameWithExtension2,
                'icon' => $request->icon,
                'meta_title'=>$request->meta_title,
                'meta_description'=>$request->meta_description,
                'meta_keywords'=>$request->meta_keywords,
            ]);
            return redirect()->route('service.index')->with('success', 'Hizmet Bilgileri başarıyla eklendi!');
        } catch (\Throwable $th) {
            dd($th);
            return redirect()->route('service.index')->with('warning', 'Hizmet Bilgileri ekleme işleminde bir hata oluştu lütfen tekrar deneyiniz!');
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
        $icons=icon::all();
        $service=Service::findOrFail($id);
        $icon=icon::where('icon',$service->icon)->first();
        return view('Service.edit',compact('service','icon','icons'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $title = $request->title;
        $title = preg_replace('/[^A-Za-z0-9\-]+/', '_', $title);
        //
        $iconid=icon::where('icon',$request->icon)->first();
        $service=Service::findOrFail($id);
        //dd($request);
        $validatedData = $request->validate([
            'title' => 'required|string|max:75',
            'short_description' => 'required|string|max:250',
            'icon'=>'required',
            'content'=>'required',
        ]);
        try {
            if ($request->hasFile('small_image')) {
                $görsel = $request->file('small_image');
                $eskiGörselYolu = storage_path('app/public/service/' . $title.'-Görsel-1');
        
                // Eski görseli sil
                if (file_exists($eskiGörselYolu)) {
                    unlink($eskiGörselYolu);
                }
        
                // Yeni görseli kaydet
                $görselAdi = $title . '-Görsel-1.' . $görsel->getClientOriginalExtension();
                $görsel->storeAs('public/service', $görselAdi);
                // Veritabanındaki görsel adını güncelle
                $service->small_image = '/storage/service/' .$görselAdi;
            }
            if ($request->hasFile('large_image')) {
                $görsel = $request->file('large_image');
                $eskiGörselYolu = storage_path('app/public/service/' . $title.'-Görsel-2');
        
                // Eski görseli sil
                if (file_exists($eskiGörselYolu)) {
                    unlink($eskiGörselYolu);
                }
        
                // Yeni görseli kaydet
                $görselAdi = $title . '-Görsel-2.' . $görsel->getClientOriginalExtension();
                $görsel->storeAs('public/service', $görselAdi);
        
                // Veritabanındaki görsel adını güncelle
                $service->large_image = '/storage/service/' .$görselAdi;
            }
            $service->title=$request->title;
            $service->short_description=$request->short_description;
            $service->icon=$request->icon;
            $service->long_description=$request->content;
            $service->meta_title=$request->meta_title;
            $service->meta_description=$request->meta_description;
            $service->meta_keywords=$request->meta_keywords;
            $service->save();
            return redirect()->route('service.index')->with('success', 'Hizmet Bilgileri başarıyla güncellendi!');
        } catch (\Throwable $th) {
            dd($th);
            return redirect()->route('service.index')->with('warning', 'Hizmet Bilgileri güncelleme işleminde bir hata oluştu lütfen tekrar deneyiniz!');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $service=Service::where('id',$id);
        try {
            $service->delete();
            return redirect()->route('service.index')->with('success', 'Hizmet bilgileri başarıyla silindi.');
        } catch (\Throwable $th) {
            //throw $th;
            return redirect()->route('service.index')->with('warning', 'Hizmet bilgileri silme işleminde bir hata oluştu lütfen takrar deneyin.');
        }
    }
    public function status(int $id){
        $service=Service::findOrFail($id);
        if ($service->status==0) {
            $service->status=1;
        }else {
            $service->status=0;
        }
        $service->save();
        return redirect()->route('service.index');
    }
    public function home_page_status(int $id){
        $service=Service::findOrFail($id);
        if ($service->home_page_status==0) {
            $service->home_page_status=1;
        }else {
            $service->home_page_status=0;
        }
        $service->save();
        return redirect()->route('service.index');
    }
}
