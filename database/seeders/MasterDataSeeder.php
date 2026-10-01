<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use App\Models\Location;
use App\Models\Vehicle;
use App\Models\Driver;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class MasterDataSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Seed Roles
        $adminRole = Role::create(['name' => 'Admin']);
        $approverRole = Role::create(['name' => 'Approver']);

        // 2. Seed Users
        User::create([
            'role_id' => $adminRole->id,
            'name' => 'Admin Pool',
            'email' => 'admin@sekawan.com',
            'password' => Hash::make('password123'),
        ]);

        User::create([
            'role_id' => $approverRole->id,
            'name' => 'Manager Operasional (Approver 1)',
            'email' => 'approver1@sekawan.com',
            'password' => Hash::make('password123'),
        ]);

        User::create([
            'role_id' => $approverRole->id,
            'name' => 'Kepala Wilayah (Approver 2)',
            'email' => 'approver2@sekawan.com',
            'password' => Hash::make('password123'),
        ]);

        // 3. Seed Locations (1 Pusat, 1 Cabang, 6 Tambang)
        $locPusat = Location::create(['name' => 'Kantor Pusat - Jakarta', 'type' => 'pusat']);
        $locCabang = Location::create(['name' => 'Kantor Cabang - Surabaya', 'type' => 'cabang']);
        
        for ($i = 1; $i <= 6; $i++) {
            Location::create([
                'name' => "Lokasi Tambang $i - Halmahera",
                'type' => 'tambang',
            ]);
        }

        // 4. Seed Drivers
        Driver::create(['name' => 'Budi Santoso', 'phone' => '081234567890', 'status' => 'available']);
        Driver::create(['name' => 'Joko Widodo', 'phone' => '081234567891', 'status' => 'available']);
        Driver::create(['name' => 'Siti Rahma', 'phone' => '081234567892', 'status' => 'available']);

        // 5. Seed Vehicles (Milik sendiri & Sewa, Angkutan orang & Barang)
        Vehicle::create([
            'location_id' => $locPusat->id,
            'name' => 'Toyota Hilux Double Cabin',
            'license_plate' => 'B 9101 SKW',
            'type' => 'angkutan_barang',
            'ownership' => 'milik_sendiri',
            'fuel_consumption' => 10.5,
            'last_service_date' => now()->subMonth(),
            'next_service_date' => now()->addMonths(2),
            'status' => 'available',
        ]);

        Vehicle::create([
            'location_id' => $locCabang->id,
            'name' => 'Toyota HiAce Commuter',
            'license_plate' => 'L 7002 SKW',
            'type' => 'angkutan_orang',
            'ownership' => 'sewa',
            'fuel_consumption' => 8.2,
            'last_service_date' => now()->subWeeks(2),
            'next_service_date' => now()->addMonths(3),
            'status' => 'available',
        ]);

        Vehicle::create([
            'location_id' => $locPusat->id,
            'name' => 'Dump Truck Hino 500',
            'license_plate' => 'B 8833 SKW',
            'type' => 'angkutan_barang',
            'ownership' => 'milik_sendiri',
            'fuel_consumption' => 25.0,
            'last_service_date' => now()->subMonths(3),
            'next_service_date' => now()->addDays(10),
            'status' => 'available',
        ]);
    }
}