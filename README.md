# Khabarchin


## About
The project gatters some couple of news sites.


## Stack
`Docker-Compose 3.8`

`PHP 8.3`

`Laravel 12`

`Mysql 8`


## How To Install 
- Install [Docker](https://www.docker.com/)
- Install [Docker-Compose](https://docs.docker.com/compose/install/)
- Clone the project.
- up the containers:
 ```shell
docker-compose up -d
```
- run the migration to create tables:
```shell 
docker-compose exec -it app php artisan db:migrate
```
- run seeders to have fake data:
 ```shell
 docker-compose exec -it app php artisan db:seed
 ```
- fetch news from providers (it can take one minute due to bypassing rate limit): 
```shell
docker-compose exec -it app php artisan news:fetch
```
- (optional) If you want to get a user token without login process you can run: 
```shell
docker-compose exec -it php artisan db:seed --class=ExampleUserSeeder
```
- open `localhost:9000` in your browser and you should face with Laravel index page.


## APIs
- Fetch News
```curl
curl --location 'http://localhost:9000/api/v1/news' \
--header 'Accept: application/json' \
--header 'Authorization: Bearer {token}' \
```

- Fetch News With Filters
```curl
curl --location 'http://localhost:9000/api/v1/news?categories=1,2&sources=2,3&page=1&search=Apple&date_from=2025-02-25&date_to=2025-02-28' \
--header 'Accept: application/json' \
--header 'Authorization: Bearer {token}' \
```

- Register (it returns the token)
```curl
curl --location 'http://localhost:9000/api/v1/register' \
--header 'Content-Type: application/json' \
--header 'Accept: application/json' \
--data-raw '{
    "email": "m.saami@gmail.com",
    "password": "password",
    "password_confirmation": "password",
    "name": "Mehrdad"
}'
```

- Login (it returns the token)
```curl
curl --location 'http://localhost:9000/api/v1/login' \
--header 'Content-Type: application/json' \
--header 'Accept: application/json' \
--data-raw '{
    "email": "m.saami@gmail.com",
    "password": "password",
    "device_name": "Web"
}'
```

- User Profile
```curl
curl --location 'http://localhost:9000/api/v1/user' \
--header 'Authorization: Bearer {token}' \
```

## Test
the project has some couple of unit and feature tests, indeed it's not like the real project's test, but due to show the way of testing it can be useful, the tool which is used for write test is `phpunit`

- You can run the tests by:
```shell
docker-compose exec -it app php artisan test
```

## Architecture

The project has two abstract main component:
- `FetchService`
- `QueryService`

#### FetchService
it's a service written in StrategyPattern in which there is a parent class that in charge of execute the strategy which is given like GuardianFetchService which is concrete service to fetch data from Guardian, then store it in database using `newsRepository`

![strategypattern](https://github.com/user-attachments/assets/b267a2a1-16fe-40a8-9d0a-5034ae5571bc)



#### QueryService
it's another part of our application which is reponsible for read data from database and return to users.


![Khabrchin Fetch Flow](https://github.com/user-attachments/assets/51647324-9840-4361-8508-8574719c4d43)



## TODO
- Adding pagination to getting all of the news from providers 


