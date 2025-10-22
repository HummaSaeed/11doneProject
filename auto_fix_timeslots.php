<?php
/**
 * Automatic Time Slots Fix Script
 * This will add missing time slots and fix any issues
 */

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\DB;

echo "===========================================\n";
echo "  AUTOMATIC TIME SLOTS FIX\n";
echo "===========================================\n\n";

$daysOfWeek = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];

// Standard time slots (9 AM to 5 PM with lunch break)
$standardSlots = [
    ['start' => '09:00:00', 'end' => '10:00:00'],
    ['start' => '10:00:00', 'end' => '11:00:00'],
    ['start' => '11:00:00', 'end' => '12:00:00'],
    ['start' => '14:00:00', 'end' => '15:00:00'],
    ['start' => '15:00:00', 'end' => '16:00:00'],
    ['start' => '16:00:00', 'end' => '17:00:00'],
];

echo "Step 1: Ensuring all days exist...\n";
foreach ($daysOfWeek as $day) {
    $exists = DB::table('admin_global_days')->where('day', $day)->exists();
    if (!$exists) {
        DB::table('admin_global_days')->insert([
            'day' => $day,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        echo "  ✅ Added day: $day\n";
    } else {
        echo "  ✓ Day exists: $day\n";
    }
}

echo "\nStep 2: Adding time slots for all days...\n";
$totalAdded = 0;

foreach ($daysOfWeek as $day) {
    $dayId = DB::table('admin_global_days')->where('day', $day)->value('id');
    
    // Check how many slots this day already has
    $existingCount = DB::table('staff_global_hours')
        ->where('vendor_id', 0)
        ->where('global_day_id', $dayId)
        ->count();
    
    if ($existingCount < 6) {
        echo "  📅 $day: ";
        
        // Add missing slots
        foreach ($standardSlots as $slot) {
            // Check if this specific slot already exists
            $slotExists = DB::table('staff_global_hours')
                ->where('vendor_id', 0)
                ->where('global_day_id', $dayId)
                ->where('start_time', $slot['start'])
                ->where('end_time', $slot['end'])
                ->exists();
            
            if (!$slotExists) {
                DB::table('staff_global_hours')->insert([
                    'vendor_id' => 0,
                    'global_day_id' => $dayId,
                    'start_time' => $slot['start'],
                    'end_time' => $slot['end'],
                    'max_booking' => 5,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
                $totalAdded++;
            }
        }
        
        $newCount = DB::table('staff_global_hours')
            ->where('vendor_id', 0)
            ->where('global_day_id', $dayId)
            ->count();
        
        echo "Now has $newCount slots ✅\n";
    } else {
        echo "  ✓ $day: Already has $existingCount slots\n";
    }
}

echo "\n===========================================\n";
echo "✅ FIX COMPLETED!\n";
echo "===========================================\n\n";

echo "📊 SUMMARY:\n";
echo "  • Time slots added: $totalAdded\n";

// Show final status
echo "\n📅 FINAL STATUS BY DAY:\n";
$finalStatus = DB::table('staff_global_hours')
    ->join('admin_global_days', 'admin_global_days.id', '=', 'staff_global_hours.global_day_id')
    ->where('staff_global_hours.vendor_id', 0)
    ->select('admin_global_days.day', DB::raw('COUNT(*) as slot_count'))
    ->groupBy('admin_global_days.day')
    ->orderByRaw("FIELD(admin_global_days.day, 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday')")
    ->get();

foreach ($finalStatus as $status) {
    echo "  ✅ {$status->day}: {$status->slot_count} slots\n";
}

echo "\n📝 NEXT STEPS:\n";
echo "  1. Clear your browser cache (Ctrl+Shift+Delete)\n";
echo "  2. Or open your site in Incognito/Private mode\n";
echo "  3. Go to your booking page\n";
echo "  4. Click 'Book Now' on any service\n";
echo "  5. Select any date\n";
echo "  6. You should now see time slots like:\n";
echo "     [09:00 AM - 10:00 AM] [10:00 AM - 11:00 AM] etc.\n";
echo "  7. Click a time slot\n";
echo "  8. 'Next Step' button will appear\n";
echo "  9. Click 'Next Step' to continue booking!\n\n";

echo "===========================================\n";
echo "All done! Your booking system is ready! 🎉\n";
echo "===========================================\n";

