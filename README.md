# Simple Laravel API
## Overview
This is a simple API demo that contains the following endpoint:

**POST** `api/record-page-visit`

which takes the following body
```
{
    "pageName" (must be 'product' or 'contact'),
    "ipAddress" (must be valid ip format),
    "visitedAt" (must be in the format of d-m-Y H:i:s)
}
```
And simply save the information to the table `page_visits`

There is **no** auth gate in place for this endpoint.

## Setup Guide
### Prerequisite
* Please make sure you have `php7.4` or higher and the latest `composer`
* Please make sure you have a local `MySQL5` server
* Please make sure you have the latest `docker` and `docker-compose`

### Steps
1. Please run `composer install`
2. Please create a schema `demo` in your database
3. Please copy and paste the content of `.env.example` in a new file `.env` and fill in your database connection details
4. Please run `php artisan key:generate`
5. Please run `php artisan migrate`
6. Now the API should be reachable at **POST** *host*`api/record-page-visit`

### Docker Steps
1. Please turn on your local docker service
2. Please edit environment variables as fit in `docker-compose.yaml`
3. Please run `docker-compose up --build --remove-orphans`
4. The server is now running on `localhost:8000`

## Test
You can run test via calling `php artisan test`
