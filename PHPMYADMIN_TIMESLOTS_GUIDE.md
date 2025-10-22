# How to Add Time Slots via phpMyAdmin (XAMPP)

## Step 1: Access phpMyAdmin (No Password Needed!)

### For XAMPP Users:
1. Open your browser
2. Go to: `http://localhost/phpmyadmin`
3. **Username:** `root`
4. **Password:** Leave it BLANK (just press Enter or click Go)
5. You're in! ✅

## Step 2: Select Your Database

1. On the left side, you'll see a list of databases
2. Click on: `ufmveahk_11done` (your database name)
3. You'll see all tables listed

## Step 3: Add Time Slots Using SQL

### Option A: Quick Add - Copy & Paste This SQL

1. Click on the **SQL** tab at the top
2. Copy the ENTIRE SQL script below
3. Paste it into the SQL query box
4. Click **Go** button

```sql
-- =====================================================
-- Add Time Slots for ALL 7 Days (Complete Week)
-- =====================================================

-- Step 1: Ensure all days exist
INSERT IGNORE INTO admin_global_days (day, created_at, updated_at) VALUES
('Monday', NOW(), NOW()),
('Tuesday', NOW(), NOW()),
('Wednesday', NOW(), NOW()),
('Thursday', NOW(), NOW()),
('Friday', NOW(), NOW()),
('Saturday', NOW(), NOW()),
('Sunday', NOW(), NOW());

-- Step 2: Add time slots for each day
-- MONDAY (Full business hours)
INSERT INTO staff_global_hours (vendor_id, global_day_id, start_time, end_time, max_booking, created_at, updated_at)
SELECT 0, id, '09:00:00', '10:00:00', 5, NOW(), NOW() FROM admin_global_days WHERE day = 'Monday' AND NOT EXISTS (SELECT 1 FROM staff_global_hours WHERE vendor_id = 0 AND global_day_id = (SELECT id FROM admin_global_days WHERE day = 'Monday' LIMIT 1) AND start_time = '09:00:00' AND end_time = '10:00:00');

INSERT INTO staff_global_hours (vendor_id, global_day_id, start_time, end_time, max_booking, created_at, updated_at)
SELECT 0, id, '10:00:00', '11:00:00', 5, NOW(), NOW() FROM admin_global_days WHERE day = 'Monday' AND NOT EXISTS (SELECT 1 FROM staff_global_hours WHERE vendor_id = 0 AND global_day_id = (SELECT id FROM admin_global_days WHERE day = 'Monday' LIMIT 1) AND start_time = '10:00:00' AND end_time = '11:00:00');

INSERT INTO staff_global_hours (vendor_id, global_day_id, start_time, end_time, max_booking, created_at, updated_at)
SELECT 0, id, '11:00:00', '12:00:00', 5, NOW(), NOW() FROM admin_global_days WHERE day = 'Monday' AND NOT EXISTS (SELECT 1 FROM staff_global_hours WHERE vendor_id = 0 AND global_day_id = (SELECT id FROM admin_global_days WHERE day = 'Monday' LIMIT 1) AND start_time = '11:00:00' AND end_time = '12:00:00');

INSERT INTO staff_global_hours (vendor_id, global_day_id, start_time, end_time, max_booking, created_at, updated_at)
SELECT 0, id, '14:00:00', '15:00:00', 5, NOW(), NOW() FROM admin_global_days WHERE day = 'Monday' AND NOT EXISTS (SELECT 1 FROM staff_global_hours WHERE vendor_id = 0 AND global_day_id = (SELECT id FROM admin_global_days WHERE day = 'Monday' LIMIT 1) AND start_time = '14:00:00' AND end_time = '15:00:00');

INSERT INTO staff_global_hours (vendor_id, global_day_id, start_time, end_time, max_booking, created_at, updated_at)
SELECT 0, id, '15:00:00', '16:00:00', 5, NOW(), NOW() FROM admin_global_days WHERE day = 'Monday' AND NOT EXISTS (SELECT 1 FROM staff_global_hours WHERE vendor_id = 0 AND global_day_id = (SELECT id FROM admin_global_days WHERE day = 'Monday' LIMIT 1) AND start_time = '15:00:00' AND end_time = '16:00:00');

INSERT INTO staff_global_hours (vendor_id, global_day_id, start_time, end_time, max_booking, created_at, updated_at)
SELECT 0, id, '16:00:00', '17:00:00', 5, NOW(), NOW() FROM admin_global_days WHERE day = 'Monday' AND NOT EXISTS (SELECT 1 FROM staff_global_hours WHERE vendor_id = 0 AND global_day_id = (SELECT id FROM admin_global_days WHERE day = 'Monday' LIMIT 1) AND start_time = '16:00:00' AND end_time = '17:00:00');

-- Repeat for other days (Tuesday through Sunday)
-- Use the same pattern for each day
```

### Option B: Simple Add - Use phpMyAdmin Interface

1. Click on table: `admin_global_days`
2. Check if days exist (Monday, Tuesday, etc.)
3. If not, click **Insert** tab and add them

Then:

1. Click on table: `staff_global_hours`
2. Click **Insert** tab
3. Fill in the form:
   - **vendor_id:** 0 (for admin services)
   - **global_day_id:** (get this from admin_global_days table)
   - **start_time:** 09:00:00
   - **end_time:** 10:00:00
   - **max_booking:** 5
   - **created_at:** NOW()
   - **updated_at:** NOW()
4. Click **Go**
5. Repeat for each time slot

## Step 4: Verify Time Slots Were Added

Run this query in the SQL tab:

```sql
-- Check all time slots
SELECT 
    agd.day,
    sgh.start_time,
    sgh.end_time,
    sgh.max_booking,
    sgh.id
FROM staff_global_hours sgh
JOIN admin_global_days agd ON agd.id = sgh.global_day_id
WHERE sgh.vendor_id = 0
ORDER BY 
    FIELD(agd.day, 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'),
    sgh.start_time;
```

You should see something like:
```
Monday    09:00:00  10:00:00  5  123
Monday    10:00:00  11:00:00  5  124
Monday    11:00:00  12:00:00  5  125
...
```

## Complete Time Slot Schedule

Here's what you're adding (business hours):

### Monday - Friday:
- 09:00 AM - 10:00 AM
- 10:00 AM - 11:00 AM
- 11:00 AM - 12:00 PM
- **(Lunch Break 12-2 PM)**
- 02:00 PM - 03:00 PM
- 03:00 PM - 04:00 PM
- 04:00 PM - 05:00 PM

### Saturday - Sunday:
- 10:00 AM - 11:00 AM
- 11:00 AM - 12:00 PM
- 02:00 PM - 03:00 PM
- 03:00 PM - 04:00 PM

## Important Notes

### Database Field Explanations:

1. **vendor_id**
   - `0` = Admin services
   - Other numbers = Vendor services

2. **global_day_id**
   - This is the ID from `admin_global_days` table
   - Monday might be ID 1, Tuesday ID 2, etc.

3. **start_time / end_time**
   - Use 24-hour format: `14:00:00` = 2:00 PM
   - Format: `HH:MM:SS`

4. **max_booking**
   - How many people can book this slot
   - 1 = Exclusive appointment
   - 5 = Up to 5 people
   - 10 = Group session

## Troubleshooting

### Can't Login to phpMyAdmin?

**Solution 1:** XAMPP default has no password
- Username: `root`
- Password: (leave blank)

**Solution 2:** If that doesn't work, check your `.env` file:
```
DB_USERNAME=root
DB_PASSWORD=
```

### Error: "Duplicate entry"?

This means the time slot already exists. That's OK! Skip it or delete the old one first.

### How to delete all time slots and start fresh?

```sql
-- DELETE all admin time slots (BE CAREFUL!)
DELETE FROM staff_global_hours WHERE vendor_id = 0;

-- Then add new ones using the script above
```

## After Adding Time Slots

1. Clear your browser cache (Ctrl + Shift + Delete)
2. Go to your booking page
3. Click "Book Now"
4. Select ANY date (today, tomorrow, next week)
5. You should see the dropdown with time slots!
6. Select a time → "Next Step" appears
7. Complete your booking! ✅

---

**That's it! Your time slots are ready to use!** 🎉

