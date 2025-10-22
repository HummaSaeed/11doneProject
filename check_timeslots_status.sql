-- =====================================================
-- Diagnostic Script: Check Time Slots Configuration
-- =====================================================
-- Run this to diagnose why "No Time Slot Found" appears

-- 1. Check if admin_global_days table exists and has data
SELECT '=== ADMIN GLOBAL DAYS ===' AS section;
SELECT * FROM admin_global_days ORDER BY FIELD(day, 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday');

-- 2. Check if staff_global_days table exists and has data
SELECT '=== STAFF GLOBAL DAYS ===' AS section;
SELECT * FROM staff_global_days ORDER BY FIELD(day, 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday');

-- 3. Check admin time slots (vendor_id = 0)
SELECT '=== ADMIN TIME SLOTS (vendor_id = 0) ===' AS section;
SELECT 
    sgh.id,
    sgh.vendor_id,
    agd.day,
    sgh.start_time,
    sgh.end_time,
    sgh.max_booking
FROM staff_global_hours sgh
LEFT JOIN admin_global_days agd ON agd.id = sgh.global_day_id
WHERE sgh.vendor_id = 0
ORDER BY FIELD(agd.day, 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'), sgh.start_time;

-- 4. Check vendor time slots (vendor_id != 0)
SELECT '=== VENDOR TIME SLOTS ===' AS section;
SELECT 
    sgh.id,
    sgh.vendor_id,
    sgd.day,
    sgh.start_time,
    sgh.end_time,
    sgh.max_booking
FROM staff_global_hours sgh
LEFT JOIN staff_global_days sgd ON sgd.id = sgh.global_day_id
WHERE sgh.vendor_id != 0
ORDER BY sgh.vendor_id, FIELD(sgd.day, 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'), sgh.start_time;

-- 5. Count time slots by vendor
SELECT '=== TIME SLOTS COUNT BY VENDOR ===' AS section;
SELECT 
    vendor_id,
    COUNT(*) as total_slots
FROM staff_global_hours
GROUP BY vendor_id;

-- 6. Check services and their vendors
SELECT '=== SERVICES AND VENDORS ===' AS section;
SELECT 
    s.id as service_id,
    s.vendor_id,
    COUNT(DISTINCT sc.name) as service_names
FROM services s
LEFT JOIN service_contents sc ON sc.service_id = s.id
GROUP BY s.id, s.vendor_id
ORDER BY s.id;

-- 7. Check for bookings that might be blocking slots
SELECT '=== RECENT BOOKINGS ===' AS section;
SELECT 
    sb.id,
    sb.service_id,
    sb.service_hour_id,
    sb.booking_date,
    sb.order_status,
    sb.created_at
FROM service_bookings sb
ORDER BY sb.created_at DESC
LIMIT 10;

-- 8. Summary Report
SELECT '=== SUMMARY REPORT ===' AS section;
SELECT 
    (SELECT COUNT(*) FROM admin_global_days) as admin_days_count,
    (SELECT COUNT(*) FROM staff_global_days) as staff_days_count,
    (SELECT COUNT(*) FROM staff_global_hours WHERE vendor_id = 0) as admin_slots_count,
    (SELECT COUNT(*) FROM staff_global_hours WHERE vendor_id != 0) as vendor_slots_count,
    (SELECT COUNT(*) FROM services) as total_services,
    (SELECT COUNT(*) FROM service_bookings) as total_bookings;

-- 9. Identify the problem
SELECT '=== DIAGNOSIS ===' AS section;
SELECT 
    CASE 
        WHEN (SELECT COUNT(*) FROM admin_global_days) = 0 THEN '❌ PROBLEM: admin_global_days table is empty'
        WHEN (SELECT COUNT(*) FROM staff_global_days) = 0 THEN '⚠️  WARNING: staff_global_days table is empty'
        WHEN (SELECT COUNT(*) FROM staff_global_hours WHERE vendor_id = 0) = 0 THEN '❌ PROBLEM: No admin time slots configured'
        WHEN (SELECT COUNT(*) FROM staff_global_hours WHERE vendor_id != 0) = 0 THEN '⚠️  WARNING: No vendor time slots configured'
        ELSE '✅ Time slots are configured'
    END as diagnosis;

-- 10. Recommended action
SELECT '=== RECOMMENDED ACTION ===' AS section;
SELECT 
    CASE 
        WHEN (SELECT COUNT(*) FROM staff_global_hours WHERE vendor_id = 0) = 0 
        THEN 'Run add_sample_timeslots.sql to add time slots for admin services'
        WHEN (SELECT COUNT(*) FROM staff_global_hours WHERE vendor_id != 0) = 0 
        THEN 'Add time slots through vendor panel or modify add_sample_timeslots.sql for vendors'
        ELSE 'Time slots exist. Check if the service vendor_id matches the time slot vendor_id'
    END as action;


