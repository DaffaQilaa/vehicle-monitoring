<?php

namespace App\Http\Controllers;

use App\Models\BookingApproval;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApprovalController extends Controller
{
    public function index()
    {
        $approvals = BookingApproval::with(['booking.vehicle', 'booking.driver', 'booking.user'])
            ->where('approver_id', Auth::id())
            ->latest()
            ->get();

        return view('approvals.index', compact('approvals'));
    }

    public function process(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:approved,rejected',
            'notes' => 'nullable|string',
        ]);

        $approval = BookingApproval::findOrFail($id);

        if ($approval->level == 2) {
            $level1 = BookingApproval::where('booking_id', $approval->booking_id)
                ->where('level', 1)
                ->first();

            if (!$level1 || $level1->status !== 'approved') {
                return back()->with('error', 'Persetujuan Level 1 belum selesai!');
            }
        }

        $approval->update([
            'status' => $request->status,
            'notes' => $request->notes,
            'approved_at' => now(),
        ]);

        $booking = $approval->booking;

        if ($request->status === 'rejected') {
            $booking->update(['status' => 'rejected']);
        } else {
            if ($approval->level == 2) {
                $booking->update(['status' => 'approved']);
            }
        }

        ActivityLog::create([
            'user_id' => Auth::id(),
            'action' => strtoupper($request->status) . "_LEVEL_" . $approval->level,
            'description' => "Approver " . Auth::user()->name . " memproses (" . $request->status . ") pemesanan " . $booking->booking_code,
        ]);

        return redirect()->route('approvals.index')->with('success', 'Status persetujuan berhasil diperbarui!');
    }
}