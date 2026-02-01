# 📸 Photography Booking Platform

A web-based platform that connects **customers**, **photographers**, and **studios** in one place, allowing users to browse portfolios, book photography sessions, and manage bookings easily.

Built with **Laravel** following a clean MVC architecture.

---

## 🚀 Project Overview

This project is a photography marketplace where:

- Customers can browse photographers and studios, view portfolios, and make bookings.
- Photographers and studios can manage their profiles, portfolios, and booking requests.
- Admin can monitor all bookings across the platform (read-only).

---

## 👥 User Roles

### 1️⃣ Customer
- Browse photographers and studios
- View public portfolios
- Book photography sessions
- View booking history
- Manage account

### 2️⃣ Photographer / Studio
- Create and manage profile
- Upload and manage portfolio
- Receive booking requests
- Approve / reject bookings
- View upcoming and completed sessions

### 3️⃣ Admin
- View all bookings in the system
- Monitor platform activity
- No booking actions (approve/reject handled by photographers & studios)

---

## 🧩 Main Features

- Authentication (Login / Register)
- Account type selection (Customer / Photographer / Studio)
- Multi-step registration for photographers & studios
- Portfolio management
- Booking system with status tracking:
  - Pending
  - Approved
  - Rejected
  - Completed
- Responsive frontend UI
- Clean and scalable database structure

---

## 🖼️ Pages & Modules

### Public Pages
- Home Page
- Photographers Listing
- Studios Listing
- Portfolio (Public View)
- About Us
- Contact Us
- Login / Sign Up

### Photographer / Studio Dashboard
- Dashboard (statistics & latest bookings)
- Bookings Management
- Booking Details
- Profile View & Edit
- Portfolio Management

### Admin Panel
- Dashboard
- View all bookings

---

## 🎨 Design & UI

- Light theme
- Warm photography-inspired color palette
- Responsive design (desktop, tablet, mobile)
- Reusable components
- Clean and minimal UI

Color Palette (Main):
- Accent Brown
- Light Background
- Dark Text
- Soft Shadows

---

## 🛠️ Tech Stack

- **Backend:** Laravel
- **Frontend:** Blade / HTML / CSS / Bootstrap
- **Database:** MySQL
- **Authentication:** Laravel Auth
- **Version Control:** Git

---

## 📂 Installation

1. Clone the repository:
   ```bash
   git clone https://github.com/your-username/project-name.git

Install dependencies:

composer install
Create .env file:

cp .env.example .env
Generate app key:

php artisan key:generate
Configure database in .env

Run migrations:

php artisan migrate
Start the server:

php artisan serve
📌 Future Enhancements
Online payments

Reviews & ratings

Notifications (Email / In-app)

Advanced search & filters

Admin analytics dashboard

✨ Author
Developed by Ruba
Photography Booking Platform –  Final Project

