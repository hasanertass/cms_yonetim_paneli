<?php
namespace App\Helpers;
use Carbon\Carbon;
use App\Models\Section;
use App\Models\Section_Setting;
use App\Models\Contact;
use App\Models\Page;
use App\Models\News;
use App\Models\Blog;
use App\Models\Service;
use App\Models\Marka;
use App\Models\Public_Setting;

class PlaceholderHelper{

    public static function generateAboutContent($about,$section_id){
        $setting=Section_Setting::where('section_id',$section_id)->where('setting_name','images_location')->first();
        $setting2=Section_Setting::where('section_id',$section_id)->where('setting_name','small_image_location')->first();
        $image_location="sol";
        $small_image_location="start-0 top-0 pe-3 pb-3";
        if ($setting) {
            $image_location=$setting->setting_value;
            $small_image_location=$setting2->setting_value;
        }
        $aboutContent = '<div class="container-xxl py-6">
            <div class="container">
                <div class="row g-5">';
                    if ($image_location == "sol") {
                        $aboutContent.='
                            <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.1s">
                                <div class="position-relative overflow-hidden ps-5 pt-5 h-100" style="min-height: 400px;">
                                    <img class="position-absolute w-100 h-100" src="' . $about->görsel . '" alt=""
                                        style="object-fit: cover;">';
                                        if ($about->görsel2) {
                                            $aboutContent.='<img class="position-absolute '.$small_image_location.' bg-white" src="' . $about->görsel2 . '" alt=""
                                            style="width: 200px; height: 200px;">';
                                        }
                                        $aboutContent.='
                                </div>
                            </div>';
                    }
                    $aboutContent.='
                        <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.5s">
                            <div class="h-100">
                                <h6 class="text-primary text-uppercase mb-2">Hakkımızda</h6>
                                <h1 class="display-6 mb-4">' . $about->baslik . '</h1>
                                <p>' . $about->aciklama1 . '</p>
                                <p class="mb-4">' . $about->aciklama2 . '</p>
                                <div class="row g-2 mb-4 pb-2">';
                                for ($i = 1; $i <= 8; $i++) {
                                if ($about['prop' . $i]) {
                                    $aboutContent .= '<div class="col-sm-6">
                                        <i class="fa fa-check text-primary me-2"></i>' . $about['prop' . $i] . '
                                    </div>';
                                }}
                                $aboutContent .= '   
                            </div>
                        </div>
                    </div>';
                    if ($image_location == "sağ") {
                            $aboutContent.='
                        <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.1s">
                            <div class="position-relative overflow-hidden ps-5 pt-5 h-100" style="min-height: 400px;">
                                <img class="position-absolute w-100 h-100" src="' . $about->görsel . '" alt=""
                                    style="object-fit: cover;">';
                                    if ($about->görsel2) {
                                        $aboutContent.='<img class="position-absolute '.$small_image_location.' bg-white" src="' . $about->görsel2 . '" alt=""
                                        style="width: 200px; height: 200px;">';
                                    }
                                    $aboutContent.='
                            </div>
                        </div>';
                    }$aboutContent.='
                </div>
            </div>
        </div>';

        return $aboutContent;
    }
    public static function generateNewsSlider($news,$section_id){
        $title_color=Public_Setting::first();

        $section=Section::findOrFail($section_id);
        $setting2=Section_Setting::where('section_id',$section_id)->where('setting_name','detail_color')->first();
        //dd($section_id);
        $page=Page::findOrFail($section->sayfa_id);
        if($page->AnaSayfa==1){
            $news=News::where('home_page_status',1)->get();
        }
        if ($setting2) {
            
            $newsSlider='
                <style>
                    :root {
                        --color2: '.$setting2->setting_value.';
                    }
                </style>   
            ';
        }
        $count=1;
        $newsSlider.='<div class="container">
        <h1 class="display-6 mb-4" style="color: '.$title_color->section_title_color.';">'.$section->section_name.'</h1>
        <section class="customer-news slider">';
                $colCount=1;
                foreach ($news as $key => $newses) {
                    $newsDetailsRoute=$newses->link;
                    if ($newses->link == null) {
                        $newsDetailsRoute = route('news-detail', ['id' => $newses->id]);
                    }
                    $tarih = Carbon::createFromFormat('Y-m-d', $newses->tarih);
                    $newsSlider.='
                        <figure class="snip1493">
                            <div class="image"><img width= "100%" height="225px" src="'.$newses->görsel.'"
                                    alt="Haber Görseli" />
                            </div>
                            <figcaption>
                                <div class="date"><span class="day">'. $tarih->format('d') .'</span><span class="month">'. $tarih->format('M') .'</span></div>
                                <h3>'. $newses->baslik .'</h3>
                                <p>
                                    '
                                    . $newses->kisa_aciklama .
                                    '
                                </p>
                            </figcaption>
                            <a href="'. $newsDetailsRoute .'" target="_blank"></a>
                        </figure> ';
                    $section=Section::findOrFail($section_id);
                    if ($count>=$section->data_piece) {
                        break;
                    }
                    $count+=1;
                }
                $newsSlider.='
        </section>
        </div>';
        return $newsSlider;
    }
    public static function generateNewsContent($news,$section_id){
        $title_color=Public_Setting::first();

        $section=Section::findOrFail($section_id);
        $setting=Section_Setting::where('section_id',$section_id)->where('setting_name','row_piece')->first();
        $setting2=Section_Setting::where('section_id',$section_id)->where('setting_name','detail_color')->first();
        //dd($setting->setting_value);
        //dd($settings);
        $page=Page::findOrFail($section->sayfa_id);
        if($page->AnaSayfa==1){
            $news=News::where('home_page_status',1)->get();
        }
        $row_piece=4;
        $row=$setting->setting_value;
        if ($setting) {
            $row_piece = floor(12 / $row); // Aşağı yuvarlama
            $row_piece = intval($row_piece); // Sonucu tamsayıya dönüştürme
            $newsContent='
                <style>
                    :root {
                        --color3: '.$setting2->setting_value.';
                    }
                </style>   
            ';
        }
        $count = 1;
        $columnCount = 1;
        $newsContent .= '<div class="container">
        <h1 class="display-6 mb-4" style="color: '.$title_color->section_title_color.';">'.$section->section_name.'</h1>
        <div class="row">'; // Row açılışı

            foreach ($news as $key => $newses) {
            $newsDetailsRoute = $newses->link;
            if ($newses->link == null) {
                $newsDetailsRoute = route('news-detail', ['id' => $newses->id]);
            }
            $tarih = Carbon::createFromFormat('Y-m-d', $newses->tarih);
            $newsContent .= '
            <div class="col-md-'.$row_piece.'">'; // Sütun açılışı

            $newsContent .= '<figure class="snip1208">
                <img width="100%" height="225px" src="' . $newses->görsel . '" alt="Haber Görseli" />
                <div class="date"><span class="day">' . $tarih->format('d') . '</span><span class="month">' . $tarih->format('M') . '</span></div><i class="ion-film-marker"></i>
                <figcaption>
                    <h3>' . $newses->baslik . '</h3>
                    <p>' . $newses->kisa_aciklama . '</p>
                    <button>Read More</button>
                </figcaption><a href="' . $newsDetailsRoute . '" target="_blank"></a>
            </figure>';

            $newsContent .= '</div>'; // Sütun kapanışı
            if ($columnCount >=$row) {
                $newsContent .= '</div><div class="row">';
                $columnCount=0;
            }
            $columnCount++;
            $section=Section::findOrFail($section_id);
            if ($count>=$section->data_piece) {
                break;
            }
            $count+=1;
        }

        $newsContent .= '</div></div>'; // Row ve container kapanışı
        return $newsContent;
    }
    public  static function generateMarkaContent($markalar,$section_id){
        //dd($section_id);
        $title_color=Public_Setting::first();

        $section=Section::findOrFail($section_id);
        $page=Page::findOrFail($section->sayfa_id);
        if($page->AnaSayfa==1){
            $markalar=Marka::where('home_page_status',1)->get();
        }
        $count=1;
        $markaContent='<div class="container">
        <h1 class="display-6 mb-4" style="color: '.$title_color->section_title_color.';">'.$section->section_name.'</h1>
        <section class="customer-logos slider">';
        foreach ($markalar as $key => $marka) {
            $markaContent.='<div class="slide">
            <img src="' . $marka->MarkaLogo . '"alt="Referans Marka">
            </div>';
            
            $section=Section::findOrFail($section_id);
            if ($count>=$section->data_piece) {
                break;
            }
            $count+=1;
        }
        $markaContent.='</section> </div>';
        return $markaContent;
    }
    public static function generateFaqContent($SSS,$section_id){
        $title_color=Public_Setting::first();

        $section=Section::findOrFail($section_id);
        $faqContent='<div class="accordion">
        <h1 class="display-6 mb-4" style="color: '.$title_color->section_title_color.';">'.$section->section_name.'</h1>
        ';
        foreach ($SSS as $key => $sss) {
            $faqContent.='<div class="accordion-item">
            <div class="accordion-item-header">
                ' . $sss->Soru . '
            </div>
            <div class="accordion-item-body">
                <div class="accordion-item-body-content">
                    ' . $sss->Cevap . '
                </div>
            </div>
            </div>';
        }
        $faqContent.='</div>';
        return $faqContent;
    }
    public static function generateServiceContent($services,$section_id){
        $title_color=Public_Setting::first();

        $section=Section::findOrFail($section_id);
        $setting=Section_Setting::where('section_id',$section_id)->where('setting_name','background_color')->first();
        $setting2=Section_Setting::where('section_id',$section_id)->where('setting_name','text_color')->first();
        $setting3=Section_Setting::where('section_id',$section_id)->where('setting_name','row_piece')->first();
        //dd($setting3->setting_value);
        //dd($settings);
        $page=Page::findOrFail($section->sayfa_id);
        if($page->AnaSayfa==1){
            $services=Service::where('home_page_status',1)->get();
        }
        $text_color='#000000';
        $row_piece=4;
        $serviceContent='';
        if ($setting) {
            $text_color=$setting2->setting_value;
            $divided_value = $setting3->setting_value;
            $row_piece = 12/ $divided_value;
            $serviceContent='
                <style>
                    :root {
                        --color1: '.$setting->setting_value.';
                    }
                </style>   
            ';
        }
        $count=1;
        $serviceContent .=
        '<section class="we-offer-area text-center bg-gray">
            <div class="container">
            <h1 class="display-6 mb-4" style="color: '.$title_color->section_title_color.';">'.$section->section_name.'</h1>
                <div class="row our-offer-items less-carousel">';
        foreach ($services as $key => $service) {
            $serviceDetailsRoute = route('service-detail', ['id' => $service->id]);
            $serviceContent .=
                '<div class="col-md-'.$row_piece.' col-sm-6 equal-height">
                    <a href="'.$serviceDetailsRoute.'" target="_blank">
                        <div class="item">
                            <i class="' . $service->icon . '"></i>
                            <h4 style="color: '.$text_color.';">' . $service->title . '</h4>
                            <p style="color: '.$text_color.';">
                                ' . $service->short_description . '
                            </p>
                        </div>
                    </a>
                </div>';                
            $section=Section::findOrFail($section_id);
            if ($count>=$section->data_piece) {
                break;
            }
            $count+=1;
        }
        $serviceContent .=
                    '</div>
                </div>
            </section>';
        return $serviceContent;
    }
    public  static function generateServiceContentImage($services,$section_id){
        $title_color=Public_Setting::first();
        $setting=Section_Setting::where('section_id',$section_id)->where('setting_name','hover_color')->first();
        $setting2=Section_Setting::where('section_id',$section_id)->where('setting_name','row_piece')->first();
        $row_piece=3;
        $serviceContent='';
        if($setting){
            $row=$setting2->setting_value;
            $row_piece = floor(12 / $row); // Aşağı yuvarlama
            $row_piece = intval($row_piece); // Sonucu tamsayıya dönüştürme
            $serviceContent.='
                <style>
                    :root {
                        --color4: '.$setting->setting_value.';
                    }
                </style>   
            ';
        }
        $section=Section::findOrFail($section_id);
        $page=Page::findOrFail($section->sayfa_id);
        if($page->AnaSayfa==1){
            $services=Service::where('home_page_status',1)->get();
        }
        $serviceContent.='
        <div class="container-xxl py-6">
            <div class="container">
                <div class="text-center mx-auto mb-5 wow fadeInUp" data-wow-delay="0.1s" style="max-width: 500px;">
                    <h1 class="display-6 mb-4" style="color: '.$title_color->section_title_color.';">'.$section->section_name.'</h1>
                </div>
                <div class="row g-0 service-items">';
                    foreach ($services as $key => $service){
                        $serviceDetailsRoute = route('service-detail', ['id' => $service->id]);
                        /*if ($service->link == null) {
                            $serviceRoute = route('service-detay', ['id' => $service->id]);
                        }*/
                        $serviceContent.='
                        <div class="col-md-'.$row_piece.' wow fadeInUp" data-wow-delay="0.1s">
                            <div class="service-item position-relative">
                                <div class="position-relative">
                                    <img  width="100%" height="260px"src="'.$service->small_image.'" alt="">
                                    <div class="service-social text-center">
                                        <a style="width: 150px;" class="btn btn-square btn-outline-primary border-2 m-15 btn-service" href="'.$serviceDetailsRoute.'" target="_blank">Devamını oku</a>
                                    </div>
                                </div>
                                <div class="bg-light text-center p-4">
                                    <h5 class="mt-2">'.$service->title.'</h5>
                                    <span>'.$service->short_description.'</span>
                                </div>
                            </div>
                        </div>
                        ';
                    }
                    $serviceContent.='
                </div>
            </div>
        </div> ';
        return $serviceContent;
    }
    public static function generateContactForm($iletisimform,$formEleman,$section_id){
        $title_color=Public_Setting::first();
        $button_color='';
        $setting=Section_Setting::where('section_id',$section_id)->where('setting_name','button_color')->first();
        if($setting){
            $button_color='style="background-color: '.$setting->setting_value.';"';
        }
        $contact=Contact::where('KullanımDurumu',1)->first();
        list($latitude, $longitude) = explode(", ", $contact->Harita);
        //dd($latitude.', ' .$longitude);
        if($iletisimform&&$formEleman){
            $formAction= route('forms.store');
        $csrfToken = session()->get('_token');
        $formContent='
            <div class="container-xxl py-6">
                <div class="container">
                    <div class="row g-5">
                        <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.1s" style="min-height: 450px;">
                            <div class="position-relative h-100">
                                <iframe class="position-relative w-100 h-100"
                                src="https://www.google.com/maps/embed?pb='. $latitude.', '.$longitude.'"
                                frameborder="0" style="min-height: 250px; border:0;" allowfullscreen="" aria-hidden="false"
                                    tabindex="0"></iframe>
                            </div>
                        </div>
                        <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.5s">
                            <h1 class="display-6 mb-4" style="color: '.$title_color->section_title_color.';">'. $iletisimform->FormName .'</h1>
                            <p class="mb-4" style="text-align: center;">'.$iletisimform->form_description .'</p>
                            <form method="POST" action="'.$formAction.'" onsubmit="return handleFormSubmit(this)" enctype="multipart/form-data">
                                <input type="hidden" name="_token" value="'. $csrfToken .'">
                                <input type="hidden" id="FormId" name="FormId" value="'.$iletisimform->FormId.'">
                                <div class="row g-3">';
                                    foreach($formEleman as $key => $eleman) {
                                        if($eleman->AlanType=='textarea') {
                                            $formContent.='
                                            <div class="col-12">
                                                <div class="form-floating">
                                                    <textarea class="form-control border-0 bg-light"
                                                        placeholder="Leave a message here" id="'.$eleman->AlanName.'"
                                                        name="'.$eleman->AlanName.'" style="height: 150px" required></textarea>
                                                    <label for="message">'. $eleman->PleaceHolder .'</label>
                                                </div>
                                            </div>
                                            ';
                                        }elseif ($eleman->AlanType=='file') {
                                            $formContent.='
                                            <div class="col-md-12">
                                                <div class="">
                                                    <label for="name">'. $eleman->PleaceHolder.'</label>
                                                    <input type="'.$eleman->AlanType.'" class="form-control border-0 bg-light"
                                                        id="'.$eleman->AlanName.'" name="'.$eleman->AlanName.'" placeholder="'.$eleman->PleaceHolder.'" required>
                                                </div>
                                            </div>
                                            ';
                                        }
                                        else {  
                                            $formContent.='
                                            <div class="col-md-6">
                                                <div class="form-floating">
                                                    <input type="'.$eleman->AlanType.'" class="form-control border-0 bg-light"
                                                        id="'.$eleman->AlanName.'" name="'.$eleman->AlanName.'" placeholder="'.$eleman->PleaceHolder.'" required>
                                                    <label for="name">'. $eleman->PleaceHolder.'</label>
                                                </div>
                                            </div>
                                            ';
                                        }
                                    }                                
                                    $formContent.='
                                        <div class="d-grid">
                                            <button class="btn btn-primary py-3 px-5" type="submit" '.$button_color.'>Gönder</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>';
            return $formContent;
        }
        else {
            return '';
        }
    }
    public static function generateContactForm2($iletisimform,$formEleman,$section_id){
        $button_color='';
        $title_color=Public_Setting::first();
        $setting=Section_Setting::where('section_id',$section_id)->where('setting_name','button_color')->first();
        if($setting){
            $button_color='style="background-color: '.$setting->setting_value.';"';
        }
        //dd($button_color);
        if($iletisimform&&$formEleman){
            $formAction= route('forms.store');
            $csrfToken = session()->get('_token');
            $formContent='
            <div class="container-xxl py-6">
                <div class="container">
                    <div class="row g-5">
                        <div class="col-lg-12 wow fadeInUp" data-wow-delay="0.5s">
                            <h1 class="display-6 mb-4" style="color: '.$title_color->section_title_color.';">'. $iletisimform->FormName .'</h1>
                            <p class="mb-4" style="text-align: center;">'.$iletisimform->form_description .'</p>
                            <form method="POST" action="'.$formAction.'" onsubmit="return handleFormSubmit(this)" enctype="multipart/form-data">
                                <input type="hidden" name="_token" value="'. $csrfToken .'">
                                <input type="hidden" id="FormId" name="FormId" value="'. $iletisimform->FormId .'">
                                <div class="row g-3">';
                                    foreach($formEleman as $key => $eleman) {
                                        if($eleman->AlanType=='textarea') {
                                            $formContent.='
                                            <div class="col-12">
                                                <div class="form-floating">
                                                    <textarea class="form-control border-0 bg-light"
                                                        placeholder="Leave a message here" id="'.$eleman->AlanName.'"
                                                        name="'.$eleman->AlanName.'" style="height: 150px" required></textarea>
                                                    <label for="message">'. $eleman->PleaceHolder .'</label>
                                                </div>
                                            </div>
                                            ';
                                        }elseif ($eleman->AlanType=='file') {
                                            $formContent.='
                                            <div class="col-md-12">
                                                <div class="">
                                                    <label for="name">'. $eleman->AlanName.'</label>
                                                    <input type="'.$eleman->AlanType.'" class="form-control border-0 bg-light"
                                                        id="'.$eleman->AlanName.'" name="'.$eleman->AlanName.'" placeholder="'.$eleman->PleaceHolder.'" required>
                                                </div>
                                            </div>
                                            ';
                                        }
                                        else {
                                            $formContent.='
                                            <div class="col-md-6">
                                                <div class="form-floating">
                                                    <input type="'.$eleman->AlanType.'" class="form-control border-0 bg-light"
                                                        id="'.$eleman->AlanName.'" name="'.$eleman->AlanName.'" placeholder="'.$eleman->PleaceHolder.'" required>
                                                    <label for="name">'. $eleman->PleaceHolder.'</label>
                                                </div>
                                            </div>
                                            ';
                                        }
                                    }                                
                                    $formContent.='
                                        <div class="d-grid">
                                            <button class="btn btn-primary py-3 px-5" type="submit"'.$button_color.' >Gönder</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>';
            return $formContent;
        }
        else {
            return '';
        }
    }
    public static function generateHomePageHeadContent($homePage){
        $homePageHeadContent='
        <div class="container-fluid p-0 wow fadeIn" data-wow-delay="0.1s">
            <div id="header-carousel" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">';
                $activate='active';
                    foreach($homePage as $content){
                        //dd($content->buton_link);
                        $homePageHeadContent.='
                        <div class="carousel-item '.$activate.'">
                            <img width="100%" height="1070px" class="w-100"  src="'.$content->image.'" alt="Image">
                            <div class="carousel-caption">
                                <div class="container">
                                    <div class="row justify-content-center">
                                        <div class="col-lg-9">
                                            <h1 class="display-2 text-light mb-5 animated slideInDown">'. $content->title .'</h1>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>';
                        $activate='';
                    } $homePageHeadContent.='
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#header-carousel" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#header-carousel" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
        </div>';
        return $homePageHeadContent;
    }
    public static function generatePageImage($section_id,$görsel){
        $imageURL = asset($görsel->image);
        $section=Section::findOrFail($section_id);

        $setting=Section_Setting::where('section_id',$section_id)->where('setting_name','background_color')->first();
        $setting2=Section_Setting::where('section_id',$section_id)->where('setting_name','text_color')->first();
        $text_color='white';
        $background_color='#0c2b4b';
        if($setting){
            $text_color=$setting2->setting_value;
            $background_color=$setting->setting_value;
        }
        $pageImageContent='<div class="container-fluid py-6 my-5 mt-0 wow fadeIn" style="background-color: '.$background_color.';" data-wow-delay="0.1s">
            <div class="container text-center">
                <h1 class="display-4 animated slideInDown mb-4" style="color: '.$text_color.';" >'.$section->Page->title.'</h1>
            </div>
        </div>
        ';
        return $pageImageContent;
    }
    public  static function generateBlogPage($blogs,$section_id){
        $title_color=Public_Setting::first();
        $setting=Section_Setting::where('section_id',$section_id)->where('setting_name','hover_color')->first();
        $setting2=Section_Setting::where('section_id',$section_id)->where('setting_name','row_piece')->first();
        $row_piece=3;
        $blogPage='';
        if($setting){
            $row=$setting2->setting_value;
            $row_piece = floor(12 / $row); // Aşağı yuvarlama
            $row_piece = intval($row_piece); // Sonucu tamsayıya dönüştürme
            $blogPage.='
                <style>
                    :root {
                        --color5: '.$setting->setting_value.';
                    }
                </style>   
            ';
        }
        $section=Section::findOrFail($section_id);
        $page=Page::findOrFail($section->sayfa_id);
        if($page->AnaSayfa==1){
            $blogs=Blog::where('home_page_status',1)->get();
        }
        $blogPage.='
        <div class="container-xxl py-6">
            <div class="container">
                <div class="text-center mx-auto mb-5 wow fadeInUp" data-wow-delay="0.1s" style="max-width: 500px;">
                    <h1 class="display-6 mb-4" style="color: '.$title_color->section_title_color.';">'.$section->section_name.'</h1>
                </div>
                <div class="row g-0 blog-items">';
                    foreach ($blogs as $key => $blog){
                        $blogRoute=$blog->link;
                        if ($blog->link == null) {
                            $blogRoute = route('blog-detail', ['id' => $blog->id]);
                        }
                        $blogPage.='
                        <div class="col-md-'.$row_piece.' wow fadeInUp" data-wow-delay="0.1s">
                            <div class="blog-item position-relative">
                                <div class="position-relative">
                                    <img  width="100%" height="260px"src="'.$blog->small_image.'" alt="">
                                    <div class="blog-social text-center">
                                        <a style="width: 150px;" class="btn btn-square btn-outline-primary border-2 m-15 btn-blog" href="'.$blogRoute.'" target="_blank">Devamını oku</a>
                                    </div>
                                </div>
                                <div class="bg-light text-center p-4">
                                    <h5 class="mt-2">'.$blog->title.'</h5>
                                    <span>'.$blog->short_description.'</span>
                                </div>
                            </div>
                        </div>
                        ';
                    }
                    $blogPage.='
                </div>
            </div>
        </div> ';
        return $blogPage;
    }
    public  static function generateNewsPage($news,$section_id){
        $title_color=Public_Setting::first();
        $setting=Section_Setting::where('section_id',$section_id)->where('setting_name','hover_color')->first();
        $setting2=Section_Setting::where('section_id',$section_id)->where('setting_name','row_piece')->first();
        $row_piece=3;
        $newsPage='';
        if($setting){
            $row=$setting2->setting_value;
            $row_piece = floor(12 / $row); // Aşağı yuvarlama
            $row_piece = intval($row_piece); // Sonucu tamsayıya dönüştürme
            $newsPage='
                <style>
                    :root {
                        --color6: '.$setting->setting_value.';
                    }
                </style>   
            ';
        }
        $section=Section::findOrFail($section_id);
        $page=Page::findOrFail($section->sayfa_id);
        if($page->AnaSayfa==1){
            $news=News::where('home_page_status',1)->get();
        }
        $newsPage.='
        <div class="container-xxl py-6">
            <div class="container">
                <div class="text-center mx-auto mb-5 wow fadeInUp" data-wow-delay="0.1s" style="max-width: 500px;">
                    <h1 class="display-6 mb-4" style="color: '.$title_color->section_title_color.';">'.$section->section_name.'</h1>
                </div>
                <div class="row g-0 news-items">';
                    foreach ($news as $key => $news){
                        $newsRoute=$news->link;
                        if ($news->link == null) {
                            $newsRoute = route('news-detail', ['id' => $news->id]);
                        }
                        $newsPage.='
                        <div class="col-md-'.$row_piece.' wow fadeInUp" data-wow-delay="0.1s">
                            <div class="news-item position-relative">
                                <div class="position-relative">
                                    <img width="100%" height="275px" src="'.$news->görsel.'" alt="">
                                    <div class="news-social text-center">
                                        <a style="width: 150px;" class="btn btn-square btn-outline-primary border-2 m-15 btn-news" href="'.$newsRoute.'" target="_blank" >Devamını oku</a>
                                    </div>
                                </div>
                                <div class="bg-light text-center p-4">
                                    <h5 class="mt-2">'.$news->baslik.'</h5>
                                    <span>'.$news->kisa_aciklama.'</span>
                                </div>
                            </div>
                        </div>
                        ';
                    }
                    $newsPage.='
                </div>
            </div>
        </div> ';
        return $newsPage;
    }
}
