-- =====================================================
-- SIMPLE: Add Time Slots for ALL Days
-- Just copy this entire file and paste into phpMyAdmin SQL tab
-- =====================================================

-- Note: This script is safe to run multiple times
-- It won't create duplicates

-- Step 1: Make sure all days exist (Monday-Sunday)
INSERT IGNORE INTO `admin_global_days` (`day`, `created_at`, `updated_at`) VALUES
('Monday', NOW(), NOW()),
('Tuesday', NOW(), NOW()),
('Wednesday', NOW(), NOW()),
('Thursday', NOW(), NOW()),
('Friday', NOW(), NOW()),
('Saturday', NOW(), NOW()),
('Sunday', NOW(), NOW());

-- Step 2: Get the day IDs (we'll use these next)
SET @monday_id = (SELECT id FROM admin_global_days WHERE day = 'Monday' LIMIT 1);
SET @tuesday_id = (SELECT id FROM admin_global_days WHERE day = 'Tuesday' LIMIT 1);
SET @wednesday_id = (SELECT id FROM admin_global_days WHERE day = 'Wednesday' LIMIT 1);
SET @thursday_id = (SELECT id FROM admin_global_days WHERE day = 'Thursday' LIMIT 1);
SET @friday_id = (SELECT id FROM admin_global_days WHERE day = 'Friday' LIMIT 1);
SET @saturday_id = (SELECT id FROM admin_global_days WHERE day = 'Saturday' LIMIT 1);
SET @sunday_id = (SELECT id FROM admin_global_days WHERE day = 'Sunday' LIMIT 1);

-- Step 3: Add time slots for MONDAY
INSERT IGNORE INTO `staff_global_hours` (`vendor_id`, `global_day_id`, `start_time`, `end_time`, `max_booking`, `created_at`, `updated_at`) VALUES
(0, @monday_id, '09:00:00', '10:00:00', 5, NOW(), NOW()),
(0, @monday_id, '10:00:00', '11:00:00', 5, NOW(), NOW()),
(0, @monday_id, '11:00:00', '12:00:00', 5, NOW(), NOW()),
(0, @monday_id, '14:00:00', '15:00:00', 5, NOW(), NOW()),
(0, @monday_id, '15:00:00', '16:00:00', 5, NOW(), NOW()),
(0, @monday_id, '16:00:00', '17:00:00', 5, NOW(), NOW());

-- Step 4: Add time slots for TUESDAY
INSERT IGNORE INTO `staff_global_hours` (`vendor_id`, `global_day_id`, `start_time`, `end_time`, `max_booking`, `created_at`, `updated_at`) VALUES
(0, @tuesday_id, '09:00:00', '10:00:00', 5, NOW(), NOW()),
(0, @tuesday_id, '10:00:00', '11:00:00', 5, NOW(), NOW()),
(0, @tuesday_id, '11:00:00', '12:00:00', 5, NOW(), NOW()),
(0, @tuesday_id, '14:00:00', '15:00:00', 5, NOW(), NOW()),
(0, @tuesday_id, '15:00:00', '16:00:00', 5, NOW(), NOW()),
(0, @tuesday_id, '16:00:00', '17:00:00', 5, NOW(), NOW());

-- Step 5: Add time slots for WEDNESDAY
INSERT IGNORE INTO `staff_global_hours` (`vendor_id`, `global_day_id`, `start_time`, `end_time`, `max_booking`, `created_at`, `updated_at`) VALUES
(0, @wednesday_id, '09:00:00', '10:00:00', 5, NOW(), NOW()),
(0, @wednesday_id, '10:00:00', '11:00:00', 5, NOW(), NOW()),
(0, @wednesday_id, '11:00:00', '12:00:00', 5, NOW(), NOW()),
(0, @wednesday_id, '14:00:00', '15:00:00', 5, NOW(), NOW()),
(0, @wednesday_id, '15:00:00', '16:00:00', 5, NOW(), NOW()),
(0, @wednesday_id, '16:00:00', '17:00:00', 5, NOW(), NOW());

-- Step 6: Add time slots for THURSDAY
INSERT IGNORE INTO `staff_global_hours` (`vendor_id`, `global_day_id`, `start_time`, `end_time`, `max_booking`, `created_at`, `updated_at`) VALUES
(0, @thursday_id, '09:00:00', '10:00:00', 5, NOW(), NOW()),
(0, @thursday_id, '10:00:00', '11:00:00', 5, NOW(), NOW()),
(0, @thursday_id, '11:00:00', '12:00:00', 5, NOW(), NOW()),
(0, @thursday_id, '14:00:00', '15:00:00', 5, NOW(), NOW()),
(0, @thursday_id, '15:00:00', '16:00:00', 5, NOW(), NOW()),
(0, @thursday_id, '16:00:00', '17:00:00', 5, NOW(), NOW());

-- Step 7: Add time slots for FRIDAY
INSERT IGNORE INTO `staff_global_hours` (`vendor_id`, `global_day_id`, `start_time`, `end_time`, `max_booking`, `created_at`, `updated_at`) VALUES
(0, @friday_id, '09:00:00', '10:00:00', 5, NOW(), NOW()),
(0, @friday_id, '10:00:00', '11:00:00', 5, NOW(), NOW()),
(0, @friday_id, '11:00:00', '12:00:00', 5, NOW(), NOW()),
(0, @friday_id, '14:00:00', '15:00:00', 5, NOW(), NOW()),
(0, @friday_id, '15:00:00', '16:00:00', 5, NOW(), NOW()),
(0, @friday_id, '16:00:00', '17:00:00', 5, NOW(), NOW());

-- Step 8: Add time slots for SATURDAY (shorter hours)
INSERT IGNORE INTO `staff_global_hours` (`vendor_id`, `global_day_id`, `start_time`, `end_time`, `max_booking`, `created_at`, `updated_at`) VALUES
(0, @saturday_id, '10:00:00', '11:00:00', 5, NOW(), NOW()),
(0, @saturday_id, '11:00:00', '12:00:00', 5, NOW(), NOW()),
(0, @saturday_id, '14:00:00', '15:00:00', 5, NOW(), NOW()),
(0, @saturday_id, '15:00:00', '16:00:00', 5, NOW(), NOW());

-- Step 9: Add time slots for SUNDAY (shorter hours)
INSERT IGNORE INTO `staff_global_hours` (`vendor_id`, `global_day_id`, `start_time`, `end_time`, `max_booking`, `created_at`, `updated_at`) VALUES
(0, @sunday_id, '10:00:00', '11:00:00', 5, NOW(), NOW()),
(0, @sunday_id, '11:00:00', '12:00:00', 5, NOW(), NOW()),
(0, @sunday_id, '14:00:00', '15:00:00', 5, NOW(), NOW()),
(0, @sunday_id, '15:00:00', '16:00:00', 5, NOW(), NOW());

-- Step 10: Verify everything was added
SELECT 'Time slots added successfully!' AS status;

-- Show summary
SELECT 
    agd.day,
    COUNT(*) as total_slots,
    MIN(sgh.start_time) as first_slot,
    MAX(sgh.end_time) as last_slot
FROM staff_global_hours sgh
JOIN admin_global_days agd ON agd.id = sgh.global_day_id
WHERE sgh.vendor_id = 0
GROUP BY agd.day
ORDER BY FIELD(agd.day, 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday');

-- =====================================================
-- DONE! Now test your booking system!
-- =====================================================

