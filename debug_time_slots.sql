-- =====================================================
-- DEBUG: Why are time slots returning empty results?
-- =====================================================

-- Set your target date here:
SET @target_date = '2024-10-17';  -- Change this to your desired date

-- =====================================================
-- STEP 1: Check if the date and day name are correct
-- =====================================================
SELECT 
    @target_date as target_date,
    DAYNAME(@target_date) as day_name,
    DATE_FORMAT(@target_date, '%M %d, %Y') as formatted_date;

-- =====================================================
-- STEP 2: Check if admin_global_days table has data
-- =====================================================
SELECT 
    id,
    day,
    status
FROM admin_global_days 
ORDER BY id;

-- =====================================================
-- STEP 3: Check if staff_global_hours table has data
-- =====================================================
SELECT 
    sgh.id,
    sgh.vendor_id,
    sgh.global_day_id,
    agd.day,
    TIME_FORMAT(sgh.start_time, '%h:%i %p') as start_time,
    TIME_FORMAT(sgh.end_time, '%h:%i %p') as end_time,
    sgh.max_booking,
    sgh.status
FROM staff_global_hours sgh
JOIN admin_global_days agd ON agd.id = sgh.global_day_id
WHERE sgh.vendor_id = 0
ORDER BY agd.day, sgh.start_time;

-- =====================================================
-- STEP 4: Check if there are any time slots for the target day
-- =====================================================
SELECT 
    sgh.id,
    agd.day,
    TIME_FORMAT(sgh.start_time, '%h:%i %p') as start_time,
    TIME_FORMAT(sgh.end_time, '%h:%i %p') as end_time,
    sgh.max_booking
FROM staff_global_hours sgh
JOIN admin_global_days agd ON agd.id = sgh.global_day_id
WHERE sgh.vendor_id = 0
  AND agd.day = DAYNAME(@target_date)
ORDER BY sgh.start_time;

-- =====================================================
-- STEP 5: Check existing bookings for the target date
-- =====================================================
SELECT 
    sb.id,
    sb.booking_date,
    sb.service_hour_id,
    TIME_FORMAT(sb.start_date, '%h:%i %p') as start_time,
    TIME_FORMAT(sb.end_date, '%h:%i %p') as end_time,
    sb.order_status,
    sb.payment_status
FROM service_bookings sb
WHERE sb.booking_date = @target_date
ORDER BY sb.start_date;

-- =====================================================
-- STEP 6: Check if there are any bookings at all
-- =====================================================
SELECT 
    COUNT(*) as total_bookings,
    COUNT(CASE WHEN booking_date = @target_date THEN 1 END) as bookings_for_target_date
FROM service_bookings;

-- =====================================================
-- STEP 7: Check the exact query that's failing
-- =====================================================
SELECT 
    'DEBUG: Checking each part of the query' as debug_info,
    DAYNAME(@target_date) as day_name,
    (SELECT COUNT(*) FROM admin_global_days WHERE day = DAYNAME(@target_date)) as days_found,
    (SELECT COUNT(*) FROM staff_global_hours WHERE vendor_id = 0) as global_hours_found,
    (SELECT COUNT(*) FROM staff_global_hours sgh 
     JOIN admin_global_days agd ON agd.id = sgh.global_day_id 
     WHERE sgh.vendor_id = 0 AND agd.day = DAYNAME(@target_date)) as matching_slots;

-- =====================================================
-- STEP 8: Alternative query to find available slots
-- =====================================================
SELECT 
    sgh.id as slot_id,
    agd.day,
    TIME_FORMAT(sgh.start_time, '%h:%i %p') as start_time,
    TIME_FORMAT(sgh.end_time, '%h:%i %p') as end_time,
    sgh.max_booking,
    COALESCE(COUNT(sb.id), 0) as current_bookings,
    (sgh.max_booking - COALESCE(COUNT(sb.id), 0)) as available_spots
FROM staff_global_hours sgh
JOIN admin_global_days agd ON agd.id = sgh.global_day_id
LEFT JOIN service_bookings sb ON sb.service_hour_id = sgh.id 
    AND sb.booking_date = @target_date
    AND sb.order_status != 'rejected'
WHERE sgh.vendor_id = 0
  AND agd.day = DAYNAME(@target_date)
GROUP BY sgh.id, sgh.start_time, sgh.end_time, sgh.max_booking
ORDER BY sgh.start_time;

-- =====================================================
-- STEP 9: Check if the issue is with the HAVING clause
-- =====================================================
SELECT 
    sgh.id as slot_id,
    TIME_FORMAT(sgh.start_time, '%h:%i %p') as start_time,
    TIME_FORMAT(sgh.end_time, '%h:%i %p') as end_time,
    sgh.max_booking,
    COALESCE(COUNT(sb.id), 0) as current_bookings,
    (sgh.max_booking - COALESCE(COUNT(sb.id), 0)) as available_spots,
    CASE 
        WHEN (sgh.max_booking - COALESCE(COUNT(sb.id), 0)) > 0 THEN 'AVAILABLE'
        ELSE 'FULL'
    END as status
FROM staff_global_hours sgh
JOIN admin_global_days agd ON agd.id = sgh.global_day_id
LEFT JOIN service_bookings sb ON sb.service_hour_id = sgh.id 
    AND sb.booking_date = @target_date
    AND sb.order_status != 'rejected'
WHERE sgh.vendor_id = 0
  AND agd.day = DAYNAME(@target_date)
GROUP BY sgh.id, sgh.start_time, sgh.end_time, sgh.max_booking
ORDER BY sgh.start_time;


