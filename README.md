# Egal lottery app

Простое тестовое приложение с лотереями. 

- Подготовка перед запуском проекта
```
cp .env .env.example
cd project/ && composer install --ignore-platform-reqs
```
- Запуск и сборка контейнеров:
```
docker-compose up -d --build
```
- Запуск миграций и сидеров:
```
docker-compose exec core-service php artisan migrate --seed --force
```