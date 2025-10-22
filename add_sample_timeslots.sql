-- =====================================================
-- Quick Fix: Add Sample Time Slots for Booking System
-- =====================================================
-- Run this SQL script to add working hours for your services

-- Step 1: Ensure days exist in the database
-- For Admin Services (vendor_id = 0)
INSERT IGNORE INTO admin_global_days (day, created_at, updated_at) VALUES
('Monday', NOW(), NOW()),
('Tuesday', NOW(), NOW()),
('Wednesday', NOW(), NOW()),
('Thursday', NOW(), NOW()),
('Friday', NOW(), NOW()),
('Saturday', NOW(), NOW()),
('Sunday', NOW(), NOW());

-- For Vendor Services
INSERT IGNORE INTO staff_global_days (day, created_at, updated_at) VALUES
('Monday', NOW(), NOW()),
('Tuesday', NOW(), NOW()),
('Wednesday', NOW(), NOW()),
('Thursday', NOW(), NOW()),
('Friday', NOW(), NOW()),
('Saturday', NOW(), NOW()),
('Sunday', NOW(), NOW());

-- Step 2: Add time slots for ADMIN services (vendor_id = 0)
-- Monday slots
INSERT INTO staff_global_hours (vendor_id, global_day_id, start_time, end_time, max_booking, created_at, updated_at)
SELECT 0, id, '09:00:00', '10:00:00', 5, NOW(), NOW() FROM admin_global_days WHERE day = 'Monday';

INSERT INTO staff_global_hours (vendor_id, global_day_id, start_time, end_time, max_booking, created_at, updated_at)
SELECT 0, id, '10:00:00', '11:00:00', 5, NOW(), NOW() FROM admin_global_days WHERE day = 'Monday';

INSERT INTO staff_global_hours (vendor_id, global_day_id, start_time, end_time, max_booking, created_at, updated_at)
SELECT 0, id, '11:00:00', '12:00:00', 5, NOW(), NOW() FROM admin_global_days WHERE day = 'Monday';

INSERT INTO staff_global_hours (vendor_id, global_day_id, start_time, end_time, max_booking, created_at, updated_at)
SELECT 0, id, '14:00:00', '15:00:00', 5, NOW(), NOW() FROM admin_global_days WHERE day = 'Monday';

INSERT INTO staff_global_hours (vendor_id, global_day_id, start_time, end_time, max_booking, created_at, updated_at)
SELECT 0, id, '15:00:00', '16:00:00', 5, NOW(), NOW() FROM admin_global_days WHERE day = 'Monday';

INSERT INTO staff_global_hours (vendor_id, global_day_id, start_time, end_time, max_booking, created_at, updated_at)
SELECT 0, id, '16:00:00', '17:00:00', 5, NOW(), NOW() FROM admin_global_days WHERE day = 'Monday';

-- Tuesday slots
INSERT INTO staff_global_hours (vendor_id, global_day_id, start_time, end_time, max_booking, created_at, updated_at)
SELECT 0, id, '09:00:00', '10:00:00', 5, NOW(), NOW() FROM admin_global_days WHERE day = 'Tuesday';

INSERT INTO staff_global_hours (vendor_id, global_day_id, start_time, end_time, max_booking, created_at, updated_at)
SELECT 0, id, '10:00:00', '11:00:00', 5, NOW(), NOW() FROM admin_global_days WHERE day = 'Tuesday';

INSERT INTO staff_global_hours (vendor_id, global_day_id, start_time, end_time, max_booking, created_at, updated_at)
SELECT 0, id, '11:00:00', '12:00:00', 5, NOW(), NOW() FROM admin_global_days WHERE day = 'Tuesday';

INSERT INTO staff_global_hours (vendor_id, global_day_id, start_time, end_time, max_booking, created_at, updated_at)
SELECT 0, id, '14:00:00', '15:00:00', 5, NOW(), NOW() FROM admin_global_days WHERE day = 'Tuesday';

INSERT INTO staff_global_hours (vendor_id, global_day_id, start_time, end_time, max_booking, created_at, updated_at)
SELECT 0, id, '15:00:00', '16:00:00', 5, NOW(), NOW() FROM admin_global_days WHERE day = 'Tuesday';

INSERT INTO staff_global_hours (vendor_id, global_day_id, start_time, end_time, max_booking, created_at, updated_at)
SELECT 0, id, '16:00:00', '17:00:00', 5, NOW(), NOW() FROM admin_global_days WHERE day = 'Tuesday';

-- Wednesday slots
INSERT INTO staff_global_hours (vendor_id, global_day_id, start_time, end_time, max_booking, created_at, updated_at)
SELECT 0, id, '09:00:00', '10:00:00', 5, NOW(), NOW() FROM admin_global_days WHERE day = 'Wednesday';

INSERT INTO staff_global_hours (vendor_id, global_day_id, start_time, end_time, max_booking, created_at, updated_at)
SELECT 0, id, '10:00:00', '11:00:00', 5, NOW(), NOW() FROM admin_global_days WHERE day = 'Wednesday';

INSERT INTO staff_global_hours (vendor_id, global_day_id, start_time, end_time, max_booking, created_at, updated_at)
SELECT 0, id, '11:00:00', '12:00:00', 5, NOW(), NOW() FROM admin_global_days WHERE day = 'Wednesday';

INSERT INTO staff_global_hours (vendor_id, global_day_id, start_time, end_time, max_booking, created_at, updated_at)
SELECT 0, id, '14:00:00', '15:00:00', 5, NOW(), NOW() FROM admin_global_days WHERE day = 'Wednesday';

INSERT INTO staff_global_hours (vendor_id, global_day_id, start_time, end_time, max_booking, created_at, updated_at)
SELECT 0, id, '15:00:00', '16:00:00', 5, NOW(), NOW() FROM admin_global_days WHERE day = 'Wednesday';

INSERT INTO staff_global_hours (vendor_id, global_day_id, start_time, end_time, max_booking, created_at, updated_at)
SELECT 0, id, '16:00:00', '17:00:00', 5, NOW(), NOW() FROM admin_global_days WHERE day = 'Wednesday';

-- Thursday slots
INSERT INTO staff_global_hours (vendor_id, global_day_id, start_time, end_time, max_booking, created_at, updated_at)
SELECT 0, id, '09:00:00', '10:00:00', 5, NOW(), NOW() FROM admin_global_days WHERE day = 'Thursday';

INSERT INTO staff_global_hours (vendor_id, global_day_id, start_time, end_time, max_booking, created_at, updated_at)
SELECT 0, id, '10:00:00', '11:00:00', 5, NOW(), NOW() FROM admin_global_days WHERE day = 'Thursday';

INSERT INTO staff_global_hours (vendor_id, global_day_id, start_time, end_time, max_booking, created_at, updated_at)
SELECT 0, id, '11:00:00', '12:00:00', 5, NOW(), NOW() FROM admin_global_days WHERE day = 'Thursday';

INSERT INTO staff_global_hours (vendor_id, global_day_id, start_time, end_time, max_booking, created_at, updated_at)
SELECT 0, id, '14:00:00', '15:00:00', 5, NOW(), NOW() FROM admin_global_days WHERE day = 'Thursday';

INSERT INTO staff_global_hours (vendor_id, global_day_id, start_time, end_time, max_booking, created_at, updated_at)
SELECT 0, id, '15:00:00', '16:00:00', 5, NOW(), NOW() FROM admin_global_days WHERE day = 'Thursday';

INSERT INTO staff_global_hours (vendor_id, global_day_id, start_time, end_time, max_booking, created_at, updated_at)
SELECT 0, id, '16:00:00', '17:00:00', 5, NOW(), NOW() FROM admin_global_days WHERE day = 'Thursday';

-- Friday slots
INSERT INTO staff_global_hours (vendor_id, global_day_id, start_time, end_time, max_booking, created_at, updated_at)
SELECT 0, id, '09:00:00', '10:00:00', 5, NOW(), NOW() FROM admin_global_days WHERE day = 'Friday';

INSERT INTO staff_global_hours (vendor_id, global_day_id, start_time, end_time, max_booking, created_at, updated_at)
SELECT 0, id, '10:00:00', '11:00:00', 5, NOW(), NOW() FROM admin_global_days WHERE day = 'Friday';

INSERT INTO staff_global_hours (vendor_id, global_day_id, start_time, end_time, max_booking, created_at, updated_at)
SELECT 0, id, '11:00:00', '12:00:00', 5, NOW(), NOW() FROM admin_global_days WHERE day = 'Friday';

INSERT INTO staff_global_hours (vendor_id, global_day_id, start_time, end_time, max_booking, created_at, updated_at)
SELECT 0, id, '14:00:00', '15:00:00', 5, NOW(), NOW() FROM admin_global_days WHERE day = 'Friday';

INSERT INTO staff_global_hours (vendor_id, global_day_id, start_time, end_time, max_booking, created_at, updated_at)
SELECT 0, id, '15:00:00', '16:00:00', 5, NOW(), NOW() FROM admin_global_days WHERE day = 'Friday';

INSERT INTO staff_global_hours (vendor_id, global_day_id, start_time, end_time, max_booking, created_at, updated_at)
SELECT 0, id, '16:00:00', '17:00:00', 5, NOW(), NOW() FROM admin_global_days WHERE day = 'Friday';

-- Saturday slots (shorter hours)
INSERT INTO staff_global_hours (vendor_id, global_day_id, start_time, end_time, max_booking, created_at, updated_at)
SELECT 0, id, '10:00:00', '11:00:00', 5, NOW(), NOW() FROM admin_global_days WHERE day = 'Saturday';

INSERT INTO staff_global_hours (vendor_id, global_day_id, start_time, end_time, max_booking, created_at, updated_at)
SELECT 0, id, '11:00:00', '12:00:00', 5, NOW(), NOW() FROM admin_global_days WHERE day = 'Saturday';

INSERT INTO staff_global_hours (vendor_id, global_day_id, start_time, end_time, max_booking, created_at, updated_at)
SELECT 0, id, '14:00:00', '15:00:00', 5, NOW(), NOW() FROM admin_global_days WHERE day = 'Saturday';

INSERT INTO staff_global_hours (vendor_id, global_day_id, start_time, end_time, max_booking, created_at, updated_at)
SELECT 0, id, '15:00:00', '16:00:00', 5, NOW(), NOW() FROM admin_global_days WHERE day = 'Saturday';

-- Sunday slots (shorter hours)
INSERT INTO staff_global_hours (vendor_id, global_day_id, start_time, end_time, max_booking, created_at, updated_at)
SELECT 0, id, '10:00:00', '11:00:00', 5, NOW(), NOW() FROM admin_global_days WHERE day = 'Sunday';

INSERT INTO staff_global_hours (vendor_id, global_day_id, start_time, end_time, max_booking, created_at, updated_at)
SELECT 0, id, '11:00:00', '12:00:00', 5, NOW(), NOW() FROM admin_global_days WHERE day = 'Sunday';

INSERT INTO staff_global_hours (vendor_id, global_day_id, start_time, end_time, max_booking, created_at, updated_at)
SELECT 0, id, '14:00:00', '15:00:00', 5, NOW(), NOW() FROM admin_global_days WHERE day = 'Sunday';

INSERT INTO staff_global_hours (vendor_id, global_day_id, start_time, end_time, max_booking, created_at, updated_at)
SELECT 0, id, '15:00:00', '16:00:00', 5, NOW(), NOW() FROM admin_global_days WHERE day = 'Sunday';

-- Step 3: Verify the data was inserted
SELECT 'Time slots added successfully!' AS status;

-- Check how many slots were added
SELECT 
    (SELECT COUNT(*) FROM admin_global_days) as total_days,
    (SELECT COUNT(*) FROM staff_global_hours WHERE vendor_id = 0) as total_admin_slots;

-- View the time slots by day
SELECT 
    agd.day,
    COUNT(*) as slot_count,
    MIN(sgh.start_time) as first_slot,
    MAX(sgh.end_time) as last_slot
FROM staff_global_hours sgh
JOIN admin_global_days agd ON agd.id = sgh.global_day_id
WHERE sgh.vendor_id = 0
GROUP BY agd.day
ORDER BY FIELD(agd.day, 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday');

-- =====================================================
-- NOTES:
-- =====================================================
-- 1. This script adds time slots for ADMIN services (vendor_id = 0)
-- 2. For VENDOR services, you need to:
--    - Change vendor_id from 0 to the actual vendor ID
--    - Use staff_global_days instead of admin_global_days
-- 3. Adjust times and max_booking as needed
-- 4. Time format is 24-hour: 09:00:00 = 9 AM, 14:00:00 = 2 PM
-- 5. max_booking = 5 means 5 customers can book the same slot
-- =====================================================


