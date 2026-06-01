# Zimnat Policy Management System

A simple digital system to manage insurance policies and improve communication with clients.

## Link to mobile app funtionality video
https://www.loom.com/share/183f2d4ded3548c490615558531fa043


## Features
- **Web Application (Staff):** Admin & Policy Officers can manage policies, upload documents, and respond to client queries.
- **Mobile Application (Clients):** Clients can view their policies, track renewal dates, view documents, and raise queries.

## Technologies
- **Backend:** Laravel 11 (PHP 8.5)
- **Database:** MySQL / SQLite
- **Mobile:** Flutter 3.41
- **API:** Laravel Sanctum


## Prerequisites

Ensure you have the following installed on your system:

### Windows
- **PHP 8.2+**: Download from [php.net](https://windows.php.net/download/) or use [Laravel Herd](https://herd.laravel.com/).
- **Composer**: Download from [getcomposer.org](https://getcomposer.org/download/).
- **Node.js & NPM**: Download from [nodejs.org](https://nodejs.org/).
- **Flutter SDK**: Follow the [Windows installation guide](https://docs.flutter.dev/get-started/install/windows).
- **Android Studio / VS Code**: For mobile development.

### macOS
- **Homebrew**: Install from [brew.sh](https://brew.sh/).
- **PHP, Composer, Node.js**:
  ```bash
  brew install php composer node
  ```
- **Flutter SDK**: Follow the [macOS installation guide](https://docs.flutter.dev/get-started/install/macos).
- **Xcode & Android Studio**: For iOS and Android development.

### Linux (Ubuntu/Debian)
- **PHP, Composer, Node.js**:
  ```bash
  sudo apt update
  sudo apt install php composer nodejs npm
  ```
- **Flutter SDK**: Follow the [Linux installation guide](https://docs.flutter.dev/get-started/install/linux).
- **Android Studio / VS Code**: For mobile development.

## Setup Instructions

### Backend (Laravel)
1. Navigate to the `backend` directory.
2. Install dependencies:
   ```bash
   composer install
   npm install
   ```
3. Configure your `.env` file (copy from `.env.example`).
   - For MySQL, update `DB_*` variables.
   - For SQLite (default), ensure `database/database.sqlite` exists.
4. Generate application key:
   ```bash
   php artisan key:generate
   ```
5. Run migrations and seed the database:
   ```bash
   php artisan migrate --seed
   ```
6. Start the development server:
   ```bash
   php artisan serve
   ```

### Mobile App (Flutter)
1. Navigate to the `mobile` directory.
2. Install dependencies:
   ```bash
   flutter pub get
   ```
3. Update the API base URL in `lib/api_service.dart`:
   - Use `10.0.2.2` for Android Emulator.
   - Use `localhost` for iOS Simulator.
4. Run the application:
   ```bash
   flutter run
   ```

## Test Credentials
- **Admin:** `admin@zimnat.co.zw` / `password`
- **Policy Officer:** `officer@zimnat.co.zw` / `password`
- **Client:** `client@example.com` / `password`

## Assumptions Made
1. The system assumes a stable internet connection for mobile-to-backend communication.
2. File uploads are stored locally in the `storage/app/public` directory.
3. Policy numbers are unique across the system.
4. Clients are pre-registered by staff members (or through the seeder).
5. Premiun and standard prices are predefined base prices 


## AI Disclosure
* Developed and maintained entirely by the author.
* Utilized Copilot and Zencoder for real-time error checking and debugging assistance.


## common ways to query my database
use tinker by running the following command
php artisan tinker

you can then start querying data
  User::all();
  Policy::all();
  etc


  or you can use sqlite directly in the command line
     sqlite3 backend/database/database.sqlite
     
