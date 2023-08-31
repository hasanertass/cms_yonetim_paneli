<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contact;
use App\Models\Logo;
use App\Models\Menu_Alan;
use App\Models\IletisimForm;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $contacts=Contact::all();
        return view('Contact.index',compact('contacts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('Contact.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'SirketAdi' => 'required|string|max:50',
            'Adres' => 'required|string|max:250',
            'Adres2' => 'max:250',
            'Mail' => 'required|string|max:50',
            'Mail2' => 'max:50',
            'Telefon' => 'required|numeric|digits:11|unique:contact,Telefon',
            'work' => 'required|string|max:100',
            'Harita' => 'required|string|max:500',
        ]);

        //
        try {
            
            // Formdan gelen verileri alalım
            $data = $request->only(['SirketAdi', 'Adres', 'Adres2', 'Mail','Mail2','Telefon','Telefon2','work','Harita']);
    
            // Veritabanına kaydedelim (örnek olarak Eloquent kullanıyoruz)
            Contact::create($data);
    
            return redirect()->route('contact.index')->with('success', 'İletişim Bilgileri başarıyla eklendi!');
        } catch (\Throwable $th) {
            return redirect()->route('contact.index')->with('warning', 'İletişim Bilgileri ekleme işleminde bir hata oluştu lütfen tekrar deneyiniz!');
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
        $contact = Contact::find($id);
        if (!$contact) 
            return redirect()->route('contact.index')->with('error', 'Düzenlenecek kayıt bulunamadı.');
        else
            return view('contact.edit', compact('contact'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $contact = Contact::find($id);
        $validatedData = $request->validate([
                'SirketAdi' => 'required|string|max:50',
                'Adres' => 'required|string|max:250',
                'Adres2' => 'max:250',
                'Mail' => 'required|string|max:50',
                'Mail2' => 'max:50',
                'Telefon' => 'required|numeric|digits:11|unique:contact,Telefon,'.$contact->Id.'Id',
                'work' => 'required|string|max:100',
                'Harita' => 'required|string|max:500',
            ]);
        try {
            // Formdan gelen verileri alalım
            $data = $request->only(['SirketAdi', 'Adres', 'Adres2', 'Mail','Mail2','Telefon','Telefon2','work','Harita']);
            // Veritabanında güncelleme yapalım
            $contact->update($data);
            return redirect()->route('contact.index')->with('success', 'İletişim bilgileri başarıyla güncellendi.');  
        } catch (\Throwable $th) {
            //throw $th;
            return redirect()->route('contact.index')->with('warning', 'İletişim bilgilerini güncelleme işleminde bir hata oluştu lütfen tekar deneyin.');  
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $contacts=Contact::findOrFail($id);
        try {
            $contacts->delete();
            return redirect()->route('contact.index')->with('success', 'İletişimi bilgileri başarıyla silindi.');

        } catch (\Throwable $th) {
            //throw $th;
            return redirect()->route('contact.index')->with('success', 'İletişimi bilgileri silme işleminde bir hata oluştu lütfen takrar deneyin.');
        }
    }
    public function kullanımdurumu(string $id)
    {
        //
        Contact::where('KullanımDurumu','1')->update(['KullanımDurumu' => 0]);
        $kullanımdurumu=Contact::findOrFail($id);
        if($kullanımdurumu){
            $kullanımdurumu->KullanımDurumu = 1;

            $kullanımdurumu->Save();
            return redirect()->Route('contact.index');
        }
        else{
            return redirect()->Route('contact.index')->with('warning','Sistemsel bir hata oluştu lütfen tekrar deneyiniz.');
        }

    }
}
