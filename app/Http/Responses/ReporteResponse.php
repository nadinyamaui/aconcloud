<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 27-03-2015
 * Time: 08:13 AM
 */

namespace App\Http\Responses;

use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use mPDF;

class ReporteResponse
{

    public $excel;
    public $pdf;

    public function __construct(Application $app)
    {
        $this->excel = $app->make('excel');
    }

    public function create(Request $request, $vista, $data)
    {
        if ($request->get('formato') == "pdf") {
            return $this->generarPDF($vista, $data);
        } else {
            if ($request->get('formato') == "xls") {
                return $this->generarExcel($vista, $data);
            }
        }
    }

    private function generarPDF($vista, $data, $orientacion = 'P')
    {
        $html = view($vista, $data)->render();
        $mpdf = new mPDF('',    // mode - default ''
            'Letter',    // format - A4, for example, default ''
            0,     // font size - default 0
            '',    // default font family
            15,    // margin_left
            15,    // margin right
            16,     // margin top
            16,    // margin bottom
            5,     // margin header
            5,     // margin footer
            $orientacion);
        $mpdf->useOnlyCoreFonts = true;
        $mpdf->SetTitle($data['nombre_reporte']);
        $mpdf->SetAuthor('Aconcloud');
        $mpdf->SetCreator('Aconcloud');
        $mpdf->SetDisplayMode('fullpage');
        $mpdf->WriteHTML($html);

        return $mpdf->Output($data['nombre_reporte'].'.pdf', 'I');
    }

    private function generarExcel($vista, $data)
    {
        return $this->excel->create($vista, function ($excel) use ($vista, $data) {
            $excel->sheet('Hoja 1', function ($sheet) use ($vista, $data) {
                $sheet->loadView($vista, $data);
            });
        })->download('xls');
    }
}