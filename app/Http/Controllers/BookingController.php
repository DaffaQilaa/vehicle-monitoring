<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\BookingApproval;
use App\Models\Vehicle;
use App\Models\Driver;
use App\Models\User;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    public function index()
    {
        $bookings = Booking::with(['vehicle', 'driver', 'approvals.approver'])->latest()->get();
        return view('bookings.index', compact('bookings'));
    }

    public function create()
    {
        $vehicles = Vehicle::where('status', 'available')->get();
        $drivers = Driver::where('status', 'available')->get();
        $approvers = User::whereHas('role', function($q) {
            $q->where('name', 'Approver');
        })->get();

        return view('bookings.create', compact('vehicles', 'drivers', 'approvers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'vehicle_id' => 'required|exists:vehicles,id',
            'driver_id' => 'required|exists:drivers,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'purpose' => 'required|string',
            'approver_1_id' => 'required|exists:users,id',
            'approver_2_id' => 'required|exists:users,id|different:approver_1_id',
        ]);

        DB::transaction(function () use ($request) {
            $booking = Booking::create([
                'booking_code' => 'BOOK-' . strtoupper(uniqid()),
                'user_id' => Auth::id(),
                'vehicle_id' => $request->vehicle_id,
                'driver_id' => $request->driver_id,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'purpose' => $request->purpose,
                'status' => 'pending',
            ]);

            // Approval Level 1
            BookingApproval::create([
                'booking_id' => $booking->id,
                'approver_id' => $request->approver_1_id,
                'level' => 1,
                'status' => 'pending',
            ]);

            // Approval Level 2
            BookingApproval::create([
                'booking_id' => $booking->id,
                'approver_id' => $request->approver_2_id,
                'level' => 2,
                'status' => 'pending',
            ]);

            // Log Aktivitas
            ActivityLog::create([
                'user_id' => Auth::id(),
                'action' => 'CREATE_BOOKING',
                'description' => "Admin " . Auth::user()->name . " membuat pemesanan " . $booking->booking_code,
            ]);
        });

        return redirect()->route('bookings.index')->with('success', 'Pemesanan kendaraan berhasil diajukan!');
    }
}