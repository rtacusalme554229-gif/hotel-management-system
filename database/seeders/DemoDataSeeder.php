<?php

namespace Database\Seeders;

use App\Models\Guest;
use App\Models\Payment;
use App\Models\Reservation;
use App\Models\Room;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

class DemoDataSeeder extends Seeder
{
    public function run(): void
    {
        /*
        |--------------------------------------------------------------------------
        | USERS
        |--------------------------------------------------------------------------
        */

        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@stayease.test',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'status' => 'active',
        ]);

        $staff = User::create([
            'name' => 'Front Desk Staff',
            'email' => 'staff@stayease.test',
            'password' => Hash::make('password'),
            'role' => 'staff',
            'status' => 'active',
        ]);

        $inactiveStaff = User::create([
            'name' => 'Inactive Staff',
            'email' => 'inactive.staff@stayease.test',
            'password' => Hash::make('password'),
            'role' => 'staff',
            'status' => 'inactive',
        ]);

        $guestUser1 = User::create([
            'name' => 'Maria Santos',
            'email' => 'guest1@stayease.test',
            'password' => Hash::make('password'),
            'role' => 'guest',
            'status' => 'active',
        ]);

        $guestUser2 = User::create([
            'name' => 'Juan Dela Cruz',
            'email' => 'guest2@stayease.test',
            'password' => Hash::make('password'),
            'role' => 'guest',
            'status' => 'active',
        ]);

        $guestUser3 = User::create([
            'name' => 'Andrea Reyes',
            'email' => 'guest3@stayease.test',
            'password' => Hash::make('password'),
            'role' => 'guest',
            'status' => 'active',
        ]);

        $guestUser4 = User::create([
            'name' => 'Miguel Garcia',
            'email' => 'guest4@stayease.test',
            'password' => Hash::make('password'),
            'role' => 'guest',
            'status' => 'active',
        ]);

        $guestUser5 = User::create([
            'name' => 'Sofia Lim',
            'email' => 'guest5@stayease.test',
            'password' => Hash::make('password'),
            'role' => 'guest',
            'status' => 'active',
        ]);

        /*
        |--------------------------------------------------------------------------
        | GUEST PROFILES
        |--------------------------------------------------------------------------
        */

        $guest1 = Guest::create([
            'user_id' => $guestUser1->id,
            'phone_number' => '09171234567',
            'address' => 'Davao City, Philippines',
        ]);

        $guest2 = Guest::create([
            'user_id' => $guestUser2->id,
            'phone_number' => '09181234567',
            'address' => 'Tagum City, Philippines',
        ]);

        $guest3 = Guest::create([
            'user_id' => $guestUser3->id,
            'phone_number' => '09191234567',
            'address' => 'General Santos City, Philippines',
        ]);

        $guest4 = Guest::create([
            'user_id' => $guestUser4->id,
            'phone_number' => '09201234567',
            'address' => 'Panabo City, Philippines',
        ]);

        $guest5 = Guest::create([
            'user_id' => $guestUser5->id,
            'phone_number' => '09211234567',
            'address' => 'Digos City, Philippines',
        ]);

        /*
        |--------------------------------------------------------------------------
        | ROOMS
        |--------------------------------------------------------------------------
        */

        $room101 = Room::create([
            'room_no' => '101',
            'room_type' => 'Standard Room',
            'floor' => '1st Floor',
            'price' => 2500,
            'status' => 'available',
            'image' => null,
        ]);

        $room102 = Room::create([
            'room_no' => '102',
            'room_type' => 'Deluxe Room',
            'floor' => '1st Floor',
            'price' => 3500,
            'status' => 'reserved',
            'image' => null,
        ]);

        $room201 = Room::create([
            'room_no' => '201',
            'room_type' => 'Family Suite',
            'floor' => '2nd Floor',
            'price' => 5000,
            'status' => 'occupied',
            'image' => null,
        ]);

        $room202 = Room::create([
            'room_no' => '202',
            'room_type' => 'Executive Suite',
            'floor' => '2nd Floor',
            'price' => 6500,
            'status' => 'reserved',
            'image' => null,
        ]);

        $room301 = Room::create([
            'room_no' => '301',
            'room_type' => 'Premium Suite',
            'floor' => '3rd Floor',
            'price' => 8000,
            'status' => 'available',
            'image' => null,
        ]);

        $room302 = Room::create([
            'room_no' => '302',
            'room_type' => 'Standard Room',
            'floor' => '3rd Floor',
            'price' => 2500,
            'status' => 'available',
            'image' => null,
        ]);

        $room401 = Room::create([
            'room_no' => '401',
            'room_type' => 'Deluxe Room',
            'floor' => '4th Floor',
            'price' => 3800,
            'status' => 'available',
            'image' => null,
        ]);

        $room402 = Room::create([
            'room_no' => '402',
            'room_type' => 'Presidential Suite',
            'floor' => '4th Floor',
            'price' => 12000,
            'status' => 'available',
            'image' => null,
        ]);

        /*
        |--------------------------------------------------------------------------
        | RESERVATIONS
        |--------------------------------------------------------------------------
        */

        $today = Carbon::now('Asia/Manila');

        // Pending reservation
        $reservation1 = Reservation::create([
            'guest_id' => $guest1->id,
            'room_id' => $room101->id,
            'reservation_date' => $today->toDateString(),
            'check_in_date' => $today->copy()->addDays(2)->toDateString(),
            'check_out_date' => $today->copy()->addDays(4)->toDateString(),
            'number_of_guests' => 2,
            'special_requests' => 'Near elevator if possible.',
            'total_amount' => 5000,
            'status' => 'pending',
            'checked_in_at' => null,
            'checked_out_at' => null,
        ]);

        // Accepted / reserved reservation
        $reservation2 = Reservation::create([
            'guest_id' => $guest2->id,
            'room_id' => $room102->id,
            'reservation_date' => $today->copy()->subDays(1)->toDateString(),
            'check_in_date' => $today->copy()->addDays(5)->toDateString(),
            'check_out_date' => $today->copy()->addDays(7)->toDateString(),
            'number_of_guests' => 2,
            'special_requests' => 'Extra pillows.',
            'total_amount' => 7000,
            'status' => 'accepted',
            'checked_in_at' => null,
            'checked_out_at' => null,
        ]);

        // Checked-in / occupied reservation
        $reservation3 = Reservation::create([
            'guest_id' => $guest3->id,
            'room_id' => $room201->id,
            'reservation_date' => $today->copy()->subDays(3)->toDateString(),
            'check_in_date' => $today->copy()->subDay()->toDateString(),
            'check_out_date' => $today->copy()->addDay()->toDateString(),
            'number_of_guests' => 4,
            'special_requests' => 'Family with children.',
            'total_amount' => 10000,
            'status' => 'checked_in',
            'checked_in_at' => $today->copy()->subDay()->setTime(14, 30),
            'checked_out_at' => null,
        ]);

        // Checked-out reservation
        $reservation4 = Reservation::create([
            'guest_id' => $guest4->id,
            'room_id' => $room301->id,
            'reservation_date' => $today->copy()->subDays(8)->toDateString(),
            'check_in_date' => $today->copy()->subDays(5)->toDateString(),
            'check_out_date' => $today->copy()->subDays(3)->toDateString(),
            'number_of_guests' => 2,
            'special_requests' => 'Late arrival.',
            'total_amount' => 16000,
            'status' => 'checked_out',
            'checked_in_at' => $today->copy()->subDays(5)->setTime(15, 10),
            'checked_out_at' => $today->copy()->subDays(3)->setTime(10, 45),
        ]);

        // Declined reservation
        $reservation5 = Reservation::create([
            'guest_id' => $guest5->id,
            'room_id' => $room302->id,
            'reservation_date' => $today->copy()->subDays(2)->toDateString(),
            'check_in_date' => $today->copy()->addDays(10)->toDateString(),
            'check_out_date' => $today->copy()->addDays(12)->toDateString(),
            'number_of_guests' => 1,
            'special_requests' => 'Quiet room.',
            'total_amount' => 5000,
            'status' => 'declined',
            'checked_in_at' => null,
            'checked_out_at' => null,
        ]);

        // Another accepted reservation on a later date for same room example
        $reservation6 = Reservation::create([
            'guest_id' => $guest1->id,
            'room_id' => $room202->id,
            'reservation_date' => $today->copy()->subDays(1)->toDateString(),
            'check_in_date' => $today->copy()->addMonth()->toDateString(),
            'check_out_date' => $today->copy()->addMonth()->addDays(3)->toDateString(),
            'number_of_guests' => 3,
            'special_requests' => 'High floor preferred.',
            'total_amount' => 19500,
            'status' => 'accepted',
            'checked_in_at' => null,
            'checked_out_at' => null,
        ]);

        /*
        |--------------------------------------------------------------------------
        | PAYMENTS
        |--------------------------------------------------------------------------
        */

        $this->createPayment($reservation2, $guest2, 'GCash');
        $this->createPayment($reservation3, $guest3, 'Cash');
        $this->createPayment($reservation4, $guest4, 'Credit Card');
        $this->createPayment($reservation6, $guest1, 'Bank Transfer');
    }

    /*
    |--------------------------------------------------------------------------
    | Flexible payment creator
    |--------------------------------------------------------------------------
    | This avoids errors if your payments table has extra/different columns.
    |--------------------------------------------------------------------------
    */
    private function createPayment(Reservation $reservation, Guest $guest, string $method): void
    {
        $paymentData = [
            'reservation_id' => $reservation->id,
            'amount' => $reservation->total_amount,
            'created_at' => now(),
            'updated_at' => now(),
        ];

        if (Schema::hasColumn('payments', 'guest_id')) {
            $paymentData['guest_id'] = $guest->id;
        }

        if (Schema::hasColumn('payments', 'user_id')) {
            $paymentData['user_id'] = $guest->user_id;
        }

        if (Schema::hasColumn('payments', 'payment_method')) {
            $paymentData['payment_method'] = $method;
        }

        if (Schema::hasColumn('payments', 'method')) {
            $paymentData['method'] = $method;
        }

        if (Schema::hasColumn('payments', 'payment_status')) {
            $paymentData['payment_status'] = 'paid';
        }

        if (Schema::hasColumn('payments', 'status')) {
            $paymentData['status'] = 'paid';
        }

        if (Schema::hasColumn('payments', 'payment_date')) {
            $paymentData['payment_date'] = now()->toDateString();
        }

        Payment::create($paymentData);
    }
}