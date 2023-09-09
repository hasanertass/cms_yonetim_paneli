<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Logo;
use App\Models\SSS;
use App\Models\Sss_Sayfa;
use App\Models\Contact;
use App\Models\Menu_Alan;
use App\Models\Page;
use App\Models\IletisimForm;


class SSSController extends Controller
{
    
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $faq = SSS::orderBy('sira')->get();

        $grouped = $faq->groupBy('sayfa_id');

        $sss = collect();
        foreach ($grouped as $sayfaId => $group) {
            $sortedGroup = $group->sortBy('sira');
            $sss = $sss->concat($sortedGroup);
        }
        $soruSayfalar=Page::all();
        return view('SSS.index',compact('sss','soruSayfalar'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $sayfalar = Page::all();
        $page=Page::all();
        return view('SSS.create',compact('sayfalar','page'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        try {
            $validatedData = $request->validate([
            'sayfa_id' => 'required|string',
            'Soru' => 'required|string',
            'Cevap' => 'required|string',
            'Sira' => 'required|integer',
            ]);
    
            // Formdan gelen verileri alalım
            $data = $request->only(['sayfa_id', 'Soru', 'Cevap', 'Sira']);
    
            // Veritabanına kaydedelim (örnek olarak Eloquent kullanıyoruz)
            SSS::create($data);
    
            return redirect()->route('sss.index')->with('success', 'Soru başarıyla eklendi.');
        } catch (\Throwable $th) {
            //dd(th);
            return redirect()->route('sss.index')->with('warning', 'Soru ekleme işleminde bir hata oluştu!');
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
        $sayfalar = Page::all();
        $sss = SSS::find($id);
        if (!$sss) {
        return redirect()->route('sss.index')->with('error', 'Düzenlenecek kayıt bulunamadı.');
        }
        // Eğer $sss değişkeni geçerliyse, düzenleme formunu göster
        return view('sss.edit', compact('sss','sayfalar'));
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $sss = SSS::find($id);
            $validatedData = $request->validate([
                'sayfa_id' => 'required|string',
                'Soru' => 'required|string',
                'Cevap' => 'required|string',
                'Sira' => 'required|integer',
            ]);
            // Formdan gelen verileri alalım
            $data = $request->only(['sayfa_id', 'Soru', 'Cevap', 'Sira']);
            // Veritabanında güncelleme yapalım
            $sss->update($data);
            return redirect()->route('sss.index')->with('success', 'Soru başarıyla güncellendi.');  
        } catch (\Throwable $th) {
            //throw $th;
            //dd($th);
            return redirect()->route('sss.index')->with('success', 'Güncelleme işleminde bir hata oluştu lütfen tekar deneyin.');  
        }
          
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $sss=SSS::findOrFail($id);
        if ($sss) {
            $sss->delete();
            return redirect()->route('sss.index')->with('success', 'Logo başarıyla silindi.');
        } else {
            return redirect()->route('sss.index')->with('error', 'Logo bulunamadı.');
        }
    }
    public function durum(string $id)
    {
        $sss=SSS::findOrFail($id);

        if ($sss) {
            if ($sss->Durum == 0) {
                $sss->Durum = 1;
            } elseif ($sss->Durum == 1) {
                $sss->Durum = 0;
            }
    
            // Değişikliği kaydedin
            $sss->save();
            return redirect()->route('sss.index');
        }
        return redirect()->route('sss.index');
    }
}
