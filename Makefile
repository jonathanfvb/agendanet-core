up:
	docker-compose build && docker-compose up -d

install:
	docker exec -it agendanet-schedule composer install

update:
	docker exec -it agendanet-schedule composer update

test:
	docker exec -it agendanet-schedule vendor/bin/phpunit tests

sonar:
	docker run --rm -v "$(pwd):/usr/src" sonarsource/sonar-scanner-cli

down:
	docker-compose down
