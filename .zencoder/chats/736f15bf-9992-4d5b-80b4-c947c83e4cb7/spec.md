# Technical Specification - Fix Policy Type Dropdown

The "Add New Policy" page in the mobile app fails to display policy types because of a data model mismatch between the backend and the mobile app.

## Technical Context
- **Frontend**: Flutter (Dart)
- **Backend**: Laravel (PHP)
- **Data Model**: `PolicyType`

## Investigation Findings
1. **Model Mismatch**: The mobile app's `PolicyType` model in `./mobile/lib/models.dart` expects a `base_price` field:
   ```dart
   basePrice: double.parse(json['base_price'].toString()),
   ```
2. **Backend Schema**: The backend `policy_types` table (and the response from `ApiController.getPolicyTypes`) does not have a `base_price` column. Instead, it has `standard_price` and `premium_price` to support different plan tiers.
3. **Parsing Failure**: When `ApiService.getPolicyTypes()` receives the backend response, `json['base_price']` is null. Calling `.toString()` on null (or `double.parse("null")`) causes an exception, which is caught in `AddPolicyPage._fetchPolicyTypes`, resulting in an empty dropdown and an error snackbar.

## Implementation Approach

### 1. Update Mobile Model
- Modify `PolicyType` in `./mobile/lib/models.dart` to match the backend schema.
- Replace `basePrice` with `standardPrice` and `premiumPrice`.
- Update the `fromJson` factory to map the correct keys.

### 2. Update Add Policy Page (Optional/Defensive)
- Ensure that the dropdown handles the updated `PolicyType` model.
- Since the dropdown only uses `id` and `name`, no functional changes are strictly required in the UI, but it's good to ensure no regressions.

## Source Code Structure Changes
The following file will be modified:
- `./mobile/lib/models.dart`: Update `PolicyType` class and its `fromJson` factory.

## Data Model / API / Interface Changes
- **PolicyType (Dart)**:
    - Removed: `double basePrice`
    - Added: `double standardPrice`
    - Added: `double premiumPrice`

## Verification Approach
- **Static Analysis**: Run `flutter analyze` to ensure no type errors.
- **Manual Verification**: 
    - Open the "Add New Policy" page.
    - Confirm the "Select Policy Type" dropdown is populated with actual policy types from the database.
