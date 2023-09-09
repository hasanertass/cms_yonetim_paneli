<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LogoController;
use App\Http\Controllers\MenuAlanController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\AltMenuController;
use App\Http\Controllers\SocialMediaIconController;
use App\Http\Controllers\MarkaController;
use App\Http\Controllers\iletisimFormController;
use App\Http\Controllers\iletisimFormAlanController;
use App\Http\Controllers\SSSController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\SectionController;
use App\Http\Controllers\ContentsController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\AboutUsController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\iletisim_uiController;
use App\Http\Controllers\E_BultenController;
use App\Http\Controllers\IletisimFormKayitController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\HomePageSettingController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\SettingsController;


use App\Http\Controllers\UiController\UiLayerController;
use App\Models\Page;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::post('/', function () {
    return view('deneme');
});

Route::middleware(['auth'])->group(function () {
    Route::resource('logo', LogoController::class);

    Route::post('logo/{logo}/activate',  [App\Http\Controllers\LogoController::class, 'activate'])->name('logo.activate');

    Route::resource('menu', MenuController::class);

    Route::post('/update-menu-order', [App\Http\Controllers\MenuController::class, 'updateOrder'])->name('update-menu-order');

    Route::resource('menualan', MenuAlanController::class);

    Route::resource('altmenu', AltMenuController::class);

    Route::post('/update-altmenu-order', [App\Http\Controllers\AltMenuController::class, 'updateOrder'])->name('update-altmenu-order');

    Route::resource('sosyalmedya', SocialMediaIconController::class);

    Route::resource('marka', MarkaController::class);

    Route::post('marka-status/{id}', [App\Http\Controllers\MarkaController::class, 'status'])->name('marka.status');

    Route::post('marka-home_page_status/{id}', [App\Http\Controllers\MarkaController::class, 'home_page_status'])->name('marka.home_page_status');

    Route::resource('iletisimform', iletisimFormController::class);

    Route::resource('iletisimformalanları', iletisimFormAlanController::class);

    Route::delete('/iletisimformalan/destroy/{id}', [App\Http\Controllers\iletisimFormController::class, 'alanDestroy'])->name('iletisimform.alanDestroy');

    Route::post('/iletisimform/{id}/addFormAlan', [App\Http\Controllers\iletisimFormController::class, 'addFormAlan'])->name('iletisimform.addFormAlan');

    Route::resource('sss', SSSController::class);

    Route::get('sss/{id}/durum', [App\Http\Controllers\SSSController::class, 'durum'])->name('sss.durum');

    Route::resource('contact', ContactController::class);

    Route::post('contact/{id}/kullanımdurumu', [App\Http\Controllers\ContactController::class, 'kullanımdurumu'])->name('contact.kullanımdurumu');

    Route::resource('news', NewsController::class);

    Route::post('news-status/{id}', [App\Http\Controllers\NewsController::class, 'status'])->name('news.status');

    Route::post('news-home_page_status/{id}', [App\Http\Controllers\NewsController::class, 'home_page_status'])->name('news.home_page_status');

    Route::resource('blog', BlogController::class);

    Route::post('blog-status/{id}', [App\Http\Controllers\BlogController::class, 'status'])->name('blog.status');

    Route::post('blog-home_page_status/{id}', [App\Http\Controllers\BlogController::class, 'home_page_status'])->name('blog.home_page_status');

    Route::resource('about', AboutUsController::class);

    Route::post('about/{id}/kullanımdurumu', [App\Http\Controllers\AboutUsController::class, 'kullanımdurumu'])->name('about.kullanımdurumu');

    Route::resource('service', ServiceController::class);

    Route::post('service-status/{id}', [App\Http\Controllers\ServiceController::class, 'status'])->name('service.status');

    Route::post('service-home_page_status/{id}', [App\Http\Controllers\ServiceController::class, 'home_page_status'])->name('service.home_page_status');

    Route::resource('iletisimsection', iletisim_uiController::class);

    Route::resource('page', PageController::class);

    Route::post('page/{sayfa_id}/yayindurumu', [App\Http\Controllers\PageController::class, 'yayindurumu'])->name('page.yayindurumu');

    Route::post('page/{sayfa_id}/anasayfa', [App\Http\Controllers\PageController::class, 'anasayfa'])->name('page.anasayfa');

    Route::post('page/upload-image', [PageController::class, 'uploadImage'])->name('upload.image');

    Route::resource('section', SectionController::class);

    Route::get('/get-section-content/{sectionId}', [App\Http\Controllers\SectionController::class, 'getSectionContent'])->name('section.setting');

    Route::patch('/get-section-update/{sectionId}', [App\Http\Controllers\SectionController::class, 'getSettingUpdate'])->name('setting.update');

    Route::resource('bulten', E_BultenController::class);

    Route::post('bulten/sendMail/{id}', [E_BultenController::class, 'sendMail'])->name('bulten.sendMail');

    Route::resource('forms', IletisimFormKayitController::class);

    Route::get('/excele-aktar/{veri}/{select?}', [IletisimFormKayitController::class, 'exceleAktar'])->name('excele-aktar');
    Route::get('/pdf-aktar/{veri}/{select?}', [IletisimFormKayitController::class, 'pdfeAktar'])->name('pdf-aktar');

    Route::resource('admin', AdminController::class);

    Route::post('admin/{id}/changePassword', [AdminController::class, 'changePassword'])->name('admin.changePassword');

    Route::resource('homepage', HomePageSettingController::class);

    Route::post('homepage/{id}/status', [App\Http\Controllers\HomePageSettingController::class, 'status'])->name('homepage.status');

    Route::post('homepage/{id}/otherpage', [App\Http\Controllers\HomePageSettingController::class, 'otherpage'])->name('homepage.otherpage');

    Route::get('head-settings', [App\Http\Controllers\SettingsController::class, 'head_index'])->name('head.index');
    
    Route::patch('public-settings/{id}', [App\Http\Controllers\SettingsController::class, 'public_update'])->name('public.update');

    Route::patch('head-settings/{id}', [App\Http\Controllers\SettingsController::class, 'head_update'])->name('head.update');

    Route::patch('footer-settings/{id}', [App\Http\Controllers\SettingsController::class, 'footer_update'])->name('footer.update');

    Route::post('section/{section_id}/status', [App\Http\Controllers\SectionController::class, 'status'])->name('section.status');

    Route::get('/get-module-content/{moduleId}', [App\Http\Controllers\SectionController::class, 'getModuleContent']);

    Route::post('/update-section-order', [App\Http\Controllers\SectionController::class, 'updateOrder'])->name('update-section-order');

    Route::get('logout', [LoginController::class, 'signOut'])->name('login.signout');
});

Route::get('/news-detail/{id}', [UiLayerController::class, 'newsDetails'])->name('news-detail');

Route::get('/blog-detail/{id}', [UiLayerController::class, 'blogDetails'])->name('blog-detail');

Route::get('/service-detail/{id}', [UiLayerController::class, 'serviceDetails'])->name('service-detail');

Route::resource('login', LoginController::class);

Route::get('/', [UiLayerController::class, 'index'])->name('site.index');

Route::get('/{slug}', [UiLayerController::class, 'show'])->name('page.show');
