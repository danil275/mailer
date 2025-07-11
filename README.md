# Mailer

REST API на Symfony для отправки email-сообщений с асинхронной обработкой через очередь.

## Возможности

- `POST /send` — отправка email (с защитой от повторных писем)
- `GET /status/{id}` — получение статуса отправки письма
- Асинхронная отправка через **Symfony Messenger** и **RabbitMQ**
- Локальный SMTP-сервер (`namshi/smtp`) для разработки
- Структура проекта построена по принципам **чистой архитектуры**

## Используемые технологии

- **PHP 8.2**, **Symfony**
- **RabbitMQ**, **Redis**
- **Doctrine ORM**
- **Docker**

## Запуск проекта


```bash
docker-compose up -d
docker exec -it app_php php bin/console doctrine:migrations:migrate
docker exec -it app_php php bin/console messenger:consume async
```
