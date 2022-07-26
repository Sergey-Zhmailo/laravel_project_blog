## Installation

- Create config file `cp .env.example .env`
- Run `docker-compose up -d`
- Inside php container `docker-compose exec php bash`
    - `composer install`
    - `artisan key:generate`
    - `artisan migrate:fresh --seed`
    - `artisan storage:link`
- Inside node container `docker-compose run node bash`
    - `npm`
    - `npm run build`
- Restart docker containers with commands
    - `docker-compose down`
    - `docker-compose up -d`