# ProjectHub API

A simple project management REST API built with Laravel.
The API allows users to manage projects, tasks, and comments while demonstrating clean architecture practices and modern Laravel development patterns.

---

## 🚀 Features

* Projects management
* Tasks management within projects
* Comments on tasks
* RESTful API design
* Service Layer architecture
* Request validation
* API Resources for response formatting
* Feature testing
* Dockerized development environment using Laravel Sail

---

## 🧱 Tech Stack

* PHP
* Laravel
* MySQL
* Docker
* Laravel Sail
* PHPUnit

---

## 📁 Project Architecture

The project follows a layered architecture to keep the codebase clean and maintainable.

```
app
 ├── Http
 │   ├── Controllers
 │   ├── Requests
 │   └── Resources
 │
 ├── Models
 │
 ├── Services
 │   ├── BaseService.php
 │   ├── ProjectService.php
 │   ├── TaskService.php
 │   └── CommentService.php
```

### Architecture Overview

* **Controllers**
  Handle incoming HTTP requests and responses.

* **Requests**
  Responsible for validation logic.

* **Services**
  Contain business logic and database operations.

* **Resources**
  Transform models into consistent JSON responses.

* **BaseService**
  Provides reusable CRUD logic and query helpers.

---

## 📊 Database Structure

### Projects

* id
* name
* description
* owner_id
* timestamps

### Tasks

* id
* project_id
* title
* description
* status
* assigned_to
* created_by
* due_date
* timestamps

### Comments

* id
* task_id
* user_id
* content
* timestamps

---

## ⚙️ Installation

Clone the repository:

```bash
git clone https://github.com/YOUR_USERNAME/projecthub-api.git
cd projecthub-api
```

Install dependencies:

```bash
composer install
```

Copy environment file:

```bash
cp .env.example .env
```

Start Docker containers:

```bash
./vendor/bin/sail up -d
```

Generate application key:

```bash
./vendor/bin/sail artisan key:generate
```

Run migrations:

```bash
./vendor/bin/sail artisan migrate
```

---

## 🧪 Running Tests

Run the test suite using:

```bash
./vendor/bin/sail artisan test
```

The project includes **Feature tests** to verify API endpoints and database interactions.

---

## 📡 API Endpoints

### Projects

```
GET    /api/projects
POST   /api/projects
GET    /api/projects/{id}
PUT    /api/projects/{id}
DELETE /api/projects/{id}
```

### Tasks

```
GET    /api/tasks
POST   /api/tasks
GET    /api/tasks/{id}
PUT    /api/tasks/{id}
DELETE /api/tasks/{id}
```

### Comments

```
GET    /api/comments
POST   /api/comments
GET    /api/comments/{id}
PUT    /api/comments/{id}
DELETE /api/comments/{id}
```

---

## 🧪 Example API Response

```
GET /api/projects/1
```

```json
{
  "data": {
    "id": 1,
    "name": "ProjectHub",
    "description": "Simple project management API",
    "tasks": []
  }
}
```

---

## 🎯 Purpose of the Project

This project was built as a portfolio backend project to demonstrate:

* REST API design
* Laravel service architecture
* Clean code practices
* Testing
* Docker-based development environments

---

## 👨‍💻 Author

**Omar Nour El Din**

Backend Developer

---

## 📄 License

This project is open-source and available for learning purposes.
