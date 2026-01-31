---
description: Fix Redundancy Issues in Laravel Project
---
### Goal
Eliminate duplicated validation, role handling, seeder data, and Blade markup.

### Applied Changes
1. **Centralized Validation**: Created `App\Http\Requests\Auth\RegisterUserRequest` to handle registration validation.
2. **Centralized Role Logic**: Created `App\Services\RoleResolver` to determine user roles consistently across the app.
3. **Cleaned Seeders**: 
   - Created `AdminUserSeeder` for a single source of truth for admin users.
   - Refactored `DatabaseSeeder` and `DemoSeeder` to use `AdminUserSeeder`.
4. **Reusable UI Components**: Created `x-form.input` Blade component to reduce boilerplate in authentication views.
5. **Removed Dead Code**: Deleted redundant `RegisterController`.

### How to Maintain
- **Validation**: When adding fields to registration, update `RegisterUserRequest`.
- **Roles**: If adding new roles (e.g., `moderator`), update `RoleResolver::resolve()`.
- **UI**: Use `<x-form.input />` for all new form fields to maintain consistent styling and error handling.

### Verification Commands
// turbo
php artisan test
// turbo
php artisan db:seed --class=AdminUserSeeder
