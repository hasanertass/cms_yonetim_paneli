<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;
use App\Models\Menu_Alan;
use App\Models\Menu;
use App\Models\MenuItem;

class MenuAlanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $menualans=Menu_Alan::all();
        $menus=Menu::all();
        return view('MenuAlan.index',compact('menualans','menus'));
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
        $validatedData = $request->validate([
            'alan_name'=>'required|string|max:20',
        ]);
        try {
            Menu_Alan::create([
                'alan_name' => $request->alan_name,
            ]);
            
            return back()->with('success', 'Yeni Menü Alanı ekleme işlemi başarılı.');
        } catch (\Throwable $th) {
            return back()->with('warning', 'Yeni Menü Alanı ekleme işleminde bir hata oluştu!!!');
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
        try {
            $menualan = Menu_Alan::findOrFail($id);
            return response()->json($menualan); 
        } catch (\Exception $e) {
            return response()->json(['error' => 'Menü bilgilerini alırken bir hata oluştu.'], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $menualan=Menu_Alan::findOrFail($id);
        try {
            $menualan->alan_name=$request->input('menu_name');
            $menualan->save();
            return back()->with('success', 'Menü Alanı adı  güncelleme işlemi başarılı.');
        } catch (\Throwable $th) {
            //throw $th;
            return back()->with('warning', 'Menü Alanı adı  güncelleme işleminde bir hata oluştu.');
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
            $menus=Menu::where('alan_id',$id)->get();
            foreach($menus as $menu){
                MenuItem::where('MenuId',$menu->MenuId)->delete();
            }
            Menu::where('alan_id',$id)->delete();
            $menu_alan=Menu_Alan::findOrFail($id);
            $menu_alan->delete();

            DB::commit();
            return redirect()->route('menualan.index')->with('success','Menü alanı başarılı bir şekilde silinmiştir.');
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollback();
            //dd($th);
            return redirect()->route('menualan.index')->with('warning','Menü alanı silme işleminde bir hata oluştu.');
        }
       
    }
}
