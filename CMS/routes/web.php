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

    Route::resource('iletisimform', iletisimFormController::class);

    Route::resource('iletisimformalanları', iletisimFormAlanController::class);

    Route::delete('/iletisimformalan/destroy/{id}', [App\Http\Controllers\iletisimFormController::class, 'alanDestroy'])->name('iletisimform.alanDestroy');

    Route::post('/iletisimform/{id}/addFormAlan', [App\Http\Controllers\iletisimFormController::class, 'addFormAlan'])->name('iletisimform.addFormAlan');

    Route::resource('sss', SSSController::class);

    Route::get('sss/{id}/durum', [App\Http\Controllers\SSSController::class, 'durum'])->name('sss.durum');

    Route::resource('contact', ContactController::class);

    Route::post('contact/{id}/kullanımdurumu', [App\Http\Controllers\ContactController::class, 'kullanımdurumu'])->name('contact.kullanımdurumu');

    Route::resource('news', NewsController::class);

    Route::resource('blog', BlogController::class);

    Route::resource('about', AboutUsController::class);

    Route::post('about/{id}/kullanımdurumu', [App\Http\Controllers\AboutUsController::class, 'kullanımdurumu'])->name('about.kullanımdurumu');

    Route::resource('service', ServiceController::class);

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

    Route::get('/excele-aktar/{veri}', [IletisimFormKayitController::class, 'exceleAktar'])->name('excele-aktar');
    Route::get('/pdf-aktar/{veri}', [IletisimFormKayitController::class, 'pdfeAktar'])->name('pdf-aktar');

    Route::resource('admin', AdminController::class);

    Route::post('admin/{id}/changePassword', [AdminController::class, 'changePassword'])->name('admin.changePassword');

    Route::resource('homepage', HomePageSettingController::class);

    Route::post('homepage/{id}/status', [App\Http\Controllers\HomePageSettingController::class, 'status'])->name('homepage.status');

    Route::post('homepage/{id}/otherpage', [App\Http\Controllers\HomePageSettingController::class, 'otherpage'])->name('homepage.otherpage');

    Route::match(['post', 'patch'], 'homepage/{id}/menu', [App\Http\Controllers\HomePageSettingController::class, 'menü'])->name('homepage.menü');

    Route::post('section/{section_id}/status', [App\Http\Controllers\SectionController::class, 'status'])->name('section.status');

    Route::get('/get-module-content/{moduleId}', [App\Http\Controllers\SectionController::class, 'getModuleContent']);

    Route::post('/update-section-order', [App\Http\Controllers\SectionController::class, 'updateOrder'])->name('update-section-order');

    Route::get('logout', [LoginController::class, 'signOut'])->name('login.signout');

});

Route::get('/haber-detay/{id}', [UiLayerController::class, 'newsDetails'])->name('news-detay');

Route::get('/blog-detay/{id}', [UiLayerController::class, 'blogDetails'])->name('blog-detay');

Route::resource('login', LoginController::class);

Route::get('/', [UiLayerController::class, 'index'])->name('site.index');

Route::get('/{slug}', [UiLayerController::class, 'show'])->name('page.show');
