<?php

namespace Database\Seeders;

use App\Models\Booking;
use App\Models\Payment;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class PaymentsSeeder extends Seeder
{
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        Payment::query()->delete();
        Schema::enableForeignKeyConstraints();

        $bookings = Booking::query()->get();

        foreach ($bookings as $b) {
            $status = (random_int(1, 10) <= 8) ? 'paid' : 'pending';

            Payment::create([
                'booking_id' => $b->id,
                'payment_status' => $status,
                'paid_at' => $status === 'paid' ? now()->subDays(random_int(0, 14)) : null,
            ]);
        }
    }
}
