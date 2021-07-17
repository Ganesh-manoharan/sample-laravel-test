#!/bin/sh
set -e
echo "Deploying application ..."
# Enter maintenance mode
    git config --global credential.helper "/bin/bash /git_creds.sh"
#    git fetch origin Dev
    git pull

    # Install dependencies based on lock file
    composer install

    #Installing npm packages
    npm install

    #Creating npm production build
    npm run dev

    # Migrate database
    php artisan migrate

    # Note: If you're using queue workers, this is the place to restart them.
    # ...

    # Clear cache
    php artisan cache:clear
    php artisan view:clear
    php artisan config:clear
    php artisan route:clear

    # Reload PHP to update opcache
#    sudo  service php7.2-fpm restart

echo "Application deployed!"
