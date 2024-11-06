# URL Shortener API

This is a URL Shortener API built using Laravel, featuring user registration, login via Sanctum, URL shortening, and more. The API supports two versions (v1 and v2), each adding enhancements and new features.

## Features

### Version 1 (v1)

- **User Registration**: Users can register an account.
- **User Login**: Users can log in to retrieve an API key (via Sanctum) to access protected endpoints.
- **URL Shortening**: Users can submit a long URL to get a shortened one.
  - If the same long URL is submitted multiple times, the same shortened URL will be returned.
- **Unique Short URLs**: All shortened URLs are unique to avoid collisions.
- **URL List**: Users can retrieve a list of all URLs they have shortened.
- **URL Redirection**: A simple web route allows shortened URLs to redirect to their original URLs when accessed via the browser.

### Version 2 (v2)

- **Visit Count**: Keeps track of how many times each shortened URL has been visited.
- **Custom Short URLs**: Users can customize their shortened URLs.
- **URL Creation Limit**: Users are limited to creating a maximum of 15 shortened URLs by default (configurable via `.env`).
- All features from **v1** are retained.

## API Endpoints

### v1 Endpoints

| Method | URI                          | Description                                 |
|--------|------------------------------|---------------------------------------------|
| POST   | `/api/v1/register`            | Register a new user                        |
| POST   | `/api/v1/login`               | Log in to get an API key                   |
| POST   | `/api/v1/logout`              | Log out                                    |
| GET    | `/api/v1/profile`             | Get user profile information               |
| GET    | `/api/v1/urls`                | Get the list of shortened URLs             |
| POST   | `/api/v1/urls`                | Shorten a new URL                          |
| GET    | `/api/v1/urls/{url}`          | Retrieve details of a shortened URL        |
| DELETE | `/api/v1/urls/{url}`          | Delete a shortened URL                     |
| GET    | `/{url}`                      | Redirect shortened URL to the original URL |

### v2 Endpoints

| Method  | URI                          | Description                                 |
|---------|------------------------------|---------------------------------------------|
| POST    | `/api/v2/register`            | Register a new user                        |
| POST    | `/api/v2/login`               | Log in to get an API key                   |
| POST    | `/api/v2/logout`              | Log out                                    |
| GET     | `/api/v2/profile`             | Get user profile information               |
| GET     | `/api/v2/urls`                | Get the list of shortened URLs with visit counts |
| POST    | `/api/v2/urls`                | Shorten a new URL                           |
| GET     | `/api/v2/urls/{url}`          | Retrieve details of a shortened URL with visit counts |
| DELETE  | `/api/v2/urls/{url}`          | Delete a shortened URL                     |
| PUT   | `/api/v2/urls/{url}`            | Update a shortened URL (e.g., customize it)|
| GET     | `/{url}`                      | Redirect shortened URL to the original URL |

## Configuration

### .env File

- **URL Creation Limit**: The default URL creation limit per user is `15`. You can adjust this by setting the following in your `.env` file:

  ```env
  URL_CREATION_LIMIT=15
## Getting Started

### Prerequisites

- PHP 8.1+
- Laravel 11
- Composer
- MySQL or SQLITE or another supported database

### Installation

1. **Clone the repository**:

   ```bash
   git clone https://github.com/RoyHridoy/url-shortener.git
   cd url-shortener
2. **Install dependencies**:

   ```bash
   composer install
3. **Set up the .env file**:

   ```bash
    cp .env.example .env
    php artisan key:generate
4. **Set up the database credentials in the .env file and run migrations**:
   ```bash
    php artisan migrate
5. **Serve the application:**:
   ```bash
    php artisan serve
## License

This project is open-sourced software licensed under the [MIT License](https://opensource.org/licenses/MIT).
