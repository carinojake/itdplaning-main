<?php

namespace App\Http\Controllers;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ContractExport;
use App\Imports\ContractImports;

use App\Models\User;
use App\Libraries\Helper;
use App\Models\Contract;
use App\Models\Project;
use App\Models\ContractHasTask;
use Illuminate\Http\Request;
use App\Models\Task;
use Vinkla\Hashids\Facades\Hashids;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;


class WordexcelController extends Controller
{
    public function index() {
        return view('app.export.index');
    }

    public function exportMSWord() {
        // Creating the new document...
        $phpWord = new \PhpOffice\PhpWord\PhpWord();

        // Remove Compat title bar
        $phpWord->getCompatibility()->setOoxmlVersion(15);

        // Set default font
        $phpWord->setDefaultFontName('TH Sarabun New');
        $phpWord->setDefaultFontSize(14);

        // Add empty section
        $section = $phpWord->addSection();

        // Add footer
        $footer = $section->addFooter();
        // $footer->addText( now() , null, ['align' => 'right'] );
        $footer->addPreserveText('หน้า {PAGE} / {NUMPAGES}', ['name' => 'TH Sarabun New', 'size' => 12 ], ['align' => 'right']);

        // Add Image
        $section->addImage(asset('images/logo.png'), [
            'width' => 100,
            'height' => 100,
            'marginTop' => 0,
            'marginLeft' => 0,
            'wrappingStyle' => 'behind',
            'alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER
        ]);

        // Add Text
        $section->addText('สวัสดี MS Word');

        // Add Text
        $section->addText('ยินดีต้อนรับ', ['name' => 'Tahoma', 'size' => 40, 'bold' => true, 'color' => 'red'], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);

        // Save to public path
        // $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
        // $objWriter->save('helloWorld.docx');

        // return response()->download(public_path('helloWorld.docx'));

        // Add Table
        $section2 = $phpWord->addSection();
        $tableStyle = [
            'borderSize' => 1,
            'borderColor' => 'black'
        ];
        $phpWord->addTableStyle('myTable', $tableStyle);
        $table = $section2->addTable('myTable');
        // Add Row (Header)
        $table->addRow(null, [ 'tblHeader' => true ] );
        $cellStyle = ['valign' => 'center'];
        $cellHeaderStyle = ['name' => 'TH Sarabun New', 'size' => 16, 'bold' => true];
        $table->addCell(1000, $cellStyle)->addText('ID', $cellHeaderStyle, ['align' => 'center']);
        $table->addCell(2000, $cellStyle)->addText('CODE', $cellHeaderStyle, ['align' => 'center']);
        $table->addCell(7000, $cellStyle)->addText('Hospital Name', $cellHeaderStyle, ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);

        // Get Data from DB
        $hospitals = Hospital::all(); //select * from hospitals
        foreach ($hospitals as $h) {
            $table->addRow();
            $table->addCell(1000, $cellStyle)->addText(htmlspecialchars($h->id), null, ['align' => 'center', 'spaceAfter' => 0]);
            $table->addCell(2000, $cellStyle)->addText(htmlspecialchars($h->code), null, ['align' => 'center', 'spaceAfter' => 0]);
            $table->addCell(7000, $cellStyle)->addText(htmlspecialchars($h->h_name), null, ['align' => 'left', 'spaceAfter' => 0]);
        }


        //auto download
        $fileName = \Illuminate\Support\Str::uuid() . '.docx';
        header("Content-Description: File Transfer");
        header('Content-Disposition: attachment; filename="' . $fileName . '"');
        header('Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document');
        header('Content-Transfer-Encoding: binary');
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Expires: 0');
        $xmlWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
        return $xmlWriter->save("php://output");
    }



    public function exportExcelCSV() {
        // return Excel::download(new HospitalsExport, now()->format('d-m-Y-H-i-s') . '.xlsx');
        return Excel::download(new ContractExport, now()->format('d-m-Y-H-i-s')
        . '.csv', \Maatwebsite\Excel\Excel::CSV);
    }

    public function importExcelCSV()
    {
        Excel::import(new HospitalsImport, 'hospital.xlsx'); // from storage/app
        return redirect('/');
    }

    public function genChart() {

        $users = User::select(DB::raw(" COUNT(*) as count"), DB::raw("MONTHNAME(created_at) as month_name"))
            ->whereYear('created_at', date('Y'))
            ->groupBy(DB::raw("month_name"))
            ->pluck('count', 'month_name');

        $labels = $users->keys();
        $data = $users->values();

        // return $users;

        return view('chart', [
            'labels' => $labels,
            'data' => $data
        ] );
    }
}
