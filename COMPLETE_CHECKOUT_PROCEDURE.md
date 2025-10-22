# Complete Booking & Checkout Procedure Guide

## 📋 Overview

This document explains the complete step-by-step checkout process for your service booking system.

## 🎯 Complete Booking Flow (4 Steps)

### **STEP 1: Date & Time Selection** ⏰

**What Happens:**
1. User clicks **"Book Now"** button on a service
2. Modal/popup opens with booking stepper
3. Shows calendar with available dates
4. User selects a date
5. Dropdown appears with available time slots
6. User selects a time slot from dropdown
7. **"Next Step"** button appears
8. User clicks "Next Step" → moves to Step 2

**Technical Details:**
- Calendar uses `pignoseCalendar` plugin
- Disabled dates = holidays & unavailable days
- AJAX call: `/services/show-general-hour/{serviceId}`
- Response: HTML dropdown with time slots
- Selection triggers: `$('#time_slot_select').change()`

---

### **STEP 2: Information & Billing Details** 📝

**Scenario A: User NOT Logged In**

1. Shows **Login Form** with:
   - Username field
   - Password field
   - Google reCAPTCHA (if enabled)
   - "Login" button
   - "Proceed as guest checkout" button

2. **Option 1:** User logs in
   - Form submits via AJAX to `/services/login`
   - On success: Shows billing form with pre-filled data
   
3. **Option 2:** User clicks "Guest Checkout"
   - Login form hides
   - Billing form appears (empty fields)

**Scenario B: User Already Logged In**

1. Billing form shows immediately with pre-filled data:
   - Name (from user account)
   - Phone (from user account)
   - Email (from user account)
   - Address (from user account)
   - Postcode/Zip (from user account)
   - Country (from user account)

**User Actions:**
1. Fill/verify all required fields (*)
2. Click **"Next Step"**
3. Form submits via AJAX to `/services/billing`
4. Validation occurs server-side
5. On success: Data stored in session
6. Moves to Step 3

**Required Fields:**
- ✅ Name
- ✅ Phone
- ✅ Email
- ✅ Address
- ⚪ Postcode/Zip (optional)
- ⚪ Country (optional)

**Hidden Fields Passed:**
- `booking_date` - Selected date
- `service_hour_id` - Selected time slot ID
- `staff_id` - Staff assignment (if any)
- `user_id` - User ID (if logged in)
- `max_person` - Number of people (if applicable)

---

### **STEP 3: Payment Method Selection** 💳

**What User Sees:**
1. **Payment Method Dropdown** with options:
   - Online: Stripe, Authorize.net, PayPal, Razorpay, etc.
   - Offline: Bank Transfer, Cash on Delivery, etc.

2. **When User Selects "Stripe":**
   - Card input field appears
   - Powered by Stripe Elements
   - Secure tokenization

3. **When User Selects "Authorize.net":**
   - Card Number field
   - Expiry Month field
   - Expiry Year field
   - CVV/Card Code field

4. **When User Selects "Offline Gateway":**
   - Shows payment instructions
   - Shows bank details (if configured)
   - Optional: File upload for payment proof

**Payment Process:**

**For Online Payments (Stripe):**
1. User enters card: `4242 4242 4242 4242` (test card)
2. Expiry: Any future date (e.g., `12/25`)
3. CVC: Any 3 digits (e.g., `123`)
4. Clicks **"Make Payment"**
5. JavaScript creates Stripe token
6. Token added to form
7. Form submits to `/service/payment`
8. Server processes payment with Stripe API
9. On success: Creates booking record
10. Moves to Step 4

**For Offline Payments:**
1. User reads instructions
2. Optionally uploads payment proof
3. Clicks **"Make Payment"**
4. Form submits to `/service/payment`
5. Booking created with status: "Pending"
6. Admin must approve manually
7. Moves to Step 4

**What Happens on Server:**

```php
// ServicePaymentController.php

1. Validate payment gateway selection
2. Store all data in session
3. Route to appropriate payment handler:
   - Stripe → StripeController
   - PayPal → PayPalController
   - Offline → OfflineController
   etc.
   
4. Payment Handler:
   - Process payment with gateway API
   - Create booking record in database
   - Generate unique order number
   - Send confirmation emails
   - Return to success page
```

**Database Record Created:**
```sql
service_bookings table:
- order_number: BOK123456789
- service_id: The service being booked
- vendor_id: Service provider
- user_id: Customer
- staff_id: Assigned staff (if any)
- booking_date: 2024-10-17
- start_date: 09:00:00
- end_date: 10:00:00
- customer_paid: 99.99
- currency_text: USD
- payment_method: Stripe
- payment_status: completed
- order_status: pending (awaiting approval)
- gateway_type: online
```

---

### **STEP 4: Confirmation** ✅

**What User Sees:**
1. **Success Image** (checkmark icon)
2. **Congratulations Message:**
   - For online: "You have booked this service successfully"
   - For offline: "Wait for the payment confirmation mail"

3. **Booking Details Card:**
   - **Booking Number:** #BOK123456789
   - **Service Title:** (with link to service)
   - **Booking Date:** Oct 17, 2024
   - **Appointment Date:** Oct 20, 2024
   - **Appointment Time:** 09:00 AM - 10:00 AM
   - **Vendor:** Admin or Vendor Name
   - **Paid Amount:** $99.99
   - **Paid Via:** Stripe
   - **Payment Status:** Completed/Pending/Rejected

4. **Close Button** - Dismisses modal

**What Happens in Background:**
1. Booking record saved in database
2. **Emails Sent:**
   - Customer: Booking confirmation
   - Vendor/Admin: New booking notification
3. Session data cleared
4. Success message stored in session
5. Calendar event created (if integration enabled)
6. Zoom meeting created (if integration enabled)

---

## 🔄 Complete Data Flow

```
┌─────────────────┐
│  1. Select Date │
│   & Time Slot   │
└────────┬────────┘
         │
         ├─→ booking_date
         ├─→ service_hour_id
         ├─→ staff_id
         │
┌────────▼────────┐
│  2. Fill Billing│
│     Details     │
└────────┬────────┘
         │
         ├─→ name
         ├─→ phone
         ├─→ email
         ├─→ address
         ├─→ zip_code
         ├─→ country
         ├─→ user_id
         │
┌────────▼────────┐
│  3. Select      │
│   Payment       │
└────────┬────────┘
         │
         ├─→ gateway (stripe/paypal/etc)
         ├─→ stripeToken (if Stripe)
         │
┌────────▼────────┐
│  4. Process     │
│    Payment      │
└────────┬────────┘
         │
         ├─→ Create booking
         ├─→ Send emails
         ├─→ Show confirmation
         │
┌────────▼────────┐
│  5. Complete!   │
│   Show Details  │
└─────────────────┘
```

---

## 🛠️ Key Routes & Controllers

### Frontend Routes (routes/web.php)
```php
// Booking Modal
GET  /services/services-staff-content/{id}  → Load modal content
GET  /services/general-date-time/{id}       → Get available dates
GET  /services/show-general-hour/{id}       → Get time slots

// Authentication
POST /services/login                         → Customer login

// Billing
GET  /services/billing                       → Validate billing info

// Payment
POST /service/payment                        → Process payment
GET  /services/payment-success/{id}          → Success page

// Session
POST /services/session/forget                → Clear session on close
```

### Controllers Involved
1. **ServiceController.php** - Main booking logic
2. **ServicePaymentController.php** - Payment routing
3. **StripeController.php** - Stripe payments
4. **PayPalController.php** - PayPal payments
5. **OfflineController.php** - Offline payments

---

## 📧 Email Notifications

### Customer Receives:
1. **Booking Confirmation Email**
   - Booking number
   - Service details
   - Appointment date & time
   - Vendor/staff information
   - Payment receipt

### Vendor/Admin Receives:
1. **New Booking Notification**
   - Customer information
   - Service details
   - Appointment schedule
   - Payment status

### Email Templates Location:
- Database: `mail_templates` table
- Blade: `resources/views/email/` directory

---

## 💡 Important Session Variables

```php
// During checkout:
Session::get('serviceData') = [
    'service_id' => 30,
    'vendor_id' => 0,
    'booking_date' => '2024-10-17',
    'service_hour_id' => 123,
    'staff_id' => null,
    'name' => 'John Doe',
    'email' => 'john@example.com',
    'phone' => '1234567890',
    'address' => '123 Main St',
    'zip_code' => '12345',
    'country' => 'USA',
    'user_id' => 45,
    'max_person' => 1,
];

// After payment:
Session::get('complete') = 'payment_complete';
Session::get('paymentInfo') = BookingObject;
```

---

## 🔍 Testing the Complete Flow

### Test with Stripe Test Card:
```
Card Number: 4242 4242 4242 4242
Expiry: 12/25 (any future date)
CVC: 123 (any 3 digits)
ZIP: 12345 (any valid ZIP)
```

### Test Scenarios:

**Scenario 1: Guest Checkout with Stripe**
1. ✅ Click "Book Now"
2. ✅ Select date: Tomorrow
3. ✅ Select time: 10:00 AM - 11:00 AM
4. ✅ Click "Next Step"
5. ✅ Click "Proceed as guest checkout"
6. ✅ Fill all billing fields
7. ✅ Click "Next Step"
8. ✅ Select payment: Stripe
9. ✅ Enter test card details
10. ✅ Click "Make Payment"
11. ✅ See confirmation with booking number

**Scenario 2: Logged-in User with Offline Payment**
1. ✅ Login first
2. ✅ Click "Book Now"
3. ✅ Select date & time
4. ✅ Click "Next Step"
5. ✅ Verify pre-filled billing info
6. ✅ Click "Next Step"
7. ✅ Select "Bank Transfer"
8. ✅ Read instructions
9. ✅ Upload payment proof (if required)
10. ✅ Click "Make Payment"
11. ✅ See "Wait for confirmation" message

---

## 🐛 Common Issues & Solutions

### Issue: Payment stuck on "Processing..."
**Solution:** Check Stripe API keys in database

### Issue: Booking created but no email sent
**Solution:** Check mail configuration in `.env` file

### Issue: "Session expired" error
**Solution:** Don't keep modal open too long, complete booking within 30 minutes

### Issue: Can't select today's date
**Solution:** Time slots might be fully booked or day is set as holiday

---

## 📊 Database Tables Involved

1. **services** - Service listings
2. **service_contents** - Service translations
3. **admin_global_days** - Days of week
4. **staff_global_hours** - Time slots
5. **service_bookings** - Booking records
6. **users** - Customer accounts
7. **vendors** - Service providers
8. **online_gateways** - Payment gateway configs
9. **offline_gateways** - Offline payment methods
10. **mail_templates** - Email templates

---

## ✅ Checkout Completion Checklist

- [x] Time slots configured for all days
- [x] Dropdown showing time slots correctly
- [x] Date selection working
- [x] Time slot selection working
- [x] "Next Step" button appearing
- [x] Billing form validation working
- [x] Payment methods displaying
- [x] Stripe integration working
- [ ] **YOU TEST:** Complete a test booking
- [ ] **YOU TEST:** Verify confirmation email received
- [ ] **YOU TEST:** Check booking appears in admin panel

---

**Your booking system is ready! Follow this guide to understand the complete process.** 🎉

