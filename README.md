# Khabarchin

## Overview
Khabarchin is a news aggregation service that gathers articles from multiple news sources and provides structured access to the latest news.

## Tech Stack
- **Docker Compose** (v3.8)
- **PHP** (v8.3)
- **Laravel** (v12)
- **MySQL** (v8)

## Installation Guide
### Prerequisites
Ensure you have the following installed on your system:
- [Docker](https://www.docker.com/)
- [Docker Compose](https://docs.docker.com/compose/install/)

### Setup
1. Clone the repository:
   ```shell
   git clone git@github.com:MSaami/Khabrachin.git
   cd khabarchin
   ```

2. Start the Docker containers:
   ```shell
   docker-compose up -d
   ```

3. Generate the application key:
   ```shell
   docker-compose exec -it app cp .env.example .env
   docker-compose exec -it app php artisan key:generate
   ```

4. Run database migrations:
   ```shell
   docker-compose exec -it app php artisan migrate
   ```

5. Seed the database with sample data:
   ```shell
   docker-compose exec -it app php artisan db:seed
   ```

6. Fetch news from providers (this may take up to a minute due to rate-limiting bypass mechanisms):
   ```shell
   docker-compose exec -it app php artisan news:fetch
   ```

7. (Optional) Generate a test user token:
   ```shell
   docker-compose exec -it app php artisan db:seed --class=ExampleUserSeeder
   ```

8. Open `http://localhost:9000` in your browser to access the application.




## Update News Frequently

To ensure news updates regularly, a scheduled job runs every ten minutes, pushing a separate job for each provider to the queue to fetch new articles.

To activate the scheduler and process the queued jobs, run the following commands:

you can change the configs in `console.php`

```shell
docker-compose exec -it app php artisan schedule:work
docker-compose exec -it app php artisan queue:work
```



## Monitoring
The system includes Laravel Telescope for debugging and monitoring. You can access it at:
- `http://localhost:9000/telescope`

## API Endpoints
### Fetch News
```shell
curl --location 'http://localhost:9000/api/v1/news' \
--header 'Accept: application/json' \
--header 'Authorization: Bearer {token}'
```

### Fetch News with Filters
```shell
curl --location 'http://localhost:9000/api/v1/news?categories=1,2&sources=guardian,newsapi&page=1&search=Apple&date_from=2025-02-25&date_to=2025-02-28' \
--header 'Accept: application/json' \
--header 'Authorization: Bearer {token}'
```

### User Registration 
```shell
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

### User Login (Returns Token)
```shell
curl --location 'http://localhost:9000/api/v1/login' \
--header 'Content-Type: application/json' \
--header 'Accept: application/json' \
--data-raw '{
    "email": "m.saami@gmail.com",
    "password": "password",
    "device_name": "Web"
}'
```

### Fetch User Profile
```shell
curl --location 'http://localhost:9000/api/v1/user' \
--header 'Authorization: Bearer {token}'
```

## Running Tests
The project includes unit and feature tests using PHPUnit.
To run tests:
```shell
docker-compose exec -it app php artisan migrate --env=testing
docker-compose exec -it app php artisan test
```

## Architecture
Khabarchin follows a structured architecture comprising two main components:

### **FetchService**
This component follows the **Strategy Pattern**. It consists of a base service responsible for executing fetching strategies, such as `GuardianFetchService`, which retrieves data from The Guardian. The retrieved data is then stored in the database using `newsRepository`.

![Strategy Pattern](https://github.com/user-attachments/assets/b267a2a1-16fe-40a8-9d0a-5034ae5571bc)

### **QueryService**
This component is responsible for querying and retrieving news data from the database for end-users.

![Khabarchin Fetch Flow](https://github.com/user-attachments/assets/51647324-9840-4361-8508-8574719c4d43)

## Roadmap & Future Improvements
- Implement **pagination** when fetching news from providers.
- Improve duplication prevention (currently using unique constraints and `insertOrIgnore` to bypass errors).
- Integrate **Elasticsearch** to enhance full-text search capabilities.
- Implement a Log system to determine number of the news fetched from each provider.


