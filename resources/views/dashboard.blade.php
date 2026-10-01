<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Dashboard Pemantauan Kendaraan') }}
            </h2>
            <a href="{{ route('reports.export') }}" style="background-color: #16a34a;" class="text-white font-bold py-2 px-4 rounded text-sm flex items-center space-x-1 hover:opacity-90">
                <span>Ekspor Laporan (Excel)</span>
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <!-- Ringkasan Kartu -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-white p-6 rounded-lg shadow border-l-4 border-blue-500">
                    <div class="text-sm font-semibold text-gray-500 uppercase">Total Pemesanan</div>
                    <div class="text-3xl font-bold text-gray-800">{{ $totalBookings }}</div>
                </div>
                <div class="bg-white p-6 rounded-lg shadow border-l-4 border-green-500">
                    <div class="text-sm font-semibold text-gray-500 uppercase">Disetujui (Approved)</div>
                    <div class="text-3xl font-bold text-gray-800">{{ $approvedBookings }}</div>
                </div>
                <div class="bg-white p-6 rounded-lg shadow border-l-4 border-yellow-500">
                    <div class="text-sm font-semibold text-gray-500 uppercase">Menunggu (Pending)</div>
                    <div class="text-3xl font-bold text-gray-800">{{ $pendingBookings }}</div>
                </div>
            </div>

            <!-- Area Grafik -->
            <div class="bg-white p-6 rounded-lg shadow">
                <h3 class="text-lg font-bold text-gray-800 mb-4">Grafik Pemakaian Kendaraan Operasional</h3>
                <div class="w-full h-80">
                    <canvas id="vehicleChart"></canvas>
                </div>
            </div>

            <!-- Log Aktivitas Terkini (Poin Bonus) -->
            <div class="bg-white p-6 rounded-lg shadow">
                <h3 class="text-lg font-bold text-gray-800 mb-4">Riwayat Log Aktivitas Sistem</h3>
                <div class="space-y-3">
                    @forelse($logs as $log)
                        <div class="flex justify-between items-center text-sm border-b pb-2">
                            <div>
                                <span class="font-bold text-gray-700">{{ $log->user->name ?? 'System' }}</span>: 
                                <span class="text-gray-600">{{ $log->description }}</span>
                            </div>
                            <span class="text-xs text-gray-400">{{ $log->created_at->diffForHumans() }}</span>
                        </div>
                    @empty
                        <p class="text-gray-500 text-sm">Belum ada catatan log aktivitas.</p>
                    @endforelse
                </div>
            </div>

        </div>
    </div>

    <!-- Pustaka Chart.js CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('vehicleChart').getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: {!! json_encode($chartLabels) !!},
                datasets: [{
                    label: 'Frekuensi Pemakaian (Disetujui)',
                    data: {!! json_encode($chartData) !!},
                    backgroundColor: 'rgba(54, 162, 235, 0.6)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: { stepSize: 1 }
                    }
                }
            }
        });
    </script>
</x-app-layout>