<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Daftar Persetujuan Pemesanan Kendaraan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    {{ session('error') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead>
                        <tr class="bg-gray-50">
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Kode & Level</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Kendaraan & Driver</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tujuan</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status Saat Ini</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($approvals as $app)
                            <tr>
                                <td class="px-6 py-4">
                                    <div class="font-bold">{{ $app->booking->booking_code }}</div>
                                    <div class="text-xs text-blue-600 font-semibold">Level {{ $app->level }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    <div>{{ $app->booking->vehicle->name }}</div>
                                    <div class="text-xs text-gray-500">Driver: {{ $app->booking->driver->name }}</div>
                                </td>
                                <td class="px-6 py-4 text-sm">{{ $app->booking->purpose }}</td>
                                <!-- Ganti kolom status di tabel approvals -->
                                <td class="px-6 py-4">
                                    <span class="px-2 py-1 text-xs rounded text-white font-bold uppercase" style="background-color: {{ $app->status === 'approved' ? '#16a34a' : ($app->status === 'rejected' ? '#dc2626' : '#d97706') }};">
                                        {{ $app->status }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    @if($app->status === 'pending')
                                        <form action="{{ route('approvals.process', $app->id) }}" method="POST" class="space-y-2">
                                            @csrf
                                            <input type="text" name="notes" placeholder="Catatan (Opsional)" class="text-xs border-gray-300 rounded w-full mb-1">
                                            <div class="flex space-x-1">
                                                <button type="submit" name="status" value="approved" style="background-color: #16a34a;" class="text-white text-xs px-3 py-1 rounded font-bold hover:opacity-90">
                                                    Approve
                                                </button>
                                                <button type="submit" name="status" value="rejected" style="background-color: #dc2626;" class="text-white text-xs px-3 py-1 rounded font-bold hover:opacity-90">
                                                    Reject
                                                </button>
                                            </div>
                                        </form>
                                    @else
                                        <span class="text-xs text-gray-400">Selesai diproses</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-4 text-center text-gray-500">Belum ada tugas persetujuan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>