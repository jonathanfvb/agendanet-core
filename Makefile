up:
	docker-compose build && docker-compose up -d
	
install:
	docker exec -it agendanet-core composer install
	
update:
	docker exec -it agendanet-core composer update

test:
	docker exec -it agendanet-core vendor/bin/phpunit tests --testdox --color

down:
	docker-compose down
