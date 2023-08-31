<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\logo;
use App\Models\İletisimFormAlan;
use App\Models\Contact;
use App\Models\IletisimForm;
use App\Models\Menu_Alan;


class iletisimFormAlanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //
        
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
        //dd($request);
        $validatedData = $request->validate([
            'AlanName' => 'required|string|max:50',
            'PleaceHolder'=>'required|string|max:50',
            'AlanType' => 'required|',
            'AlanSırası' => 'required|numeric',
        ]);
        $formId=$request->FormId;
        try {
            $count=İletisimFormAlan::where('FormId',$formId)->count();
            if ($count<12) {
                İletisimFormAlan::create([
                    'AlanName' => $request->AlanName,
                    'AlanType' => $request->AlanType,
                    'PleaceHolder'=>$request->PleaceHolder,
                    'AlanSırası' => $request->AlanSırası,
                    'FormId' => $request->FormId,
                ]);
                return redirect()->route('iletisimformalanları.show', ['iletisimformalanları' =>$formId ])->with('succses', 'Alan Kaydedildi.');
            }
            else {
                return redirect()->route('iletisimformalanları.show', ['iletisimformalanları' =>$formId ])->with('warning', 'Maximum 12 tane form  alanı kayıt edebilirsiniz.');
            }
            
            
        } catch (\Throwable $th) {
            return redirect()->route('iletisimformalanları.show', ['iletisimformalanları' => $request->FormId])->with('errors', 'Alan kayıt işleminde bir hata oluştu.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {   
        $iletisimForm=IletisimForm::all();
        $iletisimFormAlanlar = İletisimFormAlan::Where('FormId',$id)->orderBy('AlanSırası')->get();
        //
        $hasDuplicateAlanSirası = false;
        $menuSıraları = $iletisimFormAlanlar->pluck('AlanSırası')->toArray();
        if (count($menuSıraları) !== count(array_unique($menuSıraları))) {
        $hasDuplicateAlanSirası = true;
        }
        
        return view('iletisimFormAlan.index', compact('iletisimFormAlanlar','hasDuplicateAlanSirası','iletisimForm' ));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $iletisimFormAlan = İletisimFormAlan::find($id);
        $formId=$iletisimFormAlan->FormId;
        if (!$iletisimFormAlan) {
            return redirect()->route('iletisimformalanları.show', ['iletisimformalanları' =>$formId ])->with('succses', 'Alan Kaydedildi.');
        }
        // Eğer $alan değişkeni geçerliyse, düzenleme formunu göster
        return view('iletisimFormAlan.edit', compact('iletisimFormAlan'));
    }
    

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $alan = İletisimFormAlan::find($id);
        $formId=$alan->FormId;
        $validatedData = $request->validate([
            'AlanName' => 'required|string|max:15',
            'AlanType' => 'required|',
            'AlanSırası' => 'required|numeric',
        ]);
        try {
            // Formdan gelen verileri alalım
            $data = $request->only(['AlanName', 'AlanType', 'AlanSırası']);
            // Veritabanında güncelleme yapalım
            $alan->update($data);
            return redirect()->route('iletisimformalanları.show', ['iletisimformalanları' =>$formId ])->with('succses', 'Alan başarılı bir şekilde güncellendi.');
        } catch (\Throwable $th) {
            //throw $th;
            return redirect()->route('iletisimformalanları.show', ['iletisimformalanları' =>$formId ])->with('error', 'Güncelleme şleminde bir hata oluştu.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $iletisimFormalan = İletisimFormAlan::findOrFail($id);
        $formId=$iletisimFormalan->FormId;
        if ($iletisimFormalan) {
            $iletisimFormalan->delete();
            return redirect()->route('iletisimformalanları.show', ['iletisimformalanları' => $formId])->with('succses', 'Alan silindi.');
        } else {
            return redirect()->route('iletisimformalanları.show', ['iletisimformalanları' => $formId])->with('error', 'Alan bulunamadı.');
        }
    }
}
