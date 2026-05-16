# Technical Specification - Dark Mode Feature

## Technical Context
- **Web App**: Laravel 11, Tailwind CSS, Alpine.js.
- **Mobile App**: Flutter 3.x, `provider` or simple `setState` with `shared_preferences`.

## Implementation Approach

### 1. Web Application (Laravel)
- **Strategy**: Use Tailwind CSS's `selector` strategy for dark mode.
- **Toggle**: Add a theme toggle button in the top navbar (near the user profile).
- **Persistence**: Store the user's theme preference in `localStorage`.
- **Styling**: 
  - Update `app.blade.php` to include the `dark` class on the `html` element based on the saved preference.
  - Apply `dark:` variants to key components (sidebar, cards, tables, text).
  - Ensure the "Zimnat Blue" and "Zimnat Green" remain accessible or have dark-optimized variants.

### 2. Mobile Application (Flutter)
- **Strategy**: Utilize Flutter's built-in `ThemeMode` and `darkTheme` property in `MaterialApp`.
- **Toggle**: Add a "Dark Mode" switch in the navigation drawer or a new "Settings" page.
- **Persistence**: Store the preference using the existing `shared_preferences` package.
- **Styling**:
  - Define a `darkTheme` using `ThemeData.dark()` with customized Zimnat colors.
  - Ensure all hardcoded colors (e.g., `0xFF004a99`) are replaced with `Theme.of(context).colorScheme` references where possible, or have dark variants.

## Source Code Structure Changes
- **Web**:
  - Modify `./backend/resources/views/layouts/app.blade.php` (toggle logic and base styles).
  - Modify `./backend/resources/views/dashboard.blade.php` and other view files for `dark:` class support.
- **Mobile**:
  - Modify `./mobile/lib/main.dart` (theme management logic).
  - Modify `./mobile/lib/home_page.dart` (UI toggle).
  - Modify custom pages to respect theme changes.

## Data Model / API / Interface Changes
- No backend database changes required (persistence is client-side).
- No API changes required.

## Verification Approach
- **Web**: Manual testing in browser (Chrome/Firefox) ensuring no "flashes" of light mode on reload.
- **Mobile**: Manual testing on emulator/device, toggling theme and verifying all pages remain readable and aesthetically pleasing.
