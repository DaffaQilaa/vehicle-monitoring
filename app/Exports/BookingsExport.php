<?php

namespace App\Exports;

use App\Models\Booking;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class BookingsExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        return Booking::with(['vehicle', 'driver', 'user'])->latest()->get();
    }

    public function headings(): array
    {
        return [
            'Kode Pemesanan',
            'Pemesan (Admin)',
            'Kendaraan',
            'Pengemudi',
            'Tanggal Mulai',
            'Tanggal Selesai',
            'Tujuan',
            'Status Akhir',
        ];
    }

    public function map($booking): array
    {
        return [
            $booking->booking_code,
            $booking->user->name,
            $booking->vehicle->name . ' (' . $booking->vehicle->license_plate . ')',
            $booking->driver->name,
            $booking->start_date,
            $booking->end_date,
            $booking->purpose,
            strtoupper($booking->status),
        ];
    }
}