Domain Driven Design methodology , CQRS and Event Driven patterns are used in development
Used Symfony 4.2, Mysql 5.7 and docker for CD

**Install:**

`cd docker/`

`docker-compose up -d --build`

`cd ../`

`composer install`

`cd docker/`

`docker-compose exec php bash`
`php -d memory_limit=200M bin/console doctrine:schema:update --force`
`php -d memory_limit=200M bin/console doctrine:migrations:execute --up 20190422220712`
`exit`

http://localhost

**For test:**

`./vendor/bin/phpunit`

or

`phpunit`


**Test User**

test email: test@vonq.com

yesy password: 123456