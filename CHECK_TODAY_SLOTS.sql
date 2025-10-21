-- =====================================================
-- Check Available Time Slots for TODAY
-- =====================================================

-- Step 1: See what day today is
SELECT DAYNAME(CURDATE()) as today_day_name, CURDATE() as today_date;

-- Step 2: Get all time slots for today's day
SELECT 
    agd.day as day_name,
    sgh.id as slot_id,
    sgh.start_time,
    sgh.end_time,
    sgh.max_booking,
    CURDATE() as for_date,
    TIME_FORMAT(sgh.start_time, '%h:%i %p') as start_12h,
    TIME_FORMAT(sgh.end_time, '%h:%i %p') as end_12h
FROM staff_global_hours sgh
JOIN admin_global_days agd ON agd.id = sgh.global_day_id
WHERE sgh.vendor_id = 0
  AND agd.day = DAYNAME(CURDATE())
ORDER BY sgh.start_time;

-- Step 3: Check if any bookings exist for TODAY
SELECT 
    sb.id as booking_id,
    sb.service_hour_id,
    sb.booking_date,
    sb.start_date,
    sb.end_date,
    sb.order_status,
    sb.payment_status
FROM service_bookings sb
WHERE sb.booking_date = CURDATE()
  AND sb.order_status != 'rejected'
ORDER BY sb.start_date;

-- Step 4: Get AVAILABLE slots for TODAY (excluding fully booked)
SELECT 
    agd.day as day_name,
    sgh.id as slot_id,
    TIME_FORMAT(sgh.start_time, '%h:%i %p') as start_time,
    TIME_FORMAT(sgh.end_time, '%h:%i %p') as end_time,
    sgh.max_booking,
    COUNT(sb.id) as current_bookings,
    (sgh.max_booking - COUNT(sb.id)) as available_spots,
    CASE 
        WHEN COUNT(sb.id) < sgh.max_booking THEN 'AVAILABLE ✅'
        ELSE 'FULLY BOOKED ❌'
    END as status
FROM staff_global_hours sgh
JOIN admin_global_days agd ON agd.id = sgh.global_day_id
LEFT JOIN service_bookings sb ON sb.service_hour_id = sgh.id 
    AND sb.booking_date = CURDATE()
    AND sb.order_status != 'rejected'
WHERE sgh.vendor_id = 0
  AND agd.day = DAYNAME(CURDATE())
GROUP BY sgh.id, agd.day, sgh.start_time, sgh.end_time, sgh.max_booking
ORDER BY sgh.start_time;

-- Step 5: ONLY show AVAILABLE slots for TODAY
SELECT 
    TIME_FORMAT(sgh.start_time, '%h:%i %p') as start_time,
    TIME_FORMAT(sgh.end_time, '%h:%i %p') as end_time,
    (sgh.max_booking - COUNT(sb.id)) as available_spots,
    sgh.id as slot_id
FROM staff_global_hours sgh
JOIN admin_global_days agd ON agd.id = sgh.global_day_id
LEFT JOIN service_bookings sb ON sb.service_hour_id = sgh.id 
    AND sb.booking_date = CURDATE()
    AND sb.order_status != 'rejected'
WHERE sgh.vendor_id = 0
  AND agd.day = DAYNAME(CURDATE())
GROUP BY sgh.id, sgh.start_time, sgh.end_time, sgh.max_booking
HAVING COUNT(sb.id) < sgh.max_booking
ORDER BY sgh.start_time;

-- =====================================================
-- Quick Summary for TODAY
-- =====================================================
SELECT 
    CONCAT('Today is ', DAYNAME(CURDATE()), ' - ', DATE_FORMAT(CURDATE(), '%M %d, %Y')) as info,
    COUNT(DISTINCT sgh.id) as total_slots,
    COUNT(DISTINCT sb.id) as total_bookings,
    (COUNT(DISTINCT sgh.id) * 5 - COUNT(DISTINCT sb.id)) as estimated_available_spots
FROM staff_global_hours sgh
JOIN admin_global_days agd ON agd.id = sgh.global_day_id
LEFT JOIN service_bookings sb ON sb.service_hour_id = sgh.id 
    AND sb.booking_date = CURDATE()
    AND sb.order_status != 'rejected'
WHERE sgh.vendor_id = 0
  AND agd.day = DAYNAME(CURDATE());

