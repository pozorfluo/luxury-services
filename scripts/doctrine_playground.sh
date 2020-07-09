# introspect database
php bin/console doctrine:mapping:import "App\Entity" annotation --path=src/Entity

# generates getter/setter methods
php bin/console make:entity --regenerate App

# 
php bin/console make:crud