# introspect database
php bin/console doctrine:mapping:import "App\Entity" annotation --path=src/Entity

# generates getter/setter methods
php bin/console make:entity --regenerate App

# or create db as configured in .env
php bin/console doctrine:database:create

# create an entity
php bin/console make:entity

# generate basic crud pages
php bin/console make:crud


# list doctrine commands
php bin/console list doctrine

# deal with enums 
# see https://www.maxpou.fr/dealing-with-enum-symfony-doctrine

# prepare migration to update db
php bin/console make:migration

# run migration
php bin/console doctrine:migrations:migrate