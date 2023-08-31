<?php

namespace App\Http\Controllers;
use App\Models\Blog;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $blogs=Blog::all();
        return view('Blog.index',compact('blogs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('Blog.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        //dd($request);
        $validatedData = $request->validate([
            'title' => 'required|string|max:25',
            'short_description' => 'required|string|max:150',
            'date' => 'required|date',
            'link' => $request->input('linkType') === 'harici' ? 'required' : '',
            'small_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        if ($request->input('linkType') === 'siteIci') {
            $validatedData = $request->validate([
                'content' => 'required|string',
            ]);
        }
        try {
            if ($request->hasFile('small_image')) {
                $file = $request->file('small_image');
                $fileName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME); // Dosya adını al
                $extension = $file->getClientOriginalExtension(); // Uzantıyı al
                $fileNameWithExtension = $request->title . '-Görsel-1.' . $extension; //  adını ve uzantısını birleştir
                $filePath = $file->storeAs('Blog', $fileNameWithExtension, 'public'); // "public" diskini kullanarak  klasöre kaydet
            } else {
                return redirect()->back()->with('warning', 'Görsel dosyası seçilmedi.');
            }
            if ($request->hasFile('large_image')) {
                $file = $request->file('large_image');
                $fileName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME); // Dosya adını al
                $extension = $file->getClientOriginalExtension(); // Uzantıyı al
                $fileNameWithExtension2 = $request->title . '-Görsel-2.' . $extension; //  adını ve uzantısını birleştir
                $filePath = $file->storeAs('Blog', $fileNameWithExtension2, 'public'); // "public" diskini kullanarak  klasöre  kaydet
                $fileNameWithExtension2='/storage/blog/'. $fileNameWithExtension2;
            } else {
                $fileNameWithExtension2 = ''; 
            }
            if($request->input('linkType') === 'harici'){
                $content='';
            }else {
                $content=$request->content;
            }
            Blog::create([
                'title' => $request->title,
                'short_description' => $request->short_description,
                'long_description' => $content,
                'date' => $request->date,
                'link' => $request->link,
                'small_image' => '/storage/blog/' . $fileNameWithExtension, // Dikkat! Sadece klasör ve dosya adını veriyoruz, public klasörünü dahil etmiyoruz
                'large_image'=>$fileNameWithExtension2,
            ]);
            return redirect()->route('blog.index')->with('success', 'Blog ekleme işlemi başarılı.');
        } catch (\Throwable $th) {
            dd($th);
           return view('Blog.create')->with('warning', 'Blog ekleme işleminde bir hata oluştu.');
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
        $blog=Blog::findOrfail($id);
        return view('Blog.edit',compact('blog'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        try {
            $validatedData = $request->validate([
                'title' => 'required|string|max:25',
                'short_description' => 'required|string|max:150',
                'date' => 'required|date',
                'link' => $request->input('linkType') === 'harici' ? 'required' : '',
                'small_image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);
            if ($request->input('linkType') === 'siteIci') {
                $validatedData = $request->validate([
                    'content' => 'required|string',
                ]);
            }
    
            $blog = Blog::findOrFail($id);
        
            // Eğer yeni görsel seçildiyse
            if ($request->hasFile('small_image')) {
                $görsel = $request->file('small_image');
                $eskiGörselYolu = storage_path('app/public/Blog/' . $blog->title.'-Görsel-1');
        
                // Eski görseli sil
                if (file_exists($eskiGörselYolu)) {
                    unlink($eskiGörselYolu);
                }
        
                // Yeni görseli kaydet
                $görselAdi = $blog->title . '-Görsel-1.' . $görsel->getClientOriginalExtension();
                $görsel->storeAs('public/blog', $görselAdi);
        
                // Veritabanındaki görsel adını güncelle
                $blog->small_image = '/storage/blog/' .$görselAdi;
            }
            if ($request->hasFile('large_image')) {
                $görsel = $request->file('large_image');
                $eskiGörselYolu = storage_path('app/public/blog/' . $blog->title.'-Görsel-2');
        
                // Eski görseli sil
                if (file_exists($eskiGörselYolu)) {
                    unlink($eskiGörselYolu);
                }
        
                // Yeni görseli kaydet
                $görselAdi = $blog->title . '-Görsel-2.' . $görsel->getClientOriginalExtension();
                $görsel->storeAs('public/blog', $görselAdi);
        
                // Veritabanındaki görsel adını güncelle
                $blog->large_image = '/storage/blog/' .$görselAdi;
            }
            
            // Diğer güncelleme işlemlerini gerçekleştirin
            $blog->title = $request->title;
            $blog->short_description = $request->short_description;
            $blog->long_description=$request->content;
            $blog->date=$request->date;
            $blog->link=$request->link;
            // Diğer alanları da güncelleyin
        
            // Veritabanında güncellemeyi kaydet
            $blog->save();
        
            return redirect()->route('blog.index')->with('success', 'Blog başarıyla güncellendi.');
        } catch (\Throwable $th) {
            return redirect()->route('blog.index')->with('warning', 'Blog güncelleme işleminde hata oluştu.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $blog=Blog::findOrFail($id);
        try {
            $blog->delete();
            return redirect()->route('blog.index')->with('success', 'Blog başarıyla silindi.');
        } catch (\Throwable $th) {
            dd($th);
            return redirect()->route('blog.index')->with('warning', 'Blog bulunamadı.');
        }
    }
}
