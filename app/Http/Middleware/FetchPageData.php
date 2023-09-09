<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

use App\Models\Logo;
use App\Models\Page;
use App\Models\Contact;
use App\Models\Menu_Alan;
use App\Models\Menu;
use App\Models\IletisimForm;
use App\Models\Head_Setting;
use App\Models\Footer_Setting;
use App\Models\SocialMediaIcons;
use App\Models\Public_Setting;

class FetchPageData
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $gecerliLogo = Logo::where('KullanimDurumu', 1)->first();
        view()->share('gecerliLogo', $gecerliLogo);

        $fav_icon = Public_Setting::first();
        view()->share('fav_icon', $fav_icon);

        $gecerliBilgi = Contact::where('KullanımDurumu', 1)->first();
        view()->share('gecerliBilgi', $gecerliBilgi);

        $menuAlan = Menu_Alan::all();
        view()->share('menuAlan', $menuAlan);

        $contactForm = IletisimForm::all();
        view()->share('contactForm', $contactForm);

        $footer_setting=Footer_Setting::first();
        view()->share('footer_setting', $footer_setting);

        $menu_alan=Menu_Alan::findOrFail($footer_setting->menu_group);
        $footer_menu=Menu::where('alan_id',$menu_alan->alan_id)->orderBy('MenuSırası')->get();
        view()->share('footer_menu', $footer_menu);

        $head_setting=Head_Setting::first();
        view()->share('head_setting', $head_setting);

        $menu_alan=Menu_Alan::findOrFail($head_setting->menu_group);
        $head_menu=Menu::where('alan_id',$menu_alan->alan_id)->orderBy('MenuSırası')->get();
        view()->share('head_menu', $head_menu);

        $anaSayfa=Page::where('AnaSayfa',1)->first();
        view()->share('anaSayfa', $anaSayfa);

        $ıcons=SocialMediaIcons::all();
        view()->share('ıcons', $ıcons);
        return $next($request);
    }
}
