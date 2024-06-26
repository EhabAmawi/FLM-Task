## Overview

This project is a web application built with PHP Laravel 11. It provides an API for managing promo codes and applying them to a price. The project uses Laravel Sanctum for API authentication.

## Setup

To set up the project, follow these steps:
1. Clone the repository.
2. Run `make setup` to build and start the Docker containers, install the composer dependencies.
3. Copy the `.env.example` file to `.env` and fill in the necessary details (DB connection).
4. run `make migrate` to create the database tables.

## Testing
To run the tests, run `make test`.

## Database Architecture
This project uses a MySQL database with the following tables:
- `users`: stores user information.
- `personal_access_tokens`: stores user tokens for API authentication. 
- `promo_codes`: stores promo codes information.
- `promo_codes_usages`: stores promo codes usage per user/code information.

## API Endpoints
The following API endpoints are available:
- `POST /api/login`: Login a user.
 - can be used to get the token for the users weather admin or normal user. where I used the `laravel/sanctum` package to generate the tokens and assign abilities for them.
- `POST /api/admin/promo-codes`: Create a promo code.
 - can be used to create a promo code. where the admin can create a promo code with the given data.
- `POST /api/promo-codes/validate`: Validate a promo code & Apply it on the given price.
 - can be used to validate the promo code and apply it on the given price. where the user can use the promo code to get a discount on the price.


## Notes:
- The project uses Laravel Sanctum for API authentication.
- I didn't use the `laravel/passport` package because it's a full OAuth2 server implementation and it's more complex than Sanctum.
- I didn't use the `spatie/laravel-permission` package because it's more complex than Sanctum and I didn't need the full functionality of it.
- I used MySQL as the database because it's the most popular database for Laravel projects. and it delivers the very good performance.
- I used the `make` command to simplify the setup and testing process, and to make it easier for the developers to run the commands.
- I didn't use Repository pattern because it's not necessary for this project. and it's more complex than the current implementation. and also I think Laravel Eloquent is doing almost the same job as the Repository pattern.
