
# Laravel + Vue 3 CRUD Application

## Project Overview

This is a full-stack web application built with **Laravel 12** (backend) and **Vue 3** (frontend) implementing a **CRUD system** with user authentication. The application allows users to **Create, Read, Update, and Delete** tasks (or any other chosen module), while securely managing authenticated operations via **Laravel Sanctum**.

---

## Features

### Backend (Laravel)

* Complete **RESTful API** for the chosen module (Tasks)
* **Authentication** using Laravel Sanctum
* Input validation and meaningful error responses
* Modular and clean folder structure:

  * Controllers
  * Services
  * Resources
* API endpoints:

  * `POST /api/register` – User registration
  * `POST /api/login` – User login
  * `GET /api/tasks` – List tasks
  * `POST /api/tasks` – Create task
  * `GET /api/tasks/{id}` – View single task
  * `PUT /api/tasks/{id}` – Update task
  * `DELETE /api/tasks/{id}` – Delete task
* Task model fields:

  * `title` – string
  * `description` – string
  * `status` – pending / in_progress / completed
  * `priority` – low / medium / high
  * `due_date` – date

### Frontend (Vue 3)

* Single Page Application (SPA) with Vue 3 and TypeScript
* Pages included:

  * **Login Page** – User authentication
  * **Register Page** – User registration
  * **Task List Page** – View all tasks
  * **Task Create/Edit Modal** – Add or update tasks
* Features:

  * Interactive **task CRUD operations**
  * Task **status update** (pending / in progress / completed)
  * Task **priority display**
  * Responsive layout using **Tailwind CSS**
  * Toast notifications for **create, update, delete actions**
  * Confirmation modals for deletion
  * Paginated task list display

---

## Technologies Used

**Backend:**

* PHP 8+ / Laravel 12
* Laravel Sanctum for API authentication
* MySQL / MariaDB (or any relational database)
* Composer for dependency management

**Frontend:**

* Vue 3 + TypeScript
* Vue Router for SPA navigation
* Pinia for state management
* Axios for API requests
* Tailwind CSS for styling
* Optional: Vite as the build tool

---

## Installation & Setup

### Backend

1. Clone the repository:

   ```bash
   git clone <repository-url>
   cd backend
   ```
2. Install dependencies:

   ```bash
   composer install
   ```
3. Copy `.env.example` to `.env` and set up database credentials:

   ```bash
   cp .env.example .env
   ```
4. Generate application key:

   ```bash
   php artisan key:generate
   ```
5. Run migrations:

   ```bash
   php artisan migrate
   ```
6. Start Laravel server:

   ```bash
   php artisan serve
   ```

### Frontend

1. Navigate to frontend folder:

   ```bash
   cd frontend
   ```
2. Install dependencies:

   ```bash
   npm install
   ```
3. Start development server:

   ```bash
   npm run dev
   ```
4. Make sure the Vite proxy is correctly pointing to the backend API (`http://127.0.0.1:8000 or http://localhost:8000`).

---

## Usage

1. Open the app in your browser (`http://localhost:5173`).
2. Register a new account or login using an existing user.
3. After login, you can:

   * View all tasks
   * Create a new task
   * Edit or delete a task
   * Update task status
4. All actions are performed through the API, and notifications appear for successful operations.

---

## Folder Structure

**Backend (Laravel)**

```
app/
 ├─ Http/
 │   ├─ Controllers/
 │   └─ Requests/
 ├─ Models/
 ├─ Services/
 └─ Resources/
routes/
 └─ api.php
```

**Frontend (Vue 3)**

```
src/
 ├─ components/
 ├─ pages/
 ├─ router/
 ├─ store/
 ├─ services/  (API calls)
 └─ App.vue
```

---

## API Endpoints

| Method | Endpoint        | Description      |
| ------ | --------------- | ---------------- |
| POST   | /api/register   | Register user    |
| POST   | /api/login      | Login user       |
| GET    | /api/tasks      | Get all tasks    |
| POST   | /api/tasks      | Create new task  |
| GET    | /api/tasks/{id} | Get task details |
| PUT    | /api/tasks/{id} | Update task      |
| DELETE | /api/tasks/{id} | Delete task      |
