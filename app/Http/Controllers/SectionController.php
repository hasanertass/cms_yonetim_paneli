<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Logo;
use App\Models\Section;
use App\Models\Contact;
use App\Models\Page;
use App\Models\Menu_Alan;
use App\Models\IletisimForm;
use App\Models\Modul;
use App\Models\Modul_Setting;
use App\Models\Section_Setting;

class SectionController extends Controller
{
    
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $page=Page::all();
        $moduls = Modul::orderBy('name')->get();
        return view('Section.create',compact('page','moduls'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function getModuleContent($moduleId) {
        $module = Modul::find($moduleId);
        if ($module) {
            return response()->json(['content' => $module->content]);
        }
        else {
            return response()->json(['error' => 'Module not found.'], 404);
        }
    }
    public function store(Request $request)
    {
        //
        //dd($request);
        $validatedData = $request->validate([
            'sayfa_id'=>'required',
            'name'=>'required|string|max:40',
            'row'=>'required|numeric',
            'content'=>'required',
        ]);
        if ($request->has('use_placeholder')) {
            $pleaceholder=Modul::where('modul_id',$request->placeholder)->first();
            $content=$pleaceholder->pleace_holder;
        }
        else {
            $content=$request->content;
        }
        $yayin=1;
        try {
            Section::create([
                'sayfa_id' => $request->sayfa_id,
                'content' => $content,
                'section_name' => $request->name,
                'section_row' => $request->row,
                'section_status'=>$yayin,
                'data_piece'=>$request->data_piece,
            ]);
            return redirect()->route('section.show', ['section' => $request->sayfa_id])->with('success', 'Bölüm oluşturma işlemi başarılı.');
        } catch (\Throwable $th) {
            dd($th);
            return redirect()->route('section.show')->with('warning', 'Bölüm oluşturma işleminde bir hata oluştu.');
        }
    }
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        
        $sections=Section::where('sayfa_id',$id)->orderBy('section_row')->get();
        $pageName=Page::where('sayfa_id',$id)->first();
        return view('Section.index',compact('sections','pageName'));

    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        $section=Section::find($id);
        $pageName=Page::all();
        $moduls = Modul::orderBy('name')->get();
        $page=$section->sayfa_id;
        if ($section) {
            return view('Section.edit',compact('section','pageName','moduls'));
        }
        else {
            return redirect()->route('section.show',['section' => $page])->with('warning', 'Bölüm bilgileri alınırken bir hata oluştu.');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        //dd($request);
        $section=Section::findOrFail($id);
        $page=$section->sayfa_id;
        $validatedData = $request->validate([
            'sayfa_id'=>'required',
            'name'=>'required|string|max:20',
            'row'=>'required|numeric',
            'content'=>'required'
        ]);
        $yayin=1;
        if ($request->has('use_placeholder')) {
            $pleaceholder=Modul::where('modul_id',$request->placeholder)->first();
            $content=$pleaceholder->pleace_holder;
        }
        else {
            $content=$request->content;
        }
        try {
            $section->sayfa_id=$request->sayfa_id;
            $section->section_name=$request->name;
            $section->section_row=$request->row;
            $section->content=$content;
            $section->data_piece=$request->data_piece;
            $section->save();

            return redirect()->route('section.show',['section' => $page])->with('success', 'Bölüm bilgileri başarılı bir şekilde güncellendi.');
        } catch (\Throwable $th) {
            dd($th);
            return redirect()->route('section.show',['section' => $page])->with('warning', 'Bölüm bilgileri güncelleme işleminde bir hata oluştu.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $section=Section::find($id);
        $page=$section->sayfa_id;
        try {
            Section_Setting::where('section_id',$id)->delete();
            $section->delete();
            return redirect()->route('section.show',['section' => $page])->with('success', 'Bölüm silme işlemi başarılı.');
        } catch (\Throwable $th) {
            //throw $th;
            //dd($th);
            return redirect()->route('section.show',['section' => $page])->with('warning', 'Bölüm silme işleminde bir hata oluştu.');
        }
    }
    public function status(string $id)
    {
        //
        $section=Section::find($id);
        $page=$section->sayfa_id;
        $kullanımdurumu=$section->section_status;
        try {
            if($kullanımdurumu==0){
                $section->section_status = 1;
            }else {
                $section->section_status=0;
            }
            $section->Save();
            return redirect()->route('section.show',['section' => $page]);
        } catch (\Throwable $th) {
            //throw $th;
            return redirect()->route('section.show',['section' => $page])->with('warning','Sistemsel bir hata oluştu lütfen tekrar deneyiniz.');
        }
    }
    public function updateOrder(Request $request) {
        $menuIds = $request->input('menuIds');
        foreach ($menuIds as $index => $menuId) {
          Section::where('section_id', $menuId)->update(['section_row' => $index + 1]);
        }
      
        return response()->json(['success' => true]);
    }
    public function getSectionContent($section_id) {
        $section = Section::find($section_id);
        $content = $section->content;
        
        preg_match_all("/\{\[(.*?)\]\}/", $content, $matches);
        $placeholders = $matches[0]; // {[...]} içindeki değerleri al

        $moduleId = 0;
        foreach ($placeholders as $placeholder) {
            $matchingModule = Modul::where('pleace_holder', $placeholder)->first();
            if ($matchingModule) {
                $moduleId = $matchingModule->modul_id;
                break; // İlk eşleşmeyi bulduktan sonra döngüden çık
            }
        }

        $settings=Section_Setting::where('section_id',$section_id)->get();

        $modulSettings = Modul_Setting::where('modul_id', $moduleId)->get();
        $modul=Modul::findOrfail($moduleId);
        return view('Section.setting', compact('modulSettings', 'section','modul','settings'));
    }
    public function getSettingUpdate(Request $request, string $section_id) {
        Section_Setting::where('section_id',$section_id)->delete();
        $fieldNames = $request->except(['_token', '_method']);
        foreach ($fieldNames as $fieldName => $value) {
            // Content alanını hariç tut ve HTML içeriği temizle
            if ($fieldName !== 'content') {
                $cleanedValue = strip_tags($value); // HTML etiketlerini temizle
                // Section_Setting tablosuna kayıt ekleme işlemini burada yapabilirsiniz
                $sectionSetting = new Section_Setting();
                $sectionSetting->section_id = $section_id;
                $sectionSetting->setting_name = $fieldName;
                $sectionSetting->setting_value = $cleanedValue;
                $sectionSetting->save();
            }
        }
        $page=Section::findOrFail($section_id);
        return redirect()->route('section.show',['section' => $page->sayfa_id]);

    }
}
