<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Logo;
use App\Models\Contact;
use App\Models\Page;
use App\Models\Section;
use App\Models\Menu;
use App\Models\MenuItem;
use App\Models\Menu_Alan;
use App\Models\IletisimForm;
use App\Models\SSS;


class PageController extends Controller
{
   
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $pages=Page::all();
        return view('Page.index',compact('pages'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('Page.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $validatedData = $request->validate([
            'title'=>'required|string|max:50',
            'url' => 'required|regex:/^\/[^ıİğĞüÜşŞöÖçÇ]+$/|unique:pages,slug|max:255',
            'meta_title'=>'required|string|max:60',
            'meta_description'=>'required|string|max:200',
            'meta_keywords'=>'required|string|max:200',
        ]);
        $yayin=1;
       // dd($request);
        try {
            Page::create([
                'title' => $request->title,
                'content' => $request->content,
                'slug' => $request->url,
                'meta_title' => $request->meta_title,
                'meta_description' => $request->meta_description,
                'meta_keywords' => $request->meta_keywords,
                'yayin_durumu'=>$yayin,
            ]);
            // Sayfa başlığını alın
            $pageTitle = $request->input('title');
    
            // Dosya adını oluşturun
            $fileName = str_replace(' ', '', $pageTitle) . '.blade.php';
    
            // Kalıp içeriğini alın
            $stub = File::get(resource_path('stubs/page.stub'));
    
            // {{ title }} ifadesini sayfa başlığıyla değiştirin
            $stub = str_replace('{{ title }}', $pageTitle, $stub);
    
            // Dosyayı kaydedin
            $filePath = resource_path('views/UiLayer/Pages/' . $fileName);
            File::put($filePath, $stub);

            return redirect()->route('page.index')->with('success', 'Sayfa oluşturma işlemi başarılı.');
        } catch (\Throwable $th) {
            //dd($th);
            return redirect()->route('page.index')->with('warning', 'Sayfa oluşturma işleminde bir hata oluştu.');
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
        $page=Page::find($id);
        if ($page) {
            return view('Page.edit',compact('page'));
        }else {
            return redirect()->route('page.index')->with('error', 'Düzenlenecek sayfa bulunamadı.');
        }

        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $page=Page::find($id);
        $oldURL=$page->slug;
        $validatedData = $request->validate([
            'title'=>'required|string|max:50',
            'url' => 'required|regex:/^\/[^ıİğĞüÜşŞöÖçÇ]+$/|unique:pages,slug,' . $page->sayfa_id . ',sayfa_id',
            'meta_title'=>'required|string|max:60',
            'meta_description'=>'required|string|max:200',
            'meta_keywords'=>'required|string|max:200',
        ],[
            'url.regex' => 'URL bilgisi / ile başlamalıdır, ve türkçe karakter içermemelidir.',
        ]);
        try {
            $page->title = $request->input('title');
            $page->slug = $request->input('url');
            $page->meta_title = $request->input('meta_title');
            $page->meta_description= $request->input('meta_description');
            $page->meta_keywords = $request->input('meta_keywords');
            $menu=Menu::where('MenuLink',$oldURL)->update(['MenuLink'=>$request->url]);
            $menu=MenuItem::where('ItemLink',$oldURL)->update(['ItemLink'=>$request->url]);
            // Sayfayı kaydet

                // Eski dosyanın adını alın
            $oldFileName = str_replace(' ', '', $page->getOriginal('title')) . '.blade.php';

                // Yeni dosyanın adını oluşturun
            $newFileName = str_replace(' ', '', $page->title) . '.blade.php';

            // Eski dosyanın yolu
            $oldFilePath = resource_path('views/UiLayer/Pages/' . $oldFileName);

            // Yeni dosyanın yolu
            $newFilePath = resource_path('views/UiLayer/Pages/' . $newFileName);

            if (File::exists($oldFilePath)) {
                // Eski dosyayı silin
                File::delete($oldFilePath);

                // Yeni dosyayı oluşturun
                $stub = File::get(resource_path('stubs/page.stub'));
                $stub = str_replace('{{ title }}', $page->title, $stub);
                File::put($newFilePath, $stub);
                $page->save(); 
                return redirect()->route('page.index')->with('success', 'Sayfa bilgileri başarıyla güncellendi.');
            }
        } catch (\Throwable $th) {
            dd($th);
            return redirect()->route('page.index')->with('warning', 'Sayfa bilgilerini güncelleme işleminde bir hata oluştu lütfen tekar deneyin.');  
        }

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $page=Page::where('sayfa_id',$id)->first();
        try {
            Section::where('sayfa_id',$page->sayfa_id)->delete();

            SSS::where('sayfa_id',$page->sayfa_id)->delete();

            $pageTitle =$page->title; // Burada silinen sayfanın başlığını alın, örneğin: $page->title;

            // Silinecek dosyanın adını oluşturun
            $fileName = str_replace(' ', '', $pageTitle) . '.blade.php';

            // Dosyayı silin
            $filePath = resource_path('views/UiLayer/Pages/' . $fileName);
            if (File::exists($filePath)) {
                File::delete($filePath);
            }
            $page->delete();
            return redirect()->route('page.index')->with('success', 'Sayfa silme işlemi başarılı.');
        } catch (\Throwable $th) {
            throw $th;
            return redirect()->route('page.index')->with('warning', 'Sayfa silme işleminde bir hata oluştu.');
        }
    }
    public function yayindurumu(string $id)
    {
        //
        $page=Page::find($id);
        $kullanımdurumu=$page->yayin_durumu;
        try {
            if($kullanımdurumu==0){
                $page->yayin_durumu = 1;
            }else {
                if($page->AnaSayfa==0)
                    $page->yayin_durumu=0;
                else
                    return redirect()->Route('page.index')->with('warning','Geçerli Anasayfa olarak kullanılan sayfayı yayından kaldıramazsınız  !!!');
            }
            $page->Save();
            return redirect()->Route('page.index');
        } catch (\Throwable $th) {
            //throw $th;
            return redirect()->Route('page.index')->with('warning','Sistemsel bir hata oluştu lütfen tekrar deneyiniz.');
        }
    }
    public function anasayfa(string $id)
    {
        try {
            Page::where('AnaSayfa',1)->Update(['AnaSayfa'=>0]);
            $page=Page::find($id);
            $page->AnaSayfa = 1;
            $page->Save();
            return redirect()->Route('page.index');
        } catch (\Throwable $th) {
            //throw $th;
            return redirect()->Route('page.index')->with('warning','Sistemsel bir hata oluştu lütfen tekrar deneyiniz.');
        }
    }
    public function uploadImage(Request $request)
    {
        $image = $request->file('file');
        $imageName = time() . '_' . $image->getClientOriginalName();
        Storage::disk('public')->putFileAs('site', $image, $imageName);

        $imagePath = asset('storage/site/' . $imageName);

        return response()->json(['location' => asset($imagePath)]);
    }
}
