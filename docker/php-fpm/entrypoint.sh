#!/bin/bash

set -e

sleep 5
php /var/www/symfony/bin/console doctrine:migrations:migrate --no-interaction --allow-no-migration
php /var/www/symfony/bin/console app:match:reindex

onchange.sh php /var/www/symfony/bin/console app:match:reindex

exec "$@"