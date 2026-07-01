# Task Manager API

A Trello-inspired REST API built with Laravel 11 & Sanctum.

## Tech Stack
- PHP 8.4 / Laravel 13
- MySQL / MariaDB
- Laravel Sanctum (token authentication)
- Pest (feature testing)
- Docker (Nginx + PHP-FPM + MySQL)

## Features
- [x] User authentication (register, login, logout)
- [x] Board management (CRUD)
- [x] List management (CRUD)
- [x] Card management (CRUD)
- [x] Move cards between lists
- [x] Ownership authorization (Laravel Policies)
- [x] API Resources for consistent JSON responses
- [x] Form Request validation
- [x] Scoped route model binding (prevents cross-user/cross-board data access)
- [x] Feature tests (Pest) — ~30 tests covering CRUD, auth, and authorization
- [x] Docker setup (Nginx + PHP-FPM + MySQL)

## Future Improvements
- [ ] Card reordering within a list (drag-and-drop position logic)

## Docker Setup

Run the entire application with Docker — no need to install PHP, MySQL or Nginx locally.

### Requirements
- Docker Desktop

### Run with Docker

```bash
git clone https://github.com/PureParsa/task-manager-api
cd task-manager-api
cp .env.docker .env
docker-compose up -d --build
docker-compose exec app php artisan key:generate
docker-compose exec app php artisan migrate
```

Visit `http://localhost:8080/api` to confirm the app is running.

### Docker Services
| Service | Container | Port |
|---|---|---|
| PHP-FPM (Laravel) | task-manager-app | 9000 |
| Nginx | task-manager-nginx | 8080 |
| MySQL | task-manager-db | 3307 |

## Local Installation (without Docker)

```bash
git clone https://github.com/PureParsa/task-manager-api
cd task-manager-api
cp .env.example .env
composer install
php artisan key:generate
php artisan migrate
php artisan serve
```

## Running Tests
```bash
php artisan test
```

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
| PATCH | /api/boards/{board}/lists/{list}/cards/{card}/move | Move card to a different list |

## Design Decisions
- Used Sanctum over Passport for token auth — simpler and fits an API-only use case
- Nested resource routing to reflect the data hierarchy (boards → lists → cards)
- Form Requests for all validation — keeps controllers clean and focused
- Scoped route model binding to guarantee a list/card actually belongs to the board/list in the URL
- Single `BoardPolicy` reused across Board, List, and Card controllers — lists and cards inherit ownership from their parent board
- API Resources to control the exact JSON response shape and prevent sensitive fields from leaking
- Move-card endpoint validates that the destination list belongs to the same board, preventing cross-board card moves
- Pest feature tests cover authentication, CRUD operations, validation, and authorization for every resource
- Dockerized with Nginx + PHP-FPM + MySQL for consistent development environments and easy onboarding
