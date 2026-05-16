# Technical Specification: Fix PolicyController and Policy Model

Fix syntax errors, duplicate methods, and logic mismatches in `PolicyController.php` and align `Policy.php` model with the database schema and views.

## Technical Context
- **Language**: PHP 8.x
- **Framework**: Laravel 11.x
- **Database**: MySQL/SQLite (based on migrations)
- **Key Models**: `Policy`, `PolicyType`, `User`

## Implementation Approach

### 1. `PolicyController.php` Refactoring
- **Consolidate `store` methods**: Remove the malformed and duplicate `store` methods. Create a single, clean `store` method that:
    - Validates input: `policy_number` (unique), `user_id` (exists), `policy_type_id` (exists), `plan_type` (Standard/Premium), `final_price` (numeric), `start_date` (date), `renewal_date` (date, after start_date), `status` (Active/Expired/Pending Renewal).
    - Uses `Policy::create($request->all())`.
    - Redirects to `policies.index` with success message.
- **Update `index` method**:
    - Use `Policy::with(['client', 'type'])->latest()->paginate(10)`.
    - Ensure it returns the correct view.
- **Update `create` method**:
    - Fetch `$clients` (Users with role 'client').
    - Fetch `$policyTypes` (All PolicyType records).
    - Pass both to the view.
- **Update `update` method**:
    - Fix validation to match schema.
    - Use `$policy->update($request->all())`.
- **Fix Syntax Errors**:
    - Remove misplaced braces and broken `validate` calls.
    - Add a proper `__construct` method for the `auth` middleware.
- **General Clean-up**:
    - Remove unused imports if any.
    - Ensure consistent return types (RedirectResponse or View).

### 2. `Policy.php` Model Updates
- **Fix Relationships**:
    - Update `client` relation to use `user_id` as the foreign key: `return $this->belongsTo(User::class, 'user_id');`.
    - Rename `policyType` relation to `type` to match `index.blade.php`: `return $this->belongsTo(PolicyType::class, 'policy_type_id');`.
- **Fillable Attributes**: Ensure all schema fields are in `$fillable`.

## Source Code Structure Changes
- **`backend/app/Http/Controllers/PolicyController.php`**: Major refactoring of methods.
- **`backend/app/Models/Policy.php`**: Relation name and foreign key fixes.

## Data Model / API / Interface Changes
- No changes to the database schema (migrations are already correct).
- Aligning Controller/Model logic with the existing schema:
    - `user_id`
    - `policy_type_id`
    - `plan_type`
    - `final_price`
    - `start_date`
    - `renewal_date`
    - `status`

## Verification Approach
1. **Linting**: Run `php -l backend/app/Http/Controllers/PolicyController.php` and `backend/app/Models/Policy.php` to check for syntax errors.
2. **Manual Verification**:
    - Access `/policies` to ensure the registry loads with client and type names.
    - Create a new policy to verify `store` logic and validation.
    - Edit and update a policy.
    - Delete a policy.
3. **Automated Tests**: If the project has tests, run `php artisan test`. (Need to check for existing tests).
