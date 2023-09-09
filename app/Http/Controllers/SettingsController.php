<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Head_Setting;
use App\Models\Footer_Setting;
use App\Models\Public_Setting;
use App\Models\Menu_Alan;

class SettingsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function head_index(){
        $public_setting=Public_Setting::first();

        $menu_groups=Menu_Alan::all();
        $head_setting=Head_Setting::first();
        
        $menu_groups_footer=Menu_Alan::all();
        $footer_setting=Footer_Setting::first();
        return view('Settings.HeadSetting',compact('menu_groups','head_setting','menu_groups_footer','footer_setting','public_setting'));
    }
    public function footer_update(Request $request, string $id){
        $footer_setting=Footer_Setting::first();
        if ($request->hasFile('footer_logo')) {
            $görsel = $request->file('footer_logo');
            $eskiGörselYolu = storage_path('app/public/Setting/Footer-Logo');
    
            // Eski görseli sil
            if (file_exists($eskiGörselYolu)) {
                unlink($eskiGörselYolu);
            }
    
            // Yeni görseli kaydet
            $görselAdi = 'Footer-Logo' . $görsel->getClientOriginalExtension();
            $görsel->storeAs('public/setting', $görselAdi);
            // Veritabanındaki görsel adını güncelle
            $footer_setting->footer_logo = '/storage/setting/' .$görselAdi;
        }
        $footer_setting->text_color=$request->text_color;
        $footer_setting->icon_color=$request->icon_color;
        $footer_setting->footer_background_color=$request->footer_background_color;
        $footer_setting->menu_group=$request->menu_group;
        $footer_setting->save();
        return redirect()->route('head.index')->with('success', 'Footer içerik ayaları başarıyla güncellendi!');
    }
    public function head_update(Request $request, string $id){
        $head_setting=Head_Setting::first();
        if ($request->hasFile('head_logo')) {
            $görsel = $request->file('head_logo');
            $eskiGörselYolu = storage_path('app/public/Setting/Head-Logo');
    
            // Eski görseli sil
            if (file_exists($eskiGörselYolu)) {
                unlink($eskiGörselYolu);
            }
    
            // Yeni görseli kaydet
            $görselAdi = 'Head-Logo' . $görsel->getClientOriginalExtension();
            $görsel->storeAs('public/setting', $görselAdi);
            // Veritabanındaki görsel adını güncelle
            $head_setting->head_logo = '/storage/setting/' .$görselAdi;
        }
        $head_setting->text_color=$request->text_color;
        $head_setting->icon_color=$request->icon_color;
        $head_setting->head_background_color=$request->head_background_color;
        $head_setting->menu_group=$request->menu_group;
        $head_setting->save();
        return redirect()->route('head.index')->with('success', 'Üst Bilgi ayaları başarıyla güncellendi!');
    }
    public function public_update(Request $request, string $id){
        $public_setting=Public_Setting::first();
        if ($request->hasFile('fav_icon')) {
            $görsel = $request->file('fav_icon');
            $eskiGörselYolu = storage_path('app/public/Setting/fav_icon');
    
            // Eski görseli sil
            if (file_exists($eskiGörselYolu)) {
                unlink($eskiGörselYolu);
            }
    
            // Yeni görseli kaydet
            $görselAdi = 'fav_icon' . $görsel->getClientOriginalExtension();
            $görsel->storeAs('public/setting', $görselAdi);
            // Veritabanındaki görsel adını güncelle
            $public_setting->fav_icon = '/storage/setting/' .$görselAdi;
        }
        $public_setting->section_title_color=$request->section_title_color;
        $public_setting->save();
        return redirect()->route('head.index')->with('success', 'Genel İçerik ayaları başarıyla güncellendi!');
    }
}
