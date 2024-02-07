<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\TransactionService;
use Dompdf\Dompdf;

class TransactionController extends Controller
{
    protected $service;

    public function __construct(TransactionService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        $transactions = $this->service->index();

        return view('admin.transactions.index', compact('transactions'));
    }

    public function view($uuid)
    {
        $html='';
        $transaction = $this->service->get($uuid);
        $css = @file_get_contents(base_path().'/public/vendor/laraberg/css/laraberg.css');
        $image = asset('/Super Tools.png');
        // Path to your external CSS file
        // $cssFilePath = public_path('vendor/laraberg/css/laraberg.css');
        // echo $image; exit;
        // return view('admin.transactions.view', compact('transaction'));
        $view = view('admin.transactions.view', compact('transaction','css','image'));
        $html .= $view->render();
        echo $html; exit;
        // Append link to external CSS file to HTML content
        // $view .= '<link rel="stylesheet" href="' . $cssFilePath . '">';

        // Instantiate Dompdf
        $dompdf = new Dompdf(['chroot' => __DIR__]);
        $dompdf->set_option('isHtml5ParserEnabled', true);
        $dompdf->set_option('isRemoteEnabled', true);  
        // Load HTML content
        $dompdf->loadHtml($html);

        // Set paper size and orientation (optional)
        $dompdf->setPaper('A4', 'portrait');

        // Render the HTML as PDF
        $dompdf->render();

        // Output the generated PDF (inline or download)
        return $dompdf->stream('generated_pdf.pdf');
    }
}
