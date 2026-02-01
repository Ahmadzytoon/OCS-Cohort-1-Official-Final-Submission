# Mentory

## Project Description

Mentory is an educational web platform built with **Laravel** that connects **Tawjihi / high-school students in Jordan** with **qualified teachers** in a structured and secure way.  
The platform allows students to browse approved teacher profiles, send learning requests, rate teachers after completion, and communicate through an integrated chatbot.  
It also provides full administrative control for managing users, reviews, and teacher approvals.

---

## Features

- **Role-Based System:** Admin – Student – Teacher
- **Authentication:** Registration & Login using Laravel Breeze
- **Teacher Profiles:** Teachers create profiles that appear only after admin approval
- **Student Requests:** Students can send **one active request at a time**
- **Request Workflow:** Pending → Accepted / Rejected → Completed
- **Reviews & Ratings:** Students can review teachers only after completing a request
- **Favorites System:** Students can add teachers to a favorites list
- **Review Reporting:** Any logged-in user can report inappropriate reviews
- **Admin Dashboard:**
    - Approve or reject teacher profiles
    - Manage students and teachers
    - Delete abusive reviews
    - View reported reviews
- **Chatbot Integration:** Google Gemini API for platform guidance and basic academic help
- **Error Monitoring:** Integrated with Sentry
- **Optimized Performance:** Eloquent relationships & no heavy queries inside Blade views

---

## Technologies & Tools Used

- **Backend:** Laravel 11 (PHP)
- **Frontend:** Blade Templates, Bootstrap
- **Database:** MySQL
- **Authentication:** Laravel Breeze
- **ORM:** Eloquent Relationships
- **AJAX / Fetch API**
- **APIs:** Google Gemini API (Chatbot)
- **Monitoring:** Sentry
- **Tools:** GitHub, phpMyAdmin, VS Code

---

## Demo Link

(Optional)
