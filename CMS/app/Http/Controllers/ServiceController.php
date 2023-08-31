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
        $iconid=icon::where('icon',$request->icon)->first();
        //dd($request);
        $validatedData = $request->validate([
            'title' => 'required|string|max:25',
            'description' => 'required|string|max:250',
            'icon'=>'required'
        ]);
        try {
            
            Service::create([
                'title' => $request->title,
                'description' => $request->description,
                'icon' => $iconid->id,
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
        return view('Service.edit',compact('service','icons'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $iconid=icon::where('icon',$request->icon)->first();
        $service=Service::findOrFail($id);
        //dd($request);
        $validatedData = $request->validate([
            'title' => 'required|string|max:25',
            'description' => 'required|string|max:250',
            'icon'=>'required'
        ]);
        try {
            $service->title=$request->title;
            $service->description=$request->description;
            $service->icon=$iconid->id;
            $service->save();
            return redirect()->route('service.index')->with('success', 'Hizmet Bilgileri başarıyla güncellendi!');
        } catch (\Throwable $th) {
            //dd($th);
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
}
