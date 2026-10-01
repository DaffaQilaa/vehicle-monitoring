<?php

namespace App\Http\Controllers;

use App\Exports\BookingsExport;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{
    public function exportExcel()
    {
        return Excel::download(new BookingsExport, 'Laporan_Pemesanan_Kendaraan_' . date('Y-m-d') . '.xlsx');
    }
}