<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contact;
use App\Models\Logo;
use App\Models\Menu_Alan;
use App\Models\E_Bülten;
use App\Models\IletisimForm;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendMail;


class E_BultenController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $bultens=E_Bülten::all();
        $toplamAbone=E_Bülten::all()->count();
        $aktifAbone=E_Bülten::where('status',1)->count();
        $pasifAbone=E_Bülten::where('status',0)->count();
        return view('E_Bulten.index',compact('bultens','toplamAbone','aktifAbone','pasifAbone'));
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
        $validatedData = $request->validate([
            'mail'=>'required|email|unique:e-bulten,mail'
        ]);
        $data=$request->only(['mail']);
        try {
            E_Bülten::create($data);
            return back()->with('success', 'E-Bülten aboneliğiniz başarıyla gerçekleştirildi!')->withInput();
        } catch (\Throwable $th) {
            return $this->redirectToOriginalPageWithWarning('E-Bülten abonelik işleminizde bir hata meydana geldi! Lütfen tekrar deneyiniz.');
        }
    }

    protected function redirectToOriginalPageWithWarning($message) {
        $previousUrl = URL::previous();
        $query = parse_url($previousUrl, PHP_URL_QUERY);
        $url = $query ? $previousUrl . '&warning=' . urlencode($message) : $previousUrl . '?warning=' . urlencode($message);
        
        return new RedirectResponse($url);
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
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        try {
            $abone=E_Bülten::findOrFail($id);
            if ($abone->status==1) {
                $abone->status=0;
                $abone->save();
            }else {
                $abone->status=1;
                $abone->save();
            }
            return redirect()->route('bulten.index');
        } catch (\Throwable $th) {
            return redirect()->route('bulten.index')->with('warning','İşlem Gerçekleşmedi lütfen tekrar deneyiniz');
        }    
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $abone=E_Bülten::findOrFail($id);
        try {
            $abone->delete();
            return redirect()->route('bulten.index')->with('success', 'E Bülten abonesi başarıyla silindi.');
        } catch (\Throwable $th) {
            //throw $th;
            return redirect()->route('bulten.index')->with('warning', 'E Bülten abonesi silme işleminde bir hata oluştu');
        }
    }
    public function sendMail(Request $request, $id)
    {
        $admin = auth()->user();
        $subject = $request->input('subject');
        $messageBody = $request->input('message'); // Formdaki mesaj alanı
        $senderEmail = $request->input('mail'); // Gönderen e-posta adresi (değiştirilmesi gereken kısım)
        $recipientEmail = $admin->email; // Alıcı e-posta adresi
        
        Mail::send('Mail.mail', ['subject' => $subject, 'messageBody' => $messageBody], function ($message) use ($recipientEmail, $subject) {
            $message->to($recipientEmail)
                ->subject($subject)
                ->from('sender@example.com'); // Gönderen e-posta adresi (değiştirilmesi gereken kısım)
        });
        
        return back()->with('success', 'Mail gönderildi.');
    }
}
