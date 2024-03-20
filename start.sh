#!/bin/bash

if [ ! -f .env ]; then
  echo "Creating .env from .env.example..."
  cp .env.example .env
else
  echo ".env already exists."
fi

# Running containers and log output
echo "Launching containers..."
docker-compose up -d
docker-compose logs -f &


# Running commands in the php container and outputting logs
echo "Installing Composer Dependencies..."
docker exec -it $(docker ps -qf "name=app") sh -c "composer install"
echo "Performing DB Migrations..."
docker exec -it $(docker ps -qf "name=app") sh -c "php bin/console doctrine:migrations:migrate --no-interaction"

# Outputs a message about a successful start
echo -e "\033[0;32mThe project went up successfully!\033[0m"