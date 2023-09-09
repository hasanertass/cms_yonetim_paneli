<?php

namespace App\Http\Controllers;

use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

use Dompdf\Dompdf;
use Dompdf\Options;
use Illuminate\Support\Facades\Response;

use App\Models\Contact;
use App\Models\Logo;
use App\Models\Menu_Alan;
use App\Models\IletisimForm;
use App\Models\İletisimFormAlan;
use App\Models\iletisim_ui;
use App\Models\IletisimFormKayit;


class IletisimFormKayitController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $forms=IletisimFormKayit::all();
        return view('İletisimFormKayit.index',compact('forms'));
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
        //dd($request);
        $formAlan=$request->FormId;
        $alanName=İletisimFormAlan::where('FormId',$formAlan)->get();
        $alanType=İletisimFormAlan::where('FormId',$formAlan)->where('AlanType','file')->First();
        //dd($alanType->AlanName);
        $dataToInsert = [];
        //dd($alanName);
        $column=1;
        foreach ($alanName as $alan) {
            if ($alan->AlanType == 'file') {
                $fieldName = $alan->AlanName;
                $file = $request->file($fieldName);
                $name=pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                if ($file) {
                    $extension = $file->getClientOriginalExtension();
                    $fileNameWithExtension =  $name. ' ' . $fieldName . '.' . $extension;
                    $filePath = $file->storeAs('public/Dosyalar', $fileNameWithExtension);
            
                    // Oluşturulan dosyanın URL'sini almak için depolama sürücüsünü kullanabilirsiniz
                    $publicPath = 'storage/Dosyalar/' . $fileNameWithExtension;
            
                    $dataToInsert['column' . $column] = $publicPath;
                    $request->merge([$alan->AlanName => $publicPath]);
                }
            }
            else {
                //dd($request->input($alan->AlanName));
                // Her alan için ilgili veriyi $dataToInsert dizisine ekleyin
                $dataToInsert['column'.$column] = $request->input($alan->AlanName);
            }
            $column+=1;
        }
        $dataToInsert['form_id'] = $formAlan;
        try {
            IletisimFormKayit::create($dataToInsert);
            return back()->with('success', 'İletişim formunu doldurduğunuz için teşekkür ederiz. En kısa sürede sizinle iletişime geçeceğiz.');
        } catch (\Throwable $th) {
            dd($th);
            return back()->with('warning', 'İletişim formunda bir hata oluştu lütfen tekrar deneyiniz.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $formName=IletisimForm::where('FormId',$id)->first();
        $formAlanları=İletisimFormAlan::where('FormId',$formName->FormId)->get();
        $forms=IletisimFormKayit::where('form_id',$id)->get();
        return view('İletisimFormKayit.index',compact('forms','formName','formAlanları'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        //$formName=IletisimForm::where('FormId',$id)->first();
        //$formAlanları=İletisimFormAlan::where('FormId',$formName->FormId)->get();
        $i=1;
        $forms=IletisimFormKayit::findOrFail($id);
        $formAlanları=İletisimFormAlan::where('FormId',$forms->form_id)->get();
        //dd($forms);
        return view('İletisimFormKayit.edit',compact('forms','formAlanları','i'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id){
        //
        //dd($request);
        $form=IletisimFormKayit::findOrFail($id);
        try {
            $status=0;
            if($request->status==1)
                $status=1;
            $form->status=$status;
            $form->save();
            return redirect()->route('forms.show', ['form' =>$request->id])->with('success', 'İletişim Formu başarıyla güncellendi!');
        } catch (\Throwable $th) {
            //throw $th;
            dd($th);
            return redirect()->route('forms.show', ['form' =>$request->id])->with('warning', 'İletişim Formu güncelleme işleminde bir hata oluştu lütfen tekrar deneyiniz.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id){
        //
        $formKayit=IletisimFormKayit::findOrFail($id);
        try {
            $formKayit->delete();
            return redirect()->route('forms.show', ['form' =>$formKayit->form_id ])->with('success', 'Form kaydı başarıyla silindi!');
        } catch (\Throwable $th) {
            dd($th);
            return redirect()->route('forms.show', ['form' =>$formKayit->form_id ])->with('warning', 'Form kaydı silme işleminde bir hata oluştu lütfen tekrar deneyiniz');

        }
    }
    
    public function exceleAktar(string $id,string $select) {
        $formAlanlar = İletisimFormAlan::where('FormId', $id)->get();
        $formName=IletisimForm::where('FormId',$id)->first();
        if($select=='all')
            $forms=IletisimFormKayit::where('form_id',$id)->get();
        else
            $forms=IletisimFormKayit::where('form_id',$id)->where('status',$select)->get();
        $data = []; // Verileri tutacak boş bir dizi oluşturun
    
        // Başlıkları diziye ekleyin
        $headers = $formAlanlar->pluck('AlanName')->toArray();
        $data[] = $headers;
    
        // Verileri diziye ekleyin
        foreach ($forms as $form) {
            $rowData = [];
    
            for ($i = 1; $i <= count($formAlanlar); $i++) {
                $columnKey = 'column' . $i;
                $rowData[] = $form->$columnKey;
            }
    
            $data[] = $rowData;
        }
    
        // Excel dosyasını oluştur ve verileri ekleyin
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
    
        // Verileri tablo olarak ekle
        $sheet->fromArray($data, null, 'A1');
    
        // Tabloyu biçimlendirin
        $highestColumn = $sheet->getHighestColumn();
        $highestRow = $sheet->getHighestRow();
        $tableRange = 'A1:' . $highestColumn . $highestRow;
    
        // Tabloyu biçimlendirme
        $styleArray = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['argb' => '000000'],
                ],
            ],
        ];
        $sheet->getStyle($tableRange)->applyFromArray($styleArray);

    
        // Excel dosyasını kaydet
        $dateTime = now()->format('d-m-Y_H-i-s');
        $excelFileName = $formName->FormName.'_Iletisim_Form_Verileri'. $dateTime . '.xlsx';
        $writer = new Xlsx($spreadsheet);
        $writer->save($excelFileName);
    
        // Dosyayı indir
        return response()->download($excelFileName)->deleteFileAfterSend(true);
    }
    
    public function pdfeAktar(string $id, string $select){
        $formName=IletisimForm::where('FormId',$id)->first();
        $formAlanları=İletisimFormAlan::where('FormId',$formName->FormId)->get();
        if($select=='all')
            $forms=IletisimFormKayit::where('form_id',$id)->get();
        else
            $forms=IletisimFormKayit::where('form_id',$id)->where('status',$select)->get();
        // return view('İletisimFormKayit.pdf_template',compact('formName','formAlanları','forms'));
        // PDF dönüştürme işlemi
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'DejaVu Sans');
        $pdfOptions->set('isHtml5ParserEnabled', true);
        $pdfOptions->set('isRemoteEnabled', true);
        $pdfOptions->set('isPhpEnabled', true);
        $pdfOptions->set('defaultFont', 'Arial');
    
        $pdf = new Dompdf($pdfOptions);
        $pdf->loadHtml(view('İletisimFormKayit.pdf_template', [
            'forms' => $forms,
            'formName' => $formName,
            'formAlanları' => $formAlanları,
        ])->render(), 'UTF-8');
        $pdf->setPaper('A4', 'landscape'); // Sayfa boyutu ve yönlendirmesini ayarlayın
        $pdf->render();
    
        // PDF dosyasını kaydet ve indir
        $dateTime = now()->format('d-m-Y_H-i-s');
        $pdfFileName = $formName->FormName.'_Iletisim_Formu_Verileri'.$dateTime.'.pdf';
        file_put_contents($pdfFileName, $pdf->output());
    
        return Response::download($pdfFileName);
    }
    

}
