<?php
/**
 * Check Available Time Slots for TODAY
 */

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\DB;

echo "===========================================\n";
echo "  AVAILABLE TIME SLOTS FOR TODAY\n";
echo "===========================================\n\n";

// Get today's date and day name
$today = date('Y-m-d');
$dayName = date('l'); // Monday, Tuesday, etc.

echo "📅 Today: " . date('l, F j, Y') . "\n";
echo "📅 Date: $today\n\n";

// Get all time slots for today's day
$slots = DB::table('staff_global_hours')
    ->join('admin_global_days', 'admin_global_days.id', '=', 'staff_global_hours.global_day_id')
    ->where('staff_global_hours.vendor_id', 0)
    ->where('admin_global_days.day', $dayName)
    ->select(
        'staff_global_hours.id',
        'staff_global_hours.start_time',
        'staff_global_hours.end_time',
        'staff_global_hours.max_booking'
    )
    ->orderBy('staff_global_hours.start_time')
    ->get();

if ($slots->isEmpty()) {
    echo "❌ NO TIME SLOTS configured for $dayName\n";
    echo "   Please add time slots for this day.\n\n";
    exit;
}

echo "⏰ CONFIGURED TIME SLOTS FOR $dayName:\n";
echo "-------------------------------------------\n";

foreach ($slots as $slot) {
    // Check existing bookings for this slot today
    $bookings = DB::table('service_bookings')
        ->where('service_hour_id', $slot->id)
        ->where('booking_date', $today)
        ->where('order_status', '!=', 'rejected')
        ->count();
    
    $available = $slot->max_booking - $bookings;
    $status = $available > 0 ? '✅ AVAILABLE' : '❌ FULLY BOOKED';
    
    $startTime = date('h:i A', strtotime($slot->start_time));
    $endTime = date('h:i A', strtotime($slot->end_time));
    
    echo sprintf(
        "%-8s - %-8s | Booked: %d/%d | Available: %d | %s\n",
        $startTime,
        $endTime,
        $bookings,
        $slot->max_booking,
        $available,
        $status
    );
}

// Summary
$totalSlots = $slots->count();
$totalBookings = DB::table('service_bookings')
    ->whereIn('service_hour_id', $slots->pluck('id'))
    ->where('booking_date', $today)
    ->where('order_status', '!=', 'rejected')
    ->count();

$totalCapacity = $slots->sum('max_booking');
$totalAvailable = $totalCapacity - $totalBookings;

echo "\n📊 SUMMARY:\n";
echo "-------------------------------------------\n";
echo "Total Time Slots: $totalSlots\n";
echo "Total Capacity: $totalCapacity spots\n";
echo "Current Bookings: $totalBookings\n";
echo "Available Spots: $totalAvailable\n\n";

// Show only available slots
$availableSlots = $slots->filter(function($slot) use ($today) {
    $bookings = DB::table('service_bookings')
        ->where('service_hour_id', $slot->id)
        ->where('booking_date', $today)
        ->where('order_status', '!=', 'rejected')
        ->count();
    return $bookings < $slot->max_booking;
});

if ($availableSlots->isEmpty()) {
    echo "⚠️  ALL SLOTS ARE FULLY BOOKED FOR TODAY!\n";
    echo "   No more bookings can be accepted.\n\n";
} else {
    echo "✅ AVAILABLE SLOTS (Ready to Book):\n";
    echo "-------------------------------------------\n";
    foreach ($availableSlots as $slot) {
        $startTime = date('h:i A', strtotime($slot->start_time));
        $endTime = date('h:i A', strtotime($slot->end_time));
        echo "   $startTime - $endTime\n";
    }
    echo "\n";
}

echo "===========================================\n";
echo "Check complete!\n";
echo "===========================================\n";

