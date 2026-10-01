<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Input Pemesanan Kendaraan Baru') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <form action="{{ route('bookings.store') }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block font-medium text-sm text-gray-700">Pilih Kendaraan</label>
                        <select name="vehicle_id" class="w-full border-gray-300 rounded-md shadow-sm" required>
                            <option value="">-- Pilih Kendaraan --</option>
                            @foreach($vehicles as $v)
                                <option value="{{ $v->id }}">{{ $v->name }} [{{ $v->ownership }}] - {{ $v->license_plate }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block font-medium text-sm text-gray-700">Pilih Driver</label>
                        <select name="driver_id" class="w-full border-gray-300 rounded-md shadow-sm" required>
                            <option value="">-- Pilih Driver --</option>
                            @foreach($drivers as $d)
                                <option value="{{ $d->id }}">{{ $d->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block font-medium text-sm text-gray-700">Tanggal Mulai</label>
                            <input type="datetime-local" name="start_date" class="w-full border-gray-300 rounded-md shadow-sm" required>
                        </div>
                        <div>
                            <label class="block font-medium text-sm text-gray-700">Tanggal Selesai</label>
                            <input type="datetime-local" name="end_date" class="w-full border-gray-300 rounded-md shadow-sm" required>
                        </div>
                    </div>

                    <div>
                        <label class="block font-medium text-sm text-gray-700">Tujuan Pemakaian</label>
                        <textarea name="purpose" rows="3" class="w-full border-gray-300 rounded-md shadow-sm" required></textarea>
                    </div>

                    <div class="grid grid-cols-2 gap-4 border-t pt-4">
                        <div>
                            <label class="block font-medium text-sm text-gray-700">Pihak Menyetujui (Level 1)</label>
                            <select name="approver_1_id" class="w-full border-gray-300 rounded-md shadow-sm" required>
                                <option value="">-- Pilih Approver Level 1 --</option>
                                @foreach($approvers as $app)
                                    <option value="{{ $app->id }}">{{ $app->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block font-medium text-sm text-gray-700">Pihak Menyetujui (Level 2)</label>
                            <select name="approver_2_id" class="w-full border-gray-300 rounded-md shadow-sm" required>
                                <option value="">-- Pilih Approver Level 2 --</option>
                                @foreach($approvers as $app)
                                    <option value="{{ $app->id }}">{{ $app->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="flex justify-end space-x-2 pt-4">
                        <a href="{{ route('bookings.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded">Batal</a>
                        <button type="submit" style="background-color: #2563eb;" class="text-white font-bold px-4 py-2 rounded hover:opacity-90">
                            Kirim Pemesanan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>