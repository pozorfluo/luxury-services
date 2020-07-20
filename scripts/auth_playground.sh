# install security bundle
composer require symfony/security-bundle

# enable new security style (optional)
# config/packages/security.yaml
security:
    enable_authenticator_manager: true

# create a User class
php bin/console make:user

# prepare, run migration

# test password encoding
php bin/console security:encode-password