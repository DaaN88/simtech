update:
	composer update
install:
	composer install
autoload:
	composer dump-autoload
clear:
	php artisan cache:clear
	php artisan config:clear
	php artisan view:clear
	php artisan route:clear
lint:
	composer run-script phpcs -- --standard=PSR12 app tests
test:
	composer exec --verbose phpunit tests
test-coverage:
	composer exec --verbose phpunit tests -- --coverage-clover build/logs/clover.xml
