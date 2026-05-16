# Spec and build

## Agent Instructions

Ask the user questions when anything is unclear or needs their input. This includes:

- Ambiguous or incomplete requirements
- Technical decisions that affect architecture or user experience
- Trade-offs that require business context

Do not make assumptions on important decisions — get clarification first.

---

## Workflow Steps

### [x] Step: Technical Specification
(Completed for Dark Mode)

---

### [ ] Step: Implementation

#### [ ] Task 1: Web App Dark Mode - Base Implementation
Update `./backend/resources/views/layouts/app.blade.php` to support Tailwind dark mode.
- Add Alpine.js logic to manage `darkMode` state.
- Add a theme toggle button in the header.
- Apply `dark` class to the root `<html>` element.
- Verification: `php artisan serve` and toggle theme in browser.

#### [ ] Task 2: Web App Dark Mode - Component Styling
Apply `dark:` variants to main layout components.
- Style the sidebar, header, and main background.
- Update `./backend/resources/views/dashboard.blade.php` and `./backend/resources/views/policies/index.blade.php` for card and table readability in dark mode.
- Verification: Visually inspect all major pages in dark mode.

#### [ ] Task 3: Mobile App Dark Mode - Theme Logic
Update `./mobile/lib/main.dart` to support `ThemeMode`.
- Implement a `ChangeNotifier` or simple state management to toggle between light and dark themes.
- Use `shared_preferences` to persist the theme choice.
- Verification: `flutter run` and verify theme persists across app restarts.

#### [ ] Task 4: Mobile App Dark Mode - UI Implementation
Add a theme toggle in the mobile app and update UI components.
- Add a switch or button in the `HomePage` drawer to toggle dark mode.
- Ensure `HomePage`, `AddPolicyPage`, and `PolicyDetailsPage` look correct in dark mode.
- Verification: Manually test theme switching on an emulator or device.

#### [ ] Task 5: Post-Implementation Report
Update `./.zencoder/chats/736f15bf-9992-4d5b-80b4-c947c83e4cb7/report.md` with dark mode implementation details.
