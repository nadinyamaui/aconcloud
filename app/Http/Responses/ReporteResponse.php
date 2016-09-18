<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 27-03-2015
 * Time: 08:13 AM
 */

namespace App\Http\Responses;

use Barryvdh\Snappy\PdfWrapper;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

class ReporteResponse
{
    public $excel;

    /**
     * @var PdfWrapper
     */
    public $pdf;

    public function __construct(Application $app)
    {
        $this->excel = $app->make('excel');
        $this->pdf = $app->make('snappy.pdf.wrapper');
    }

    public function create(Request $request, $vista, $data)
    {
        if ($request->get('formato') == "pdf") {
            return $this->generarPDF($vista, $data);
        } elseif ($request->get('formato') == "xls") {
            return $this->generarExcel($vista, $data);
        }
    }

    private function generarPDF($vista, $data, $orientacion = 'portrait', $options = [])
    {
        $html = view($vista, $data)->render();
        $snappy = $this->pdf->loadHTML($html);
        $snappy->setOrientation($orientacion);
        $snappy->setPaper('letter');
        if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
            $snappy->setOption('zoom', 1.15);
        } else {
            $snappy->setOption('zoom', 0.8);
        }
        foreach ($options as $key => $option) {
            $snappy->setOption($key, $option);
        }
        return $snappy->inline($data['nombre_reporte'].'.pdf');
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