#!/bin/bash

###################### After deploy script ###############

WORK_DIR='/app'

cd $WORK_DIR || return 1

################### Fix storage permissions ###############

# Create dirs if not exist

chown -R ${FPM_USER}:${FPM_USER} storage

if  [ ! -d storage/framework/sessions ]; then
    mkdir -p storage/framework/sessions
fi

if  [ ! -d storage/framework/views ]; then
    mkdir -p storage/framework/views
fi

if  [ ! -d storage/framework/cache/data ]; then
    mkdir -p storage/framework/cache/data
fi

if [ -L public/storage ]; then unlink public/storage; fi

php artisan storage:link

###################### After deploy tasks ################

php artisan migrate:fresh --seed --force

php artisan cache:clear
php artisan config:clear
php artisan view:clear
php artisan route:clear
php artisan scribe:generate