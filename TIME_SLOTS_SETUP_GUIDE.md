# Time Slots Setup Guide - Fix "No Time Slot Found" Error

## Problem
When you select a date in the booking calendar, you see **"No Time Slot Found"** and cannot proceed to the next step.

## Root Cause
The system needs **Global Time Slots** to be configured in the admin panel. These time slots define when services are available for booking.

## Solution: Configure Time Slots in Admin Panel

### Step 1: Access Admin Panel
1. Log in to your admin panel
2. Navigate to the appropriate section based on your service type:

### Step 2: Configure Global Time Slots

#### Option A: For Admin Services (vendor_id = 0)
If the service belongs to the admin (not a vendor):

1. Go to: **Admin Panel → Staff Management → Global Time Slots**
2. Or: **Settings → Working Hours → Admin Global Days**

#### Option B: For Vendor Services
If the service belongs to a vendor:

1. Go to: **Vendor Panel → Staff Management → Global Time Slots**
2. Or: **Settings → Working Hours**

### Step 3: Add Time Slots for Each Day

You need to add time slots for each day of the week:

**Example Configuration:**

| Day       | Start Time | End Time | Max Bookings |
|-----------|------------|----------|--------------|
| Monday    | 09:00 AM   | 10:00 AM | 5            |
| Monday    | 10:00 AM   | 11:00 AM | 5            |
| Monday    | 11:00 AM   | 12:00 PM | 5            |
| Monday    | 02:00 PM   | 03:00 PM | 5            |
| Monday    | 03:00 PM   | 04:00 PM | 5            |
| Tuesday   | 09:00 AM   | 10:00 AM | 5            |
| Tuesday   | 10:00 AM   | 11:00 AM | 5            |
| ... (continue for all days)

**Important Fields:**
- **Day**: Select the day of the week (Monday, Tuesday, etc.)
- **Start Time**: When the slot starts (e.g., 09:00 AM)
- **End Time**: When the slot ends (e.g., 10:00 AM)
- **Max Bookings**: How many customers can book this slot (e.g., 5)

### Step 4: Verify Database Tables

The system uses these database tables:

#### For Vendor Services:
- **staff_global_days** - Stores day names (Monday, Tuesday, etc.)
- **staff_global_hours** - Stores time slots with vendor_id

#### For Admin Services:
- **admin_global_days** - Stores day names for admin
- **staff_global_hours** - Stores time slots with vendor_id = 0

### Step 5: Quick Database Check

Run this SQL query to check if you have time slots:

```sql
-- Check vendor time slots
SELECT sgd.day, sgh.start_time, sgh.end_time, sgh.max_booking, sgh.vendor_id
FROM staff_global_hours sgh
JOIN staff_global_days sgd ON sgd.id = sgh.global_day_id
ORDER BY sgd.day, sgh.start_time;

-- Check admin time slots
SELECT agd.day, sgh.start_time, sgh.end_time, sgh.max_booking
FROM staff_global_hours sgh
JOIN admin_global_days agd ON agd.id = sgh.global_day_id
WHERE sgh.vendor_id = 0
ORDER BY agd.day, sgh.start_time;
```

If these queries return **0 rows**, you need to add time slots through the admin panel.

## How the System Works

### 1. Date Selection
When you select a date (e.g., October 15, 2025 - which is a Wednesday):

### 2. Backend Process
```
User selects date → JavaScript detects day name (Wednesday)
                  ↓
AJAX call to: /services/show-general-hour/{serviceId}
                  ↓
Controller queries database for Wednesday time slots
                  ↓
Filters out fully booked slots
                  ↓
Returns available time slots
```

### 3. Controller Logic (Fixed)
```php
// Line 1225-1229: Get vendor time slots
$globalTimeSlots = StaffGlobalHour::join('staff_global_days', ...)
    ->where('staff_global_hours.vendor_id', $vendor_id)
    ->where('staff_global_days.day', 'Wednesday')  // Day name from request
    ->get();

// Line 1232-1237: If vendor_id = 0, try admin time slots
if ($globalTimeSlots->isEmpty() && $vendor_id == 0) {
    $globalTimeSlots = StaffGlobalHour::join('admin_global_days', ...)
        ->where('admin_global_days.day', 'Wednesday')  // FIXED: was staff_global_days
        ->get();
}

// Line 1241-1250: Filter out fully booked slots
foreach ($globalTimeSlots as $slot) {
    $bookedCount = count bookings for this slot on selected date;
    if ($bookedCount < $slot->max_booking) {
        $availableSlots[] = $slot;  // This slot is available
    }
}
```

### 4. Display Results
- If `$availableSlots` is empty → Shows "No Time Slot Found"
- If `$availableSlots` has items → Shows clickable time slots

## Troubleshooting Steps

### Issue 1: "No Time Slot Found" for all dates

**Diagnosis:**
```sql
-- Check if ANY time slots exist
SELECT COUNT(*) FROM staff_global_hours;
```

**Solution:**
- If count = 0: Add time slots through admin panel
- If count > 0: Check if they match the correct vendor_id

### Issue 2: Time slots exist but still not showing

**Check 1: Verify vendor_id**
```sql
-- Find the service's vendor_id
SELECT id, vendor_id FROM services WHERE id = YOUR_SERVICE_ID;

-- Check if time slots exist for this vendor
SELECT COUNT(*) FROM staff_global_hours WHERE vendor_id = YOUR_VENDOR_ID;
```

**Check 2: Verify day names match**
```sql
-- Check what day names are in the database
SELECT DISTINCT day FROM staff_global_days;
-- Should return: Monday, Tuesday, Wednesday, Thursday, Friday, Saturday, Sunday
```

**Check 3: Check for typos in day names**
The JavaScript sends day names like: "Monday", "Tuesday", etc.
Database must have EXACT same spelling (case-sensitive).

### Issue 3: Some days work, others don't

**Solution:** Add time slots for the missing days.

Example: If Monday works but Tuesday doesn't, you need to add Tuesday time slots.

### Issue 4: All slots show as booked

**Check bookings:**
```sql
SELECT booking_date, COUNT(*) as booking_count
FROM service_bookings
WHERE service_hour_id IN (
    SELECT id FROM staff_global_hours WHERE vendor_id = YOUR_VENDOR_ID
)
GROUP BY booking_date
ORDER BY booking_date DESC;
```

**Solution:** 
- Increase `max_booking` value in time slots
- Or cancel/reject old bookings

## Quick Fix: Add Sample Time Slots via SQL

If you can't access the admin panel, run this SQL to add sample time slots:

```sql
-- For Admin Services (vendor_id = 0)
-- First, ensure admin_global_days exist
INSERT INTO admin_global_days (day, created_at, updated_at) VALUES
('Monday', NOW(), NOW()),
('Tuesday', NOW(), NOW()),
('Wednesday', NOW(), NOW()),
('Thursday', NOW(), NOW()),
('Friday', NOW(), NOW()),
('Saturday', NOW(), NOW()),
('Sunday', NOW(), NOW())
ON DUPLICATE KEY UPDATE day=day;

-- Add time slots for Monday (repeat for other days)
INSERT INTO staff_global_hours (vendor_id, global_day_id, start_time, end_time, max_booking, created_at, updated_at)
SELECT 0, id, '09:00:00', '10:00:00', 5, NOW(), NOW() FROM admin_global_days WHERE day = 'Monday'
UNION ALL
SELECT 0, id, '10:00:00', '11:00:00', 5, NOW(), NOW() FROM admin_global_days WHERE day = 'Monday'
UNION ALL
SELECT 0, id, '11:00:00', '12:00:00', 5, NOW(), NOW() FROM admin_global_days WHERE day = 'Monday'
UNION ALL
SELECT 0, id, '14:00:00', '15:00:00', 5, NOW(), NOW() FROM admin_global_days WHERE day = 'Monday'
UNION ALL
SELECT 0, id, '15:00:00', '16:00:00', 5, NOW(), NOW() FROM admin_global_days WHERE day = 'Monday';

-- Repeat for other days...
```

## Testing After Setup

1. **Clear browser cache** or use incognito mode
2. Click "Book Now" on a service
3. Select any date
4. You should now see time slots like:
   ```
   Available Time Slots
   
   [09:00 AM - 10:00 AM]  [10:00 AM - 11:00 AM]  [11:00 AM - 12:00 PM]
   [02:00 PM - 03:00 PM]  [03:00 PM - 04:00 PM]  [04:00 PM - 05:00 PM]
   ```
5. Click a time slot → it should highlight
6. "Next Step" button should appear
7. Click "Next Step" → should move to billing form

## Additional Notes

### Time Format
- Use 24-hour format in database: `09:00:00`, `14:00:00`
- Display will show 12-hour format: `09:00 AM`, `02:00 PM`

### Max Bookings
- Set to 1 for exclusive appointments
- Set to 5-10 for group services
- Set to 100+ for events/webinars

### Working Days
- Only add time slots for days you're available
- Don't add slots for holidays (use holiday management instead)
- Weekend days can have different hours

## Bug Fixed in This Update

**File:** `app/Http/Controllers/FrontEnd/Services/ServiceController.php`
**Line:** 1234
**Issue:** When checking admin time slots, it was using wrong table reference
**Fixed:** Changed `staff_global_days.day` to `admin_global_days.day`

This bug prevented admin services from loading time slots correctly.

---

**After following this guide, your booking system should show time slots properly!**





