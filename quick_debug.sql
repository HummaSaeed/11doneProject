-- Quick Debug: Why are time slots empty?
-- Replace '2024-10-17' with your target date

SET @target_date = '2024-10-17';

-- 1. Check if the day exists in admin_global_days
SELECT 'Step 1: Check if day exists' as step;
SELECT id, day, status FROM admin_global_days WHERE day = DAYNAME(@target_date);

-- 2. Check if there are any global hours for vendor_id = 0
SELECT 'Step 2: Check global hours' as step;
SELECT COUNT(*) as total_global_hours FROM staff_global_hours WHERE vendor_id = 0;

-- 3. Check if there are hours for the specific day
SELECT 'Step 3: Check hours for specific day' as step;
SELECT 
    sgh.id,
    agd.day,
    TIME_FORMAT(sgh.start_time, '%h:%i %p') as start_time,
    TIME_FORMAT(sgh.end_time, '%h:%i %p') as end_time,
    sgh.max_booking
FROM staff_global_hours sgh
JOIN admin_global_days agd ON agd.id = sgh.global_day_id
WHERE sgh.vendor_id = 0 AND agd.day = DAYNAME(@target_date);

-- 4. Check bookings for that date
SELECT 'Step 4: Check existing bookings' as step;
SELECT COUNT(*) as bookings_count FROM service_bookings 
WHERE booking_date = @target_date AND order_status != 'rejected';

-- 5. Run your original query without HAVING clause
SELECT 'Step 5: Original query without HAVING' as step;
SELECT 
    TIME_FORMAT(sgh.start_time, '%h:%i %p') as 'Start',
    TIME_FORMAT(sgh.end_time, '%h:%i %p') as 'End',
    sgh.max_booking as 'Max Capacity',
    COALESCE(COUNT(sb.id), 0) as 'Current Bookings',
    (sgh.max_booking - COALESCE(COUNT(sb.id), 0)) as 'Available Spots'
FROM staff_global_hours sgh
JOIN admin_global_days agd ON agd.id = sgh.global_day_id
LEFT JOIN service_bookings sb ON sb.service_hour_id = sgh.id 
    AND sb.booking_date = @target_date
    AND sb.order_status != 'rejected'
WHERE sgh.vendor_id = 0
  AND agd.day = DAYNAME(@target_date)
GROUP BY sgh.id, sgh.start_time, sgh.end_time, sgh.max_booking
ORDER BY sgh.start_time;


