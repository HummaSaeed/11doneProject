-- Alternative query to get available time slots
-- This will show ALL slots, even if they're full

SET @target_date = '2024-10-17';

-- Show all time slots with availability status
SELECT 
    TIME_FORMAT(sgh.start_time, '%h:%i %p') as 'Start Time',
    TIME_FORMAT(sgh.end_time, '%h:%i %p') as 'End Time',
    sgh.max_booking as 'Max Capacity',
    COALESCE(COUNT(sb.id), 0) as 'Current Bookings',
    (sgh.max_booking - COALESCE(COUNT(sb.id), 0)) as 'Available Spots',
    CASE 
        WHEN (sgh.max_booking - COALESCE(COUNT(sb.id), 0)) > 0 THEN '✅ AVAILABLE'
        ELSE '❌ FULL'
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

-- If you want ONLY available slots, use this:
SELECT 
    TIME_FORMAT(sgh.start_time, '%h:%i %p') as 'Start Time',
    TIME_FORMAT(sgh.end_time, '%h:%i %p') as 'End Time',
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


