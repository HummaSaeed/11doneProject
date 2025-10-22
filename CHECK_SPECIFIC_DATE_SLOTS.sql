-- =====================================================
-- Check Available Time Slots for ANY Specific Date
-- =====================================================
-- Replace '2024-10-17' with your desired date

-- Set your date here:
SET @target_date = '2024-10-17';  -- Change this to any date you want

-- Step 1: What day is this date?
SELECT 
    @target_date as checking_date,
    DAYNAME(@target_date) as day_name,
    DATE_FORMAT(@target_date, '%M %d, %Y') as formatted_date;

-- Step 2: Get all time slots for this day
SELECT 
    agd.day,
    TIME_FORMAT(sgh.start_time, '%h:%i %p') as start,
    TIME_FORMAT(sgh.end_time, '%h:%i %p') as end,
    sgh.max_booking,
    sgh.id
FROM staff_global_hours sgh
JOIN admin_global_days agd ON agd.id = sgh.global_day_id
WHERE sgh.vendor_id = 0
  AND agd.day = DAYNAME(@target_date)
ORDER BY sgh.start_time;

-- Step 3: Check existing bookings for this date
SELECT 
    sb.booking_date,
    sb.service_hour_id,
    TIME_FORMAT(sb.start_date, '%h:%i %p') as start,
    TIME_FORMAT(sb.end_date, '%h:%i %p') as end,
    sb.order_status,
    sb.payment_status
FROM service_bookings sb
WHERE sb.booking_date = @target_date
  AND sb.order_status != 'rejected'
ORDER BY sb.start_date;

-- Step 4: AVAILABLE SLOTS with spots remaining
SELECT 
    TIME_FORMAT(sgh.start_time, '%h:%i %p') as 'Time Slot Start',
    TIME_FORMAT(sgh.end_time, '%h:%i %p') as 'Time Slot End',
    sgh.max_booking as 'Max Capacity',
    COALESCE(COUNT(sb.id), 0) as 'Current Bookings',
    (sgh.max_booking - COALESCE(COUNT(sb.id), 0)) as 'Available Spots',
    CASE 
        WHEN COALESCE(COUNT(sb.id), 0) < sgh.max_booking THEN '✅ AVAILABLE'
        ELSE '❌ FULLY BOOKED'
    END as 'Status',
    sgh.id as 'Slot ID'
FROM staff_global_hours sgh
JOIN admin_global_days agd ON agd.id = sgh.global_day_id
LEFT JOIN service_bookings sb ON sb.service_hour_id = sgh.id 
    AND sb.booking_date = @target_date
    AND sb.order_status != 'rejected'
WHERE sgh.vendor_id = 0
  AND agd.day = DAYNAME(@target_date)
GROUP BY sgh.id, sgh.start_time, sgh.end_time, sgh.max_booking
ORDER BY sgh.start_time;

-- Step 5: ONLY AVAILABLE SLOTS (ready to book)
SELECT 
    TIME_FORMAT(sgh.start_time, '%h:%i %p') as 'Start',
    TIME_FORMAT(sgh.end_time, '%h:%i %p') as 'End',
    (sgh.max_booking - COALESCE(COUNT(sb.id), 0)) as 'Available Spots'
FROM staff_global_hours sgh
JOIN admin_global_days agd ON agd.id = sgh.global_day_id
LEFT JOIN service_bookings sb ON sb.service_hour_id = sgh.id 
    AND sb.booking_date = @target_date
    AND sb.order_status != 'rejected'
WHERE sgh.vendor_id = 0
  AND agd.day = DAYNAME(@target_date)
GROUP BY sgh.id, sgh.start_time, sgh.end_time, sgh.max_booking
HAVING (sgh.max_booking - COALESCE(COUNT(sb.id), 0)) > 0
ORDER BY sgh.start_time;

-- =====================================================
-- QUICK EXAMPLES - Change the dates:
-- =====================================================

-- Check TODAY:
-- SET @target_date = CURDATE();

-- Check TOMORROW:
-- SET @target_date = DATE_ADD(CURDATE(), INTERVAL 1 DAY);

-- Check specific date:
-- SET @target_date = '2024-10-20';

-- Check next Monday:
-- SET @target_date = DATE_ADD(CURDATE(), INTERVAL (7 - WEEKDAY(CURDATE())) % 7 DAY);

