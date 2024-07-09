# Books and Authors API

## Project Description

This project is a Book Management application that allows users to manage books and authors. It includes functionalities such as user authentication, searching for books and authors, viewing book and author details, and performing CRUD operations.

## Table of Contents

- [Project Description](#project-description)
- [Backend API Setup](#backend-api-setup)
- [Features](#features)
- [API Endpoints](#api-endpoints)
- [Installation](#installation)
- [Running Server](#running-server)

## Backend API Setup

### Prerequisites

- PHP 7.4 or higher
- Composer
- MySQL or any other supported database
- Node.js and npm (for running the frontend)

### Installation

1. **Clone the repository:**

    ```bash
    git clone https://github.com/ahmedGMB1/book-library-api.git
    ```

2. **Install dependencies:**

    ```bash
    composer install
    ```

3. **Setup environment variables:**

    Copy the `.env.example` file to `.env` and update the database and other configurations as needed.

    ```bash
    cp .env.example .env
    ```

4. **Generate application key:**

    ```bash
    php artisan key:generate
    ```

5. **Run migrations and seed the database:**

    ```bash
    php artisan migrate --seed
    ```

6. **Generate secret key:**

    ```bash
    php artisan jwt:secret
    ```

7. **Start the server:**

    ```bash
    php artisan serve
    ```

    The API should now be running at `http://127.0.0.1:8000/api`.

### Running Tests

Run the following command to execute the tests:

```bash
php artisan test
