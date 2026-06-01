# Task Manager API

A Trello-inspired REST API built with Laravel 11 & Sanctum.

## Tech Stack
- PHP / Laravel 11
- MySQL
- Laravel Sanctum (token authentication)

## Features
- [x] User authentication (register, login, logout)
- [x] Board management (CRUD)
- [x] List management (CRUD)
- [x] Card management (CRUD)
- [ ] Ownership authorization(in progress)
- [ ] Policies (in progress)
- [ ] Tests (in progress)

## Installation
git clone https://github.com/PureParsa/task-manager-api.git
cd task-manager-api
cp .env.example .env
composer install
php artisan key:generate
php artisan migrate
php artisan serve

## API Endpoints

### Auth
| Method | Endpoint | Description |
|--------|----------|-------------|
| POST | /api/register | Register new user |
| POST | /api/login | Get access token |
| POST | /api/logout | Revoke token |

### Boards
| Method | Endpoint | Description |
|--------|----------|-------------|
| GET | /api/boards | Get all boards |
| POST | /api/boards | Create a board |
| GET | /api/boards/{board} | Get one board |
| PATCH | /api/boards/{board} | Update a board |
| DELETE | /api/boards/{board} | Delete a board |

### Lists
| Method | Endpoint | Description |
|--------|----------|-------------|
| GET | /api/boards/{board}/lists | Get all lists |
| POST | /api/boards/{board}/lists | Create a list |
| GET | /api/boards/{board}/lists/{list} | Get one list |
| PATCH | /api/boards/{board}/lists/{list} | Update a list |
| DELETE | /api/boards/{board}/lists/{list} | Delete a list |

### Cards
| Method | Endpoint | Description |
|--------|----------|-------------|
| GET | /api/boards/{board}/lists/{list}/cards | Get all cards |
| POST | /api/boards/{board}/lists/{list}/cards | Create a card |
| GET | /api/boards/{board}/lists/{list}/cards/{card} | Get one card |
| PATCH | /api/boards/{board}/lists/{list}/cards/{card} | Update a card |
| DELETE | /api/boards/{board}/lists/{list}/cards/{card} | Delete a card |

## Design Decisions
- Used Sanctum over Passport for token auth — simpler and fits API-only use case
- Nested resource routing to reflect data hierarchy
- Form Requests for all validation — keeps controllers clean
- Scoped route binding to prevent cross-user data access
