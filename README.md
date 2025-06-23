# Attenlytics-API

## Description

**Attenlytics-API** is a web application built with Laravel, designed to analyze the **attention** and **relaxation states** of participants using brainwave data with software **Attenlytics**. The software helps in monitoring and evaluating cognitive states in real-time, useful for research and productivity analysis.

## Features

- Analysis of attention and relaxation states  
- Participant data tracking  
- EEG data integration and visualization  
- Real-time session monitoring  

---

## Tech Stack

- **Framework:** Laravel 10 (PHP)  
- **Database:** MySQL (or any Laravel-supported DB)  
- **Frontend:** Blade (or your choice of frontend stack)  

---

## Laravel Highlights

Laravel is a modern PHP framework that emphasizes developer experience, scalability, and elegant syntax. It simplifies many common web development tasks:

- [Simple & fast routing engine](https://laravel.com/docs/routing)  
- [Powerful dependency injection container](https://laravel.com/docs/container)  
- Multiple backends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage  
- [Intuitive Eloquent ORM](https://laravel.com/docs/eloquent) for working with databases  
- [Database migrations](https://laravel.com/docs/migrations) and seeders  
- [Queue and job processing](https://laravel.com/docs/queues)  
- [Real-time broadcasting](https://laravel.com/docs/broadcasting)  

---

## Installation & Setup

### Prerequisites

- PHP 8.1 or later  
- Composer  
- Laravel 10 requirements (OpenSSL, PDO, Mbstring, etc.)  
- MySQL or equivalent database  

### Setup Instructions

1. Clone the repository:
   ```bash
   git clone <repo-url>
   cd <project-folder-name>
   ```

2. Install dependencies:
   ```bash
   composer update
   ```

3. Create `.env` file and configure your database.

4. Run database migrations and seeders:
   ```bash
   php artisan migrate:fresh --seed
   ```

5. Start the development server:
   ```bash
   php artisan serve
   ```

---

## Credentials

    - Superadmin:
        email: superadmin@gmail.com
        password: 12345678

---

## License

This project is licensed under the MIT License.
