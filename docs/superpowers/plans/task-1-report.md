# Task 1 Report: Validate Chấm Công Thủ Công Admin

## Overview
Implemented the check_in and check_out validation in `storeAttendance` method under `app/Http/Controllers/AdminHrmController.php` to prevent situations where check-out time is earlier than or equal to check-in time.

## Test Process
1. **Manual Validation Analysis**:
   - Assessed Laravel's built-in validation rules (`after:check_in_at`). Submitting identical values (e.g., `00:59` and `00:59`) correctly triggers the validator error `"Giờ ra phải sau giờ vào."`.
   - Verified that a custom validation layer checking `lte` status on parsed Carbon instances of check-in and check-out runs safely after the standard validate.

2. **Automated Unit Testing**:
   - Modified `tests/Feature/AdminAttendancePageTest.php` to add a new test case `loi_validate_cham_cong_khi_check_in_bang_check_out`.
   - This test mocks an admin requesting to store attendance for an employee with both `check_in_at` and `check_out_at` set to `'00:59'`.
   - The test asserts that the route redirects back to the index view, displaying a validation error list container and the message `"Giờ ra phải sau giờ vào."`.

3. **Running the Test Suite**:
   - Executed PHPUnit tests via the vendor utility block.

## Test Results
- All **27 tests** in the application suite passed, including the new feature check for equal check-in and check-out times.
- Result: **SUCCESS**. Attendance logs with logically incorrect check-out times are now successfully prevented.
