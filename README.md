<!-- Para abrir el preview en Atom: ^ (control) + shift + M -->

# README for Your GitHub Mono-Repo

## Table of Contents
- [Project Structure](#project-structure)
- [API Overview](#api-overview)
  - [API Routes](#api-routes)
  - [API Setup Instructions](#api-setup-instructions)
  - [API Swagger Documentation](#api-swagger-documentation)
- [Client Application Overview](#client-application-overview)
  - [Client Setup Instructions](#client-setup-instructions)
  - [Usage](#usage)

## Project Structure
| Directory | Description |
|:---------:|:------------|
| `api/` | Contains the Laravel API. |
| `client_example/` | Contains the Vue.js client application. |

## API Overview

### API Routes
#### Public Routes
- `POST /api/register` - Register a new user.
- `POST /api/login` - Login an existing user.

#### Protected Routes
- `GET, POST, PUT, DELETE /api/todos` - CRUD operations on todo items.
- `GET /api/logout` - Logout the current user.

### API Setup Instructions
```bash
# Clone the repository
git clone <repository-url>

# Navigate to the API directory
cd api

# Install dependencies
composer install

# Setup the environment file
cp .env.example .env

# Generate the application key
php artisan key:generate

# Run migrations
php artisan migrate --seed

# Generate Keys for Passport Auth
php artisan passport:keys

# Creating a Personal Access Client for Passport Auth
php artisan passport:client --personal

# Start the server
php artisan serve --port=8000
```
### API Swagger Documentation

To access the interactive Swagger API documentation, navigate to the following URL in your web browser: http://localhost:8000/api/documentation

## Client Application Overview
### Client Setup Instructions
```bash
# Navigate to the client_example directory
cd client_example

# Install dependencies
npm install

# Run the development server
npm run dev
```
### Usage
Open your browser and navigate to http://localhost:5173 to interact with the client application.

