<?php

namespace App\Http\Controllers\UiController;
use App\Helpers\PlaceholderHelper;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Contact;
use App\Models\Logo;
use App\Models\Menu;
use App\Models\MenuItem;
use App\Models\Menu_Alan;
use App\Models\SocialMediaIcons;
use App\Models\Page;
use App\Models\Section;
use App\Models\Marka;
use App\Models\SSS;
use App\Models\News;
use App\Models\AboutUs;
use App\Models\Service;
use App\Models\E_Bülten;
use App\Models\iletisim_ui;
use App\Models\İletisimFormAlan;
use App\Models\IletisimForm;
use App\Models\MenüList;
use App\Models\HomePageContent;
use App\Models\Contents;
use App\Models\Blog;


class UiLayerController extends Controller
{
    public function __construct(){
        $gecerliLogo = $this->getGecerliLogo();
        view()->share('gecerliLogo', $gecerliLogo);

        $gecerliBilgi = $this->getGecerliBilgi();
        view()->share('gecerliBilgi', $gecerliBilgi);

        $anasayfaMenu=$this->getAnasayfaMenu();
        view()->share('anasayfaMenu', $anasayfaMenu);

        $footerMenu=$this->getfooterMenu();
        view()->share('footerMenu', $footerMenu);

        $ıcons=$this->getSosyalMedyaIcon();
        view()->share('ıcons', $ıcons);

        $anaSayfa=$this->getAnaSayfa();
        view()->share('anaSayfa', $anaSayfa);
    }
    // Geçerli logo bilgisini blade şablonuna göndermek için metot
    private function getGecerliLogo(){
        return Logo::where('KullanimDurumu', 1)->first();
    }
    private function getGecerliBilgi(){
        return Contact::where('KullanımDurumu', 1)->first();
    }
    private function getAnasayfaMenu(){
        $anasayfa=MenüList::all()->first();
        $alanname=Menu_Alan::where('alan_id',$anasayfa->anasayfa_menü)->first();
        //dd($alanname);
        return Menu::where('alan_id', $alanname->alan_id)->orderBy('MenuSırası')->get();
    }
    private function getfooterMenu(){
        $anasayfa=MenüList::all()->first();
        $alanname=Menu_Alan::where('alan_id',$anasayfa->footer_menü)->first();
        //dd($alanname);
        return Menu::where('alan_id', $alanname->alan_id)->get();
    }
    private function getAltMenu(){
        $alanname=Menu_Alan::all()->first();
        //dd($alanname);
        return Menu::where('alan_id', $alanname->alan_id)->get();
    }
    private function getSosyalMedyaIcon(){
        return SocialMediaIcons::all();
    }
    private function getAnaSayfa(){
        return Page::where('AnaSayfa',1)->first();
    }
    /**
     * Display a listing of the resource.
     *****/
    /*
    private function belirtecleriDegistir($pageContent,$section_id,$vericontact,$markalar,$SSS,$news,$about,$services,$iletisim,$formEleman,$homePage,$görsel,$page) {

        $aboutContent = PlaceholderHelper::generateAboutContent($about);
        $newsSlider = PlaceholderHelper::generateNewsSlider($news,$section_id);
        $newsContent = PlaceholderHelper::generateNewsContent($news,$section_id);
        $markaContent = PlaceholderHelper::generateMarkaContent($markalar,$section_id);
        $faqContent = PlaceholderHelper::generateFaqContent($SSS);
        $serviceContent = PlaceholderHelper::generateServiceContent($services,$section_id);
        $contactForm = PlaceholderHelper::generateContactForm($iletisim,$formEleman);
        $contactForm2 = PlaceholderHelper::generateContactForm2($iletisim,$formEleman);
        $homePageContent = PlaceholderHelper::generateHomePageHeadContent($homePage);
        $pageImage = PlaceholderHelper::generatePageImage($görsel,$page);

        $pageContent = str_replace('[sirket_adi]', $vericontact->SirketAdi, $pageContent);
        $pageContent = str_replace('[telefon]', $vericontact->Telefon, $pageContent);
        $pageContent = str_replace('[telefon2]', $vericontact->Telefon2, $pageContent);
        $pageContent = str_replace('[mail]', $vericontact->Mail, $pageContent);
        $pageContent = str_replace('[mail2]', $vericontact->Mail2, $pageContent);
        $pageContent = str_replace('[adres]', $vericontact->Adres, $pageContent);
        $pageContent = str_replace('[adres2]', $vericontact->Adres2, $pageContent);
        
        $pageContent = str_replace('{[referans_slider]}', $markaContent, $pageContent);
        $pageContent = str_replace('{[sss_content]}', $faqContent, $pageContent);
        $pageContent = str_replace('{[news_content]}', $newsContent, $pageContent);
        $pageContent = str_replace('{[news_slider]}', $newsSlider, $pageContent);
        $pageContent = str_replace('{[about_content]}', $aboutContent, $pageContent);
        $pageContent = str_replace('{[service_content]}', $serviceContent, $pageContent);
        $pageContent = str_replace('{[iletisim_form]}', $contactForm, $pageContent);
        $pageContent = str_replace('{[iletisim_form2]}', $contactForm2, $pageContent);
        $pageContent = str_replace('{[anasayfa_content]}', $homePageContent, $pageContent);
        $pageContent = str_replace('{[sayfa_baslangic_gorsel]}', $pageImage, $pageContent);

        /*
        $icerik = str_replace('[iletisim_bilgi]', $veriIletisim->Bilgi, $icerik);
        $icerik = str_replace('[iletisim_telefon]', $veriIletisim->Telefon, $icerik);
        $icerik = str_replace('[iletisim_mail]', $veriIletisim->Mail, $icerik);
        */
        //return $pageContent;
    //}*/
    private function belirtecleriDegistirSection($sectionContent,$blogs,$section_id,$vericontact,$markalar,$SSS,$news,$about,$services,$iletisim,$formEleman,$homePage,$görsel,$page) {
        
        preg_match_all('/\{\[([^\]]+)\]\}/', $sectionContent, $matches);

        foreach ($matches[1] as $match) {
            switch ($match) {
                case 'referans_slider':
                    $replacement = PlaceholderHelper::generateMarkaContent($markalar, $section_id);
                    break;
                case 'sss_content':
                    $replacement = PlaceholderHelper::generateFaqContent($SSS,$section_id);
                    break;
                case 'news_content':
                    $replacement = PlaceholderHelper::generateNewsContent($news, $section_id);
                    break;
                case 'news_slider':
                    $replacement = PlaceholderHelper::generateNewsSlider($news, $section_id);
                    break;
                case 'about_content':
                    $replacement = PlaceholderHelper::generateAboutContent($about, $section_id);
                    break;
                case 'service_content':
                    $replacement = PlaceholderHelper::generateServiceContent($services, $section_id);
                    break;
                case 'iletisim_form':
                    $replacement = PlaceholderHelper::generateContactForm($iletisim, $formEleman);
                    break;
                case 'iletisim_form2':
                    $replacement = PlaceholderHelper::generateContactForm2($iletisim, $formEleman);
                    break;
                case 'anasayfa_content':
                    $replacement = PlaceholderHelper::generateHomePageHeadContent($homePage);
                    break;
                case 'sayfa_baslangic_gorsel':
                    $replacement = PlaceholderHelper::generatePageImage($page, $görsel);
                    break;
                case 'blog_page':
                    $replacement = PlaceholderHelper::generateBlogPage($blogs, $section_id);
                    break;
                case 'news_page':
                    $replacement = PlaceholderHelper::generateNewsPage($news, $section_id);
                    break;
                // Yeni switch durumları buraya eklenir
                default:
                    $replacement = ''; // Varsayılan durum için boş içerik
            }
            
            // İlgili içeriği değiştir
            $sectionContent = str_replace('{[' . $match . ']}', $replacement, $sectionContent);
        }
        

        $sectionContent = str_replace('[sirket_adi]', $vericontact->SirketAdi, $sectionContent);
        $sectionContent = str_replace('[telefon]', $vericontact->Telefon, $sectionContent);
        $sectionContent = str_replace('[telefon2]', $vericontact->Telefon2, $sectionContent);
        $sectionContent = str_replace('[mail]', $vericontact->Mail, $sectionContent);
        $sectionContent = str_replace('[mail2]', $vericontact->Mail2, $sectionContent);
        $sectionContent = str_replace('[adres]', $vericontact->Adres, $sectionContent);
        $sectionContent = str_replace('[adres2]', $vericontact->Adres2, $sectionContent);
        
        /*
        $sectionContent = str_replace('{[referans_slider]}', PlaceholderHelper::generateMarkaContent($markalar,$section_id), $sectionContent);
        $sectionContent = str_replace('{[sss_content]}', PlaceholderHelper::generateFaqContent($SSS), $sectionContent);
        $sectionContent = str_replace('{[news_content]}', PlaceholderHelper::generateNewsContent($news,$section_id), $sectionContent);
        $sectionContent = str_replace('{[news_slider]}', PlaceholderHelper::generateNewsSlider($news,$section_id), $sectionContent);
        $sectionContent = str_replace('{[about_content]}', PlaceholderHelper::generateAboutContent($about,$section_id), $sectionContent);
        $sectionContent = str_replace('{[service_content]}', PlaceholderHelper::generateServiceContent($services,$section_id), $sectionContent);
        $sectionContent = str_replace('{[iletisim_form]}', PlaceholderHelper::generateContactForm($iletisim,$formEleman), $sectionContent);
        $sectionContent = str_replace('{[iletisim_form2]}', PlaceholderHelper::generateContactForm2($iletisim,$formEleman), $sectionContent);
        $sectionContent = str_replace('{[anasayfa_content]}', PlaceholderHelper::generateHomePageHeadContent($homePage), $sectionContent);
        $sectionContent = str_replace('{[sayfa_baslangic_gorsel]}', PlaceholderHelper::generatePageImage($page,$görsel), $sectionContent);
        $sectionContent = str_replace('{[blog_page]}', PlaceholderHelper::generateBlogPage($blogs,$section_id), $sectionContent);
        $sectionContent = str_replace('{[news_page]}', PlaceholderHelper::generateNewsPage($news,$section_id), $sectionContent);*/
        /*
        $icerik = str_replace('[iletisim_bilgi]', $veriIletisim->Bilgi, $icerik);
        $icerik = str_replace('[iletisim_telefon]', $veriIletisim->Telefon, $icerik);
        $icerik = str_replace('[iletisim_mail]', $veriIletisim->Mail, $icerik);
        */
        return $sectionContent;
    }
    public function index()
    {
        //
        $görsel = HomePageContent::where('otherpageimage',1)->first(); // Veritabanından URL'yi çekin
        $homePage=HomePageContent::where('status',1)->get();
        $services=Service::all();
        $about=AboutUs::where('durum',1)->first();
        $markalar=Marka::all();
        $news = News::orderBy('tarih','desc')->get();
        $vericontact=Contact::where('KullanımDurumu', 1)->first();
        $page=Page::where('AnaSayfa',1)->firstOrFail();
        $SSS=SSS::where('sayfa_id',$page->sayfa_id)->where('Durum',1)->orderBy('Sira')->get();
        $blogs=Blog::all();
        $iletisimform=IletisimForm::where('sayfa_id',$page->sayfa_id)->first();
        $iletisim=iletisim_ui::where('contact_form',$iletisimform->FormId)->first();
        $formEleman=İletisimFormAlan::where('FormId',$iletisimform->FormId)->orderBy('AlanSırası')->get();

        $section=Section::where('sayfa_id',$page->sayfa_id)->where('section_status',1)->orderBy('section_row')->get();
        $pageContent=$page->content;
        //$pageContent=$this->belirtecleriDegistir($pageContent, $vericontact,$markalar,$SSS,$news,$about,$services,$iletisim,$formEleman,$homePage,$görsel,$page);
        //$sectionContent=$section->content;
        //$sectionContent=$this->belirtecleriDegistirSection($sectionContent,$vericontact);
        //dd($pageContent);
        $sectionContent = [];
        foreach ($section as $section) {
            $section_id=$section->section_id;
            $sectionContent[] = $this->belirtecleriDegistirSection($section->content,$blogs,$section_id,$vericontact,$markalar,$SSS,$news,$about,$services,$iletisim,$formEleman,$homePage,$görsel,$page);
        }
        return view('UiLayer.Pages.anasayfa',compact('page','pageContent','sectionContent','markalar','SSS','about','services','görsel'));
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
    }

    /**
     * Display the specified resource.
     */
    public function show(string $slug)
    {
        //
        $görsel = HomePageContent::where('otherpageimage',1)->first(); 
        $homePage=HomePageContent::where('status',1)->get();
        $services=Service::all();
        $about=AboutUs::where('durum',1)->first();
        $news = News::orderBy('tarih','desc')->get();
        $markalar=Marka::all();
        $vericontact=Contact::where('KullanımDurumu', 1)->first();
        $slug='/'.$slug;
        //dd($slug);
        $page = Page::where('slug', $slug)->where('yayin_durumu',1)->firstOrFail();
        
        $iletisimform=IletisimForm::where('sayfa_id',$page->sayfa_id)->first();
        $iletisim='';
        $formEleman='';
        if ($iletisimform) {
            $iletisim=iletisim_ui::where('contact_form',$iletisimform->FormId)->first();
            $formEleman=İletisimFormAlan::where('FormId',$iletisimform->FormId)->orderBy('AlanSırası')->get();
        }
        $blogs=Blog::all();
        $SSS=SSS::where('sayfa_id',$page->sayfa_id)->where('Durum',1)->orderBy('Sira')->get();
        $page->title=str_replace(' ', '', $page->title);
        //$page->title=strtr($page->title, 'çÇğĞıİöÖşŞüÜ', 'cCgGiIoOsSuU');
        //dd($page->title);
        $sections=Section::where('sayfa_id',$page->sayfa_id)->where('section_status',1)->orderBy('section_row')->get();
        $pageContent=$page->content;
        //$pageContent=$this->belirtecleriDegistir($pageContent,$vericontact,$markalar,$SSS,$news,$about,$services,$iletisim,$formEleman,$homePage,$görsel,$page);
        //$sectionContent=$section->content;
        //$sectionContent=$this->belirtecleriDegistirSection($sectionContent,$vericontact);
        //dd($pageContent);
        $sectionContent = [];
        foreach ($sections as $section) {
            $section_id=$section->section_id;
            $sectionContent[] = $this->belirtecleriDegistirSection($section->content,$blogs,$section_id ,$vericontact,$markalar,$SSS,$news,$about,$services,$iletisim,$formEleman,$homePage,$görsel,$page);
        }
        return view('UiLayer.Pages.'.$page->title,compact('page','pageContent','sectionContent','SSS','markalar','about','iletisim','formEleman'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
    public function newsDetails(string $id){
        $news=News::findOrFail($id);
        return view('UiLayer.Details.news',compact('news'));
    }
    
    public function blogDetails(string $id){
        $blog=Blog::findOrFail($id);
        return view('UiLayer.Details.blog',compact('blog'));
    }
}
