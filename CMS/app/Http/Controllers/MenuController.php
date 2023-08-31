<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;
use App\Models\Menu;
use App\Models\Menu_Alan;
use App\Models\MenuItem;
use App\Models\Logo;
use App\Models\Contact;
use App\Models\Page;
use App\Models\IletisimForm;

class MenuController extends Controller
{
    
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $menu=Menu::orderByMenuSırası()->get();

        // Aynı sıraya sahip menülerin kontrolü
        $page=Page::all();
        $menu_alan=Menu_Alan::all();
        $menu_alanlar=Menu_Alan::all();
        $hasDuplicateMenuSirası = false;
        $menuSıraları = $menu->pluck('MenuSırası')->toArray();
        if (count($menuSıraları) !== count(array_unique($menuSıraları))) {
        $hasDuplicateMenuSirası = true;
        }
        return view('menu.index',compact('menu','hasDuplicateMenuSirası','menu_alan','menu_alanlar','page'));
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
            'alan_id' => 'required',
            'MenuAdı' => 'required|string|max:20',
            'MenuSırası' => 'required|numeric|max:11',
            'link_type' => 'required|in:internal,external', 
            'MenuLink' => $linkType === 'internal' ? 'required' : '', 
            'MenuLink_external' => $linkType === 'external' ? 'required' : '', 
            'link_open'=>'required',
        ]);
        try {
            Menu::create([
                'alan_id' => $request->alan_id,
                'MenuAdı' => $request->MenuAdı,
                'MenuSırası' => $request->MenuSırası,
                'MenuLink' => $linkType === 'internal' ? $request->MenuLink : $request->MenuLink_external,
                'link_open'=>$request->link_open,
            ]);
            
            $menu=Menu::orderByMenuSırası()->get();
            return redirect()->back()->with('success', 'Menü ekleme işlemi başarılı.');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Menü ekleme işlemi sırasında bir hata oluştu: ' . $th->getMessage());
        }
    }
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $menu=Menu::where('alan_id',$id)->orderBy('MenuSırası')->get();
        //dd($menu);
        // Aynı sıraya sahip menülerin kontrolü
        $page=Page::all();
        $menu_alan=Menu_Alan::all();
        $menu_alanlar=Menu_Alan::all();
        $hasDuplicateMenuSirası = false;
        $menuSıraları = $menu->pluck('MenuSırası')->toArray();
        if (count($menuSıraları) !== count(array_unique($menuSıraları))) {
        $hasDuplicateMenuSirası = true;
        }
        return view('menu.index',compact('menu','hasDuplicateMenuSirası','menu_alan','menu_alanlar','page'));
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        try {
            $page=Page::all();
            $menu = Menu::findOrFail($id);
            $menu_alanlar=Menu_Alan::all();
            return view('menu.edit', compact('menu','page','menu_alanlar'));
        } catch (\Exception $e) {
            return redirect()->route('menu.show',$menu->alan_id)->with('warning', 'Düzenlenecek kayıt bulunamadı.');
        }
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $linkType = $request->input('link_type');
        $validatedData = $request->validate([
            'alan_id' => 'required',
            'MenuAdı' => 'required|string|max:20',
            'MenuSırası' => 'required|numeric|max:11',
            'link_type' => 'required|in:internal,external', 
            'MenuLink' => $linkType === 'internal' ? 'required' : '', 
            'MenuLink_external' => $linkType === 'external' ? 'required' : '', 
            'link_open'=>'required',
        ]);
        try {
            $menu = Menu::findOrFail($id);
            $menu->alan_id=$request->alan_id;
            $menu->MenuAdı = $request->MenuAdı;
            $menu->MenuSırası = $request->MenuSırası;
            $menu->MenuLink = $linkType === 'internal' ? $request->MenuLink : $request->MenuLink_external;
            $menu->link_open=$request->link_open;
            $menu->save();
            return redirect()->route('menu.show',$menu->alan_id)->with('success', 'Menü bilgileri başarılı bir şekilde güncellendi.');
        } catch (\Throwable $th) {
            //dd($th);
            return redirect()->route('menu.show',$menu->alan_id)->with('warning', 'Menü bilgileri güncelleme işleminde bir hata oluştu lütfen tekrar deneyiz.');
        }
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        DB::beginTransaction();
        try {
            $menu = Menu::findOrFail($id);
            $menualan=$menu->alan_id;
    
            MenuItem::where('MenuId',$menu->MenuId)->delete();
    
            $menu->delete();

            DB::commit();
            return redirect()->route('menu.show',$menualan)->with('success', 'Menu başarıyla silindi.');
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollback();
            return redirect()->route('menu.show',$menualan)->with('error', 'Menu bulunamadı.');
        }
        
        
    }
    public function updateOrder(Request $request) {
        $menuIds = $request->input('menuIds');
        foreach ($menuIds as $index => $menuId) {
          Menu::where('MenuId', $menuId)->update(['MenuSırası' => $index + 1]);
        }
      
        return response()->json(['success' => true]);
    }
}
