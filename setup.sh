sudo rm -rf app/cache app/logs db
mkdir app/cache app/logs db
composer install
app/console doctrine:database:drop --force
app/console doctrine:database:create
app/console doctrine:schema:update --force
sudo setfacl -R -m u:www-data:rwX -m u:`whoami`:rwX app/cache app/logs db
sudo setfacl -dR -m u:www-data:rwX -m u:`whoami`:rwX app/cache app/logs db
