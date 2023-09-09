<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\logo;
use App\Models\MenuItem;
use App\Models\Contact;
use App\Models\Menu;
use App\Models\Page;
use App\Models\Menu_Alan;
use App\Models\IletisimForm;

class AltMenuController extends Controller
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
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        //dd($request);
        $linkType = $request->input('link_type');
        $validatedData = $request->validate([
            'ItemAdı' => 'required|string|max:15',
            'ItemSırası' => 'required|numeric',
            'link_type' => 'required|in:internal,external', 
            'MenuLink' => $linkType === 'internal' ? 'required' : '', 
            'MenuLink_external' => $linkType === 'external' ? 'required' : '', 
            'link_open'=>'required',
        ]);
        $menuId=$request->MenuId;
        try {
            MenuItem::create([
                'ItemAdı' => $request->ItemAdı,
                'ItemSırası' => $request->ItemSırası,
                'MenuId' => $request->MenuId,
                'ItemLink' => $linkType === 'internal' ? $request->MenuLink : $request->MenuLink_external,
                'link_open'=>$request->link_open,
            ]);
            
            return redirect()->route('altmenu.show', ['altmenu' =>$menuId ])->with('succsess', 'Alt menü başarılı bir şekilde kayıt edildi.');
        } catch (\Throwable $th) {
            dd($th);
            return redirect()->route('altmenu.show', ['altmenu' =>$menuId ])->with('warninig', 'Alt menü kayıt işleminde bir hata oluştu.');
        }
        
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $page=Page::all();
        $altMenu = MenuItem::Where('MenuId',$id)->orderBy('ItemSırası')->get();
        $ustMenu=Menu::Where('MenuId',$id)->first();
        $üstMenüList=Menu::where('alan_id',$ustMenu->alan_id)->get();
        $hasDuplicateAlanSirası = false;
        $menuSıraları = $altMenu->pluck('ItemSırası')->toArray();
        if (count($menuSıraları) !== count(array_unique($menuSıraları))) {
        $hasDuplicateAlanSirası = true;
        }
        
        return view('AltMenu.index', compact('altMenu','hasDuplicateAlanSirası','ustMenu','üstMenüList','page' ));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        $page=Page::all();
        $altmenu = MenuItem::find($id);
        $menuId=$altmenu->MenuId;
        if (!$altmenu) {
            return redirect()->route('altmenu.show', ['altmenu' =>$menuId ])->with('warning', 'Alt Menü Bilgileri Alınamadı.');
        }
        $ustMenu=Menu::Where('MenuId',$menuId)->first();
        $üstMenüList=Menu::where('alan_id',$ustMenu->alan_id)->get();
        // Eğer $alan değişkeni geçerliyse, düzenleme formunu göster
        return view('AltMenu.edit', compact('altmenu','page','üstMenüList'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        
        $altmenu = MenuItem::find($id);
        $menuId=$altmenu->MenuId;
        $linkType = $request->input('link_type');
        $validatedData = $request->validate([
            'MenuId'=>'required',
            'ItemAdı' => 'required|string|max:15',
            'ItemSırası' => 'required|numeric',
            'link_type' => 'required|in:internal,external', 
            'MenuLink' => $linkType === 'internal' ? 'required' : '', 
            'MenuLink_external' => $linkType === 'external' ? 'required' : '', 
            'link_open'=>'required',
        ]);
        try {
            $data = $request->only(['MenuId','ItemAdı', 'ItemLink', 'ItemSırası']);
            $data['ItemLink'] = $linkType === 'internal' ? $request->MenuLink : $request->MenuLink_external;

            $altmenu->update($data);
            return redirect()->route('altmenu.show', ['altmenu' =>$menuId ])->with('succsess', 'Alt menü başarılı bir şekilde kayıt edildi.');
        } catch (\Throwable $th) {
            //throw $th;
            return redirect()->route('altmenu.show', ['altmenu' =>$menuId ])->with('warninig', 'Alt menü kayıt işleminde bir hata oluştu.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $menu = MenuItem::findOrFail($id);
        $menuId=$menu->MenuId;
        if ($menu) {
            $menu->delete();
            return redirect()->route('altmenu.show', ['altmenu' =>$menuId ])->with('succses', 'Alt menü başarılı bir şekilde silindi.');
        } else {
            return redirect()->route('altmenu.show', ['altmenu' =>$menuId ])->with('warninig', 'Alt menü silme işleminde bir hata oluştu.');
        }
    }
    public function updateOrder(Request $request) {
        $menuIds = $request->input('menuIds');
        foreach ($menuIds as $index => $menuId) {
          MenuItem::where('ItemId', $menuId)->update(['ItemSırası' => $index + 1]);
        }
      
        return response()->json(['success' => true]);
    }
}
