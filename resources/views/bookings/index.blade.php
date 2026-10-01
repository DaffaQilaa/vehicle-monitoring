<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Daftar Pemesanan Kendaraan') }}
            </h2>
            <<!-- Tombol Tambah Pemesanan -->
            <a href="{{ route('bookings.create') }}" style="background-color: #2563eb;" class="text-white font-bold py-2 px-4 rounded text-sm hover:opacity-90">
                + Tambah Pemesanan
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead>
                        <tr class="bg-gray-50">
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Kode</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Kendaraan</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Pengemudi</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status Approval</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status Akhir</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($bookings as $b)
                            <tr>
                                <td class="px-6 py-4 font-bold">{{ $b->booking_code }}</td>
                                <td class="px-6 py-4">{{ $b->vehicle->name }} ({{ $b->vehicle->license_plate }})</td>
                                <td class="px-6 py-4">{{ $b->driver->name }}</td>
                                <td class="px-6 py-4 text-sm">{{ $b->start_date }} - {{ $b->end_date }}</td>
                                <td class="px-6 py-4 text-sm">
                                    @foreach($b->approvals as $app)
                                        <div>
                                            L{{ $app->level }} ({{ $app->approver->name }}): 
                                            <!-- Status Approval dalam tabel -->
                                        <span class="font-semibold uppercase" style="color: {{ $app->status === 'approved' ? '#16a34a' : ($app->status === 'rejected' ? '#dc2626' : '#d97706') }};">
                                            {{ $app->status }}
                                        </span>
                                        </div>
                                    @endforeach
                                </td>
                                <td class="px-6 py-4">
                                   <!-- Status Akhir Badge -->
                                <span class="px-2 py-1 text-xs rounded text-white font-bold uppercase" style="background-color: {{ $b->status === 'approved' ? '#16a34a' : ($b->status === 'rejected' ? '#dc2626' : '#d97706') }};">
                                    {{ $b->status }}
                                </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-4 text-center text-gray-500">Belum ada data pemesanan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>