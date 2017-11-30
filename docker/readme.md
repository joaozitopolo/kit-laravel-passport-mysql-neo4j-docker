
# docker

## starting

	docker-compose up
	
## stopping

	ctrl-c no terminal
	
## starting in background (detached mode)

	docker-compose up -d
	
## stopping in background

### when you run in background, remember to stop before shutdown your computer

	docker-compose down
	
## command prompts

### terminal for phpunit, php artisan, etc

	docker-compose exec workspace bash

## neo4j access

	[neo4j browser](http://localhost:7474/browser)

## log access, when running in background (follow mode)

	docker-compose logs -f

## running containers and ports list

	docker-compose ps

