<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

use App\Models\Logo;
use App\Models\Contact;
use App\Models\Menu_Alan;
use App\Models\IletisimForm;

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

        $gecerliBilgi = Contact::where('KullanımDurumu', 1)->first();
        view()->share('gecerliBilgi', $gecerliBilgi);

        $menuAlan = Menu_Alan::all();
        view()->share('menuAlan', $menuAlan);

        $contactForm = IletisimForm::all();
        view()->share('contactForm', $contactForm);

        return $next($request);
    }
}
