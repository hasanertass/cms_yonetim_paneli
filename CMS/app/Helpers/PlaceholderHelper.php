<?php
namespace App\Helpers;
use Carbon\Carbon;
use App\Models\Section;
use App\Models\Section_Setting;
use App\Models\Contact;

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
        $section=Section::findOrFail($section_id);
        $setting2=Section_Setting::where('section_id',$section_id)->where('setting_name','detail_color')->first();
        //dd($setting->setting_value);
        //dd($settings);
        if ($setting2) {
            $cssFilePath = public_path('drivin-1.0.0/css/style.css');
            // Mevcut stil dosyasının içeriğini al
            $existingCssContent = file_get_contents($cssFilePath);

            // Yeni stil değişkenini ekleyerek içeriği güncelle
            $updatedCssContent = $existingCssContent . "\n:root {\n  --color2: {$setting2->setting_value};\n  /* Diğer değişkenler */\n}";

            // Güncellenmiş stil içeriğini dosyaya yaz
            file_put_contents($cssFilePath, $updatedCssContent);
        }
        $count=1;
        $newsSlider='<div class="container">
        <h1 class="display-6 mb-4" style="color: #f3bd00;">'.$section->section_name.'</h1>
        <section class="customer-news slider">';
                $colCount=1;
                foreach ($news as $key => $newses) {
                    $newsDetailsRoute=$newses->link;
                    if ($newses->link == null) {
                        $newsDetailsRoute = route('news-detay', ['id' => $newses->id]);
                    }
                    $tarih = Carbon::createFromFormat('Y-m-d', $newses->tarih);
                    $newsSlider.='
                        <figure class="snip1493">
                            <div class="image"><img width= "310px" height="225px" src="'.$newses->görsel.'"
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
                            <a href="'. $newsDetailsRoute .'"></a>
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
        $section=Section::findOrFail($section_id);
        $setting=Section_Setting::where('section_id',$section_id)->where('setting_name','row_piece')->first();
        $setting2=Section_Setting::where('section_id',$section_id)->where('setting_name','detail_color')->first();
        //dd($setting->setting_value);
        //dd($settings);
        $row_piece=4;
        $row=$setting->setting_value;
        if ($setting) {
            $cssFilePath = public_path('drivin-1.0.0/css/style.css');
            // Mevcut stil dosyasının içeriğini al
            $existingCssContent = file_get_contents($cssFilePath);
            $row_piece = floor(12 / $row); // Aşağı yuvarlama
            $row_piece = intval($row_piece); // Sonucu tamsayıya dönüştürme
            // Yeni stil değişkenini ekleyerek içeriği güncelle
            $updatedCssContent = $existingCssContent . "\n:root {\n  --color3: {$setting2->setting_value};\n  /* Diğer değişkenler */\n}";

            // Güncellenmiş stil içeriğini dosyaya yaz
            file_put_contents($cssFilePath, $updatedCssContent);
        }
        $count = 1;
        $columnCount = 1;
        $newsContent = '<div class="container">
        <h1 class="display-6 mb-4" style="color: #f3bd00;">'.$section->section_name.'</h1>
        <div class="row">'; // Row açılışı

            foreach ($news as $key => $newses) {
            $newsDetailsRoute = $newses->link;
            if ($newses->link == null) {
                $newsDetailsRoute = route('news-detay', ['id' => $newses->id]);
            }
            $tarih = Carbon::createFromFormat('Y-m-d', $newses->tarih);
            $newsContent .= '
            <div class="col-md-'.$row_piece.'">'; // Sütun açılışı

            $newsContent .= '<figure class="snip1208">
                <img width="auto" height="225px" src="' . $newses->görsel . '" alt="Haber Görseli" />
                <div class="date"><span class="day">' . $tarih->format('d') . '</span><span class="month">' . $tarih->format('M') . '</span></div><i class="ion-film-marker"></i>
                <figcaption>
                    <h3>' . $newses->baslik . '</h3>
                    <p>' . $newses->kisa_aciklama . '</p>
                    <button>Read More</button>
                </figcaption><a href="' . $newsDetailsRoute . '"></a>
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
        $section=Section::findOrFail($section_id);
        $count=1;
        $markaContent='<div class="container">
        <h1 class="display-6 mb-4" style="color: #f3bd00;">'.$section->section_name.'</h1>
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
        $section=Section::findOrFail($section_id);
        $faqContent='<div class="accordion">
        <h1 class="display-6 mb-4" style="color: #f3bd00;">'.$section->section_name.'</h1>
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
        $section=Section::findOrFail($section_id);
        $setting=Section_Setting::where('section_id',$section_id)->where('setting_name','background_color')->first();
        $setting2=Section_Setting::where('section_id',$section_id)->where('setting_name','text_color')->first();
        $setting3=Section_Setting::where('section_id',$section_id)->where('setting_name','row_piece')->first();
        //dd($setting3->setting_value);
        //dd($settings);
        $text_color='#000000';
        $row_piece=4;
        if ($setting) {
            $cssFilePath = public_path('drivin-1.0.0/css/style.css');
            $text_color=$setting2->setting_value;
            $divided_value = $setting3->setting_value;
            $row_piece = 12/ $divided_value;
            // Mevcut stil dosyasının içeriğini al
            $existingCssContent = file_get_contents($cssFilePath);

            // Yeni stil değişkenini ekleyerek içeriği güncelle
            $updatedCssContent = $existingCssContent . "\n:root {\n  --color1: {$setting->setting_value};\n  /* Diğer değişkenler */\n}";

            // Güncellenmiş stil içeriğini dosyaya yaz
            file_put_contents($cssFilePath, $updatedCssContent);
        }

        $count=1;
        $serviceContent =
        '<section class="we-offer-area text-center bg-gray">
            <div class="container">
            <h1 class="display-6 mb-4" style="color: #f3bd00;">'.$section->section_name.'</h1>
                <div class="row our-offer-items less-carousel">';
        foreach ($services as $key => $service) {
            $serviceContent .=
                '<div class="col-md-'.$row_piece.' col-sm-6 equal-height">
                    <div class="item">
                        <i class="' . $service->icon_class->icon . '"></i>
                        <h4 style="color: '.$text_color.';">' . $service->title . '</h4>
                        <p style="color: '.$text_color.';">
                            ' . $service->description . '
                        </p>
                    </div>
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
    public static function generateContactForm($iletisim,$formEleman){
        $contact=Contact::where('KullanımDurumu',1)->first();
        list($latitude, $longitude) = explode(", ", $contact->Harita);
        //dd($latitude.', ' .$longitude);
        if($iletisim&&$formEleman){
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
                            <h1 class="display-6 mb-4" style="color: #f3bd00;">'. $iletisim->title .'</h1>
                            <p class="mb-4" style="text-align: center;">'.$iletisim->description .'</p>
                            <form method="POST" action="'.$formAction.'" onsubmit="return handleFormSubmit(this)" enctype="multipart/form-data">
                                <input type="hidden" name="_token" value="'. $csrfToken .'">
                                <input type="hidden" id="FormId" name="FormId" value="'.$iletisim->contact_form.'">
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
                                            <button class="btn btn-primary py-3 px-5" type="submit">Gönder</button>
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
    public static function generateContactForm2($iletisim,$formEleman){
        if($iletisim&&$formEleman){
            $formAction= route('forms.store');
            $csrfToken = session()->get('_token');
            $formContent='
            <div class="container-xxl py-6">
                <div class="container">
                    <div class="row g-5">
                        <div class="col-lg-12 wow fadeInUp" data-wow-delay="0.5s">
                            <h1 class="display-6 mb-4" style="color: #f3bd00;">'. $iletisim->title .'</h1>
                            <p class="mb-4" style="text-align: center;">'.$iletisim->description .'</p>
                            <form method="POST" action="'.$formAction.'" onsubmit="return handleFormSubmit(this)" enctype="multipart/form-data">
                                <input type="hidden" name="_token" value="'. $csrfToken .'">
                                <input type="hidden" id="FormId" name="FormId" value="'. $iletisim->contact_form .'">
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
                                            <button class="btn btn-primary py-3 px-5" type="submit">Gönder</button>
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
                            <img class="w-100" src="'.$content->image.'" alt="Image">
                            <div class="carousel-caption">
                                <div class="container">
                                    <div class="row justify-content-center">
                                        <div class="col-lg-7">
                                            <h1 class="display-2 text-light mb-5 animated slideInDown">'. $content->title .'</h1>
                                            <h1 class="display-2 text-light mb-5 animated slideInDown">'. $content->description .'</h1>
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
    public static function generatePageImage($görsel,$page){
        $imageURL = asset($görsel->image);
        $pageImageContent='<div class="container-fluid page-header py-6 my-5 mt-0 wow fadeIn" data-wow-delay="0.1s">
            <div class="container text-center">
                <h1 class="display-4 text-white animated slideInDown mb-4" >'.$page->title.' Sayfası</h1>
            </div>
        </div>
        ';
        return $pageImageContent;
    }
    public  static function generateBlogPage($blogs,$section_id){
        $section=Section::findOrFail($section_id);
        $blogPage='
        <div class="container-xxl py-6">
            <div class="container">
                <div class="text-center mx-auto mb-5 wow fadeInUp" data-wow-delay="0.1s" style="max-width: 500px;">
                    <h1 class="display-6 mb-4">'.$section->section_name.'</h1>
                </div>
                <div class="row g-0 team-items">';
                    foreach ($blogs as $key => $blog){
                        $blogRoute=$blog->link;
                        if ($blog->link == null) {
                            $blogRoute = route('blog-detay', ['id' => $blog->id]);
                        }
                        $blogPage.='
                        <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                            <div class="team-item position-relative">
                                <div class="position-relative">
                                    <img  width="100%" height="260px"src="'.$blog->small_image.'" alt="">
                                    <div class="team-social text-center">
                                        <a style="width: 150px;" class="btn btn-square btn-outline-primary border-2 m-15" href="'.$blogRoute.'" >Devamını oku</a>
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
        $section=Section::findOrFail($section_id);
        $newsPage='
        <div class="container-xxl py-6">
            <div class="container">
                <div class="text-center mx-auto mb-5 wow fadeInUp" data-wow-delay="0.1s" style="max-width: 500px;">
                    <h1 class="display-6 mb-4">'.$section->section_name.'</h1>
                </div>
                <div class="row g-0 team-items">';
                    foreach ($news as $key => $news){
                        $newsRoute=$news->link;
                        if ($news->link == null) {
                            $newsRoute = route('news-detay', ['id' => $news->id]);
                        }
                        $newsPage.='
                        <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                            <div class="team-item position-relative">
                                <div class="position-relative">
                                    <img class="img-fluid" src="'.$news->görsel.'" alt="">
                                    <div class="team-social text-center">
                                        <a style="width: 150px;" class="btn btn-square btn-outline-primary border-2 m-15" href="'.$newsRoute.'" >Devamını oku</a>
                                    </div>
                                </div>
                                <div class="bg-light text-center p-4">
                                    <h5 class="mt-2">'.$news->baslik.'</h5>
                                    <span>'.$news->kisaaciklama.'</span>
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
