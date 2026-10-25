# GenZ Digital - Campus OS

A modern campus management system and digital student pass platform built with Laravel 11, Bootstrap 5.3, and MySQL.

## Features
- **Student Portal**: Real-time student pass, timetable, score & GPA viewing, library books, and campus resources.
- **Admin Console**: User management (enrollment lifecycle), attendance monitoring with session tracking, live screen spotlighting, random picker games, and challenge management.
- **QR Code Attendance**: Multi-session QR code scanner and 6-digit passcode check-in with geolocation support.
- **Modern Responsive UI**: Mobile-first design, dark/light theme switching, and Google Sans Khmer typography.

## Setup Instructions

1. **Clone the repository**:
   ```bash
   git clone https://github.com/navasealzy9/genzdigital.git
   cd genzdigital
   ```

2. **Install dependencies**:
   ```bash
   composer install
   npm install
   ```

3. **Configure environment**:
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Database migration & seeding**:
   ```bash
   php artisan migrate --seed
   ```

5. **Start development server**:
   ```bash
   php artisan serve
   ```
