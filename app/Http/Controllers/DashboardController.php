<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use App\Models\Booking;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Data Grafik: Jumlah pemesanan per kendaraan
        $vehicles = Vehicle::withCount(['bookings' => function($q) {
            $q->where('status', 'approved');
        }])->get();

        $chartLabels = $vehicles->pluck('name');
        $chartData = $vehicles->pluck('bookings_count');

        // Ringkasan Statistik
        $totalBookings = Booking::count();
        $approvedBookings = Booking::where('status', 'approved')->count();
        $pendingBookings = Booking::where('status', 'pending')->count();
        
        // Log Aktivitas Terbaru (Bonus Point)
        $logs = ActivityLog::with('user')->latest()->take(5)->get();

        return view('dashboard', compact(
            'chartLabels', 
            'chartData', 
            'totalBookings', 
            'approvedBookings', 
            'pendingBookings',
            'logs'
        ));
    }
}