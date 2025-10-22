<?php
/**
 * Script to check and fix time slots configuration
 * Run: php check_and_fix_timeslots.php
 */

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\DB;

echo "===========================================\n";
echo "  TIME SLOTS DIAGNOSTIC & FIX SCRIPT\n";
echo "===========================================\n\n";

// 1. Check current status
echo "📊 CURRENT STATUS:\n";
echo "-------------------------------------------\n";

$adminDaysCount = DB::table('admin_global_days')->count();
$staffDaysCount = DB::table('staff_global_days')->count();
$adminSlotsCount = DB::table('staff_global_hours')->where('vendor_id', 0)->count();
$vendorSlotsCount = DB::table('staff_global_hours')->where('vendor_id', '!=', 0)->count();

echo "Admin Days: $adminDaysCount\n";
echo "Staff Days: $staffDaysCount\n";
echo "Admin Time Slots (vendor_id=0): $adminSlotsCount\n";
echo "Vendor Time Slots: $vendorSlotsCount\n\n";

// 2. Check which days have admin slots
echo "📅 ADMIN TIME SLOTS BY DAY:\n";
echo "-------------------------------------------\n";

$daySlots = DB::table('staff_global_hours')
    ->join('admin_global_days', 'admin_global_days.id', '=', 'staff_global_hours.global_day_id')
    ->where('staff_global_hours.vendor_id', 0)
    ->select('admin_global_days.day', DB::raw('COUNT(*) as slot_count'), 
             DB::raw('MIN(staff_global_hours.start_time) as first_slot'),
             DB::raw('MAX(staff_global_hours.end_time) as last_slot'))
    ->groupBy('admin_global_days.day')
    ->get();

$daysOfWeek = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
$missingDays = [];

foreach ($daysOfWeek as $day) {
    $found = false;
    foreach ($daySlots as $slot) {
        if ($slot->day === $day) {
            echo "✅ $day: {$slot->slot_count} slots ({$slot->first_slot} - {$slot->last_slot})\n";
            $found = true;
            break;
        }
    }
    if (!$found) {
        echo "❌ $day: NO SLOTS\n";
        $missingDays[] = $day;
    }
}

echo "\n";

// 3. Diagnosis
echo "🔍 DIAGNOSIS:\n";
echo "-------------------------------------------\n";

if ($adminDaysCount === 0) {
    echo "❌ CRITICAL: admin_global_days table is empty!\n";
    echo "   Action: Need to add days first.\n\n";
} elseif (count($missingDays) > 0) {
    echo "⚠️  WARNING: Missing time slots for: " . implode(', ', $missingDays) . "\n";
    echo "   Action: Need to add time slots for these days.\n\n";
} else {
    echo "✅ All days have time slots configured!\n\n";
}

// 4. Check a sample service
echo "🔧 SAMPLE SERVICE CHECK:\n";
echo "-------------------------------------------\n";

$sampleService = DB::table('services')->first();
if ($sampleService) {
    echo "Service ID: {$sampleService->id}\n";
    echo "Vendor ID: {$sampleService->vendor_id}\n";
    
    if ($sampleService->vendor_id == 0) {
        echo "Type: Admin Service\n";
        echo "Should use: admin_global_days + staff_global_hours (vendor_id=0)\n";
    } else {
        echo "Type: Vendor Service\n";
        echo "Should use: staff_global_days + staff_global_hours (vendor_id={$sampleService->vendor_id})\n";
        
        $vendorSlots = DB::table('staff_global_hours')
            ->where('vendor_id', $sampleService->vendor_id)
            ->count();
        echo "Time slots for this vendor: $vendorSlots\n";
    }
}

echo "\n";

// 5. Offer to fix
if (count($missingDays) > 0 || $adminSlotsCount < 10) {
    echo "🛠️  FIX AVAILABLE:\n";
    echo "-------------------------------------------\n";
    echo "Would you like to add time slots for missing days? (y/n): ";
    
    $handle = fopen("php://stdin", "r");
    $line = fgets($handle);
    fclose($handle);
    
    if (trim(strtolower($line)) === 'y') {
        echo "\n⏳ Adding time slots...\n\n";
        
        // Ensure all days exist in admin_global_days
        foreach ($daysOfWeek as $day) {
            $exists = DB::table('admin_global_days')->where('day', $day)->exists();
            if (!$exists) {
                DB::table('admin_global_days')->insert([
                    'day' => $day,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
                echo "✅ Added day: $day\n";
            }
        }
        
        // Add time slots for missing days
        $timeSlots = [
            ['start' => '09:00:00', 'end' => '10:00:00'],
            ['start' => '10:00:00', 'end' => '11:00:00'],
            ['start' => '11:00:00', 'end' => '12:00:00'],
            ['start' => '14:00:00', 'end' => '15:00:00'],
            ['start' => '15:00:00', 'end' => '16:00:00'],
            ['start' => '16:00:00', 'end' => '17:00:00'],
        ];
        
        foreach ($missingDays as $day) {
            $dayId = DB::table('admin_global_days')->where('day', $day)->value('id');
            
            foreach ($timeSlots as $slot) {
                DB::table('staff_global_hours')->insert([
                    'vendor_id' => 0,
                    'global_day_id' => $dayId,
                    'start_time' => $slot['start'],
                    'end_time' => $slot['end'],
                    'max_booking' => 5,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            }
            
            echo "✅ Added 6 time slots for $day\n";
        }
        
        echo "\n✅ TIME SLOTS ADDED SUCCESSFULLY!\n\n";
        echo "📝 Next Steps:\n";
        echo "1. Clear your browser cache or use incognito mode\n";
        echo "2. Go to your booking page\n";
        echo "3. Click 'Book Now' on any service\n";
        echo "4. Select a date\n";
        echo "5. You should now see time slots!\n\n";
    }
} else {
    echo "✅ TIME SLOTS ARE PROPERLY CONFIGURED!\n\n";
    echo "If you're still seeing 'No Time Slot Found', check:\n";
    echo "1. Is the service vendor_id matching the time slots?\n";
    echo "2. Are all slots fully booked?\n";
    echo "3. Check browser console for JavaScript errors\n";
    echo "4. Clear browser cache\n\n";
}

echo "===========================================\n";
echo "Script completed!\n";
echo "===========================================\n";

