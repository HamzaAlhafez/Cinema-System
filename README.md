# 🎬 Cinema Management System  

Laravel 10 based web application for managing movie theaters with admin control panel and customer booking system.  

<p align="center">
  <img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo">
</p>

## ✨ Key Features  

### 👨‍💻 Admin Panel  
- 🎥 Movies Management (Add/Edit/Delete)  
- 🕒 Screenings Schedule (Date/Time/Hall)  
- 🏟️ Halls Configuration (Seats Capacity/Layout)  
- 🏷️ Promo Codes & Discounts  
- 🗂️ Categories System  

### 🎟️ User Features  
- 🔍 Browse available screenings  
- 🪑 Real-time seat selection  
- 💳 Secure ticket booking  
- ✏️ Edit/Cancel reservations  
- 💎 Loyalty Points System (Earn & Redeem)  

## 🚀 Installation  

### Prerequisites  
- PHP 8.1+  
- MySQL 8.0+  
- Composer 2.0+  

### Setup Steps  
# 1. Clone repository
git clone https://github.com/HamzaAlhafez/Cinema-System.git
cd Cinema-System

# 2. Install dependencies
composer install
npm install

# 3. Configure environment
cp .env.example .env
php artisan key:generate

# 4. Set up database
# Edit .env file with your DB credentials then:
php artisan migrate --seed

# 5. Run development server
php artisan serve
## 🔧 Admin Access  
Default admin account:  
Email: admin@cinema.com  
Password: password123  

## 📜 License  
MIT License - See [LICENSE](LICENSE) for details.  

---

<p align="center">
  <img src="https://img.shields.io/badge/Laravel-10.x-FF2D20?logo=laravel" alt="Laravel Version">
  <img src="https://img.shields.io/badge/PHP-8.1+-777BB4?logo=php" alt="PHP Version">
  <img src="https://img.shields.io/badge/MySQL-8.0+-4479A1?logo=mysql" alt="MySQL">
</p>
