<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Logo;
use App\Models\IletisimForm;
use App\Models\İletisimFormAlan;
use App\Models\Contact;
use App\Models\Menu_Alan;
use App\Models\Page;


class iletisimFormController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $page=Page::all();
        $iletisimForms=IletisimForm::all();
        return view('iletisimForm.index',compact('iletisimForms','page'));

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
        $validatedData = $request->validate([
            'FormName' => 'required|string|max:50',
            'sayfa_id'=>'required|unique:contactform,sayfa_id',
        ]);
        try {
            // Formdan gelen verileri alalım
            $data = $request->only(['FormName', 'sayfa_id']);
    
            // Veritabanına kaydedelim (örnek olarak Eloquent kullanıyoruz)
            IletisimForm::create($data);
    
            return redirect()->route('iletisimform.index')->with('success', 'Form başarıyla eklendi.');
        } catch (\Throwable $th) {
            return redirect()->route('iletisimform.index')->with('warning', 'Form ekleme işleminde bir hata oluştu.');
        }
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $page=Page::all();
        $iletisimFormAlanlar=İltesimFormAlan::where('FormId',$id)->get();
        return view('iletisimform.show', compact('iletisimFormAlanlar','page'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        $iletisimForm = IletisimForm::findOrFail($id);
        $page=Page::all();
        // editForm.blade.php dosyasını döndürün ve verileri view'a gönderin
        return view('iletisimForm.edit', compact('iletisimForm','page'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        //dd($request);
        $iletisimform=IletisimForm::findOrFail($id);
        $validatedData = $request->validate([
            'FormName' => 'required|string|max:50',
            'sayfa_id'=>'required|unique:contactform,sayfa_id,'.$iletisimform->FormId.',FormId',            
        ]);
        try {
            // Formdan gelen verileri alalım
            $data = $request->only(['FormName', 'sayfa_id']);
            // Veritabanında güncelleme yapalım
            $iletisimform->update($data);
            return redirect()->route('iletisimform.index')->with('success', 'Form bilgileri başarıyla güncellendi.');  
        } catch (\Throwable $th) {
            //throw $th;
            return redirect()->route('iletisimform.index')->with('warning', 'Form bilgilerini güncelleme işleminde bir hata oluştu lütfen tekar deneyin.');  
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $iletisimForms = IletisimForm::findOrFail($id);
        

        if ($iletisimForms) {
            $iletisimFormAlanlar = İletisimFormAlan::where('FormId', $id)->get();

            // Alanları sil
            foreach ($iletisimFormAlanlar as $iletisimFormAlan) {
                $iletisimFormAlan->delete();
            }

            // Formu sil
            $iletisimForms->delete();
            return redirect()->route('iletisimform.index')->with('success', 'Form başarıyla silindi.');
        } else {
            return redirect()->route('iletisimform.index')->with('error', 'Form bulunamadı.');
        }
    }
}
