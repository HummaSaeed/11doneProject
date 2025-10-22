-- COMPREHENSIVE TIME SLOTS CLEANUP FOR ALL DAYS
-- This script will clean up malformed time slots and ensure all days have proper slots

-- Step 1: Remove ALL existing time slots for vendor_id = 0 to start fresh
DELETE FROM staff_global_hours WHERE vendor_id = 0;

-- Step 2: Add clean time slots for ALL days (Monday through Sunday)

-- Sunday (Day ID 1)
INSERT INTO staff_global_hours (global_day_id, start_time, end_time, max_booking, vendor_id) VALUES
(1, '09:00:00', '10:00:00', 5, 0),
(1, '10:00:00', '11:00:00', 5, 0),
(1, '11:00:00', '12:00:00', 5, 0),
(1, '14:00:00', '15:00:00', 5, 0),
(1, '15:00:00', '16:00:00', 5, 0),
(1, '16:00:00', '17:00:00', 5, 0);

-- Monday (Day ID 2)
INSERT INTO staff_global_hours (global_day_id, start_time, end_time, max_booking, vendor_id) VALUES
(2, '09:00:00', '10:00:00', 5, 0),
(2, '10:00:00', '11:00:00', 5, 0),
(2, '11:00:00', '12:00:00', 5, 0),
(2, '14:00:00', '15:00:00', 5, 0),
(2, '15:00:00', '16:00:00', 5, 0),
(2, '16:00:00', '17:00:00', 5, 0);

-- Tuesday (Day ID 3)
INSERT INTO staff_global_hours (global_day_id, start_time, end_time, max_booking, vendor_id) VALUES
(3, '09:00:00', '10:00:00', 5, 0),
(3, '10:00:00', '11:00:00', 5, 0),
(3, '11:00:00', '12:00:00', 5, 0),
(3, '14:00:00', '15:00:00', 5, 0),
(3, '15:00:00', '16:00:00', 5, 0),
(3, '16:00:00', '17:00:00', 5, 0);

-- Wednesday (Day ID 4)
INSERT INTO staff_global_hours (global_day_id, start_time, end_time, max_booking, vendor_id) VALUES
(4, '09:00:00', '10:00:00', 5, 0),
(4, '10:00:00', '11:00:00', 5, 0),
(4, '11:00:00', '12:00:00', 5, 0),
(4, '14:00:00', '15:00:00', 5, 0),
(4, '15:00:00', '16:00:00', 5, 0),
(4, '16:00:00', '17:00:00', 5, 0);

-- Thursday (Day ID 5)
INSERT INTO staff_global_hours (global_day_id, start_time, end_time, max_booking, vendor_id) VALUES
(5, '09:00:00', '10:00:00', 5, 0),
(5, '10:00:00', '11:00:00', 5, 0),
(5, '11:00:00', '12:00:00', 5, 0),
(5, '14:00:00', '15:00:00', 5, 0),
(5, '15:00:00', '16:00:00', 5, 0),
(5, '16:00:00', '17:00:00', 5, 0);

-- Friday (Day ID 6)
INSERT INTO staff_global_hours (global_day_id, start_time, end_time, max_booking, vendor_id) VALUES
(6, '09:00:00', '10:00:00', 5, 0),
(6, '10:00:00', '11:00:00', 5, 0),
(6, '11:00:00', '12:00:00', 5, 0),
(6, '14:00:00', '15:00:00', 5, 0),
(6, '15:00:00', '16:00:00', 5, 0),
(6, '16:00:00', '17:00:00', 5, 0);

-- Saturday (Day ID 7)
INSERT INTO staff_global_hours (global_day_id, start_time, end_time, max_booking, vendor_id) VALUES
(7, '09:00:00', '10:00:00', 5, 0),
(7, '10:00:00', '11:00:00', 5, 0),
(7, '11:00:00', '12:00:00', 5, 0),
(7, '14:00:00', '15:00:00', 5, 0),
(7, '15:00:00', '16:00:00', 5, 0),
(7, '16:00:00', '17:00:00', 5, 0);

-- Step 3: Verify all days have proper time slots
SELECT 
    agd.day,
    COUNT(sgh.id) as slot_count,
    MIN(sgh.start_time) as first_slot,
    MAX(sgh.end_time) as last_slot
FROM admin_global_days agd
LEFT JOIN staff_global_hours sgh ON sgh.global_day_id = agd.id AND sgh.vendor_id = 0
WHERE agd.id IN (1,2,3,4,5,6,7)
GROUP BY agd.id, agd.day
ORDER BY agd.id;

