# OpenRun API

## Getting Started

To boot a new local version of the OpenRun API, follow the instructions below:

- `cd ~/Sites/openrun-api`
- `composer install`
- `php artisan config:cache`
- `php artisan migrate`
- `php artisan db:seed --class=TestDataSeeder`
- `php artisan passport:install`
- Copy the client secret for Laravel Personal Access Client into the `.env` file in the `openrun-site` project - e.g. `API_CLIENT_SECRET={client_secret_here}`