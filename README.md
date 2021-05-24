## Задание
Приложение является простым трекером задач. 
Возможные действия через апи - создание/редактирование/удаление пользователей и задач, авторизация
На главной странице выведен список задач.

Необходимо:
1. Запустить проект по инструкции ниже
1. Сверстать главную страницу (см файл templates/base.html.twig)
1. Сверстать страницу входа.
   URL для логина: /api/login_check. 
   Тип запроса: POST. 
   Ожидаемые параметры - json вида {"username":"admin","password":"1"} в теле запроса. 
   Обязательно передавать Content-Type: application/json. 
   Возвращаемые данные - json с токеном авторизации
   
1. Добавить кнопку 'Создать задачу'.
   URL: /api/tasks. 
   Тип: post. 
   При отправке запроса нужно передавать заголовок Authorization со значением 'Bearer полученный токен' и Content-Type: application/json. Слово Bearer - обязательно, затем пробел и сам токен. 
   В теле запроса передать json с полями: caption, description, date, performer. 
   Формат даты: YYYY-m-d. 
   Значение performer = 1 (ид любого существующего в бд юзера)

1. Дополнительная задача: обработка ошибок
   Предусмотреть обработку различных ошибок(500ая, ошибка авторизации, и т д)

#### Использование vue.js или react будет плюсом
### Результат выложить на гитхаб 


## Запуск проекта
 - Перед запуском нужно установить PHP7.4+, Composer, docker, docker-compose, symfony(https://symfony.com/download), git
 - Запускаем контейнер (с PostgreSQL) `sudo docker-compose up`
 - Устанавливаем пакеты `composer install`
 - Настойка аутентификации
    - Генерируем сертификаты для шифрования (указать пароль 123456, что бы не менять конфиги проекта):
      ```
      mkdir -p config/jwt 
      openssl genpkey -out config/jwt/private.pem -aes256 -algorithm rsa -pkeyopt rsa_keygen_bits:4096
      openssl pkey -in config/jwt/private.pem -out config/jwt/public.pem -pubout
      ```
  - Подготовка БД
    - Накатываем миграции `bin/console doctrine:migrations:migrate`
    - Генерируем тестовые данные `bin/console doctrine:fixtures:load`
  - Запускаем веб-сервер back-end `symfony server:start`


### Команда для проверки работы сервера
`curl -X POST -H "Content-Type: application/json" http://localhost:8000/api/login_check -d '{"username":"admin","password":"1"}'`
Сервер вернет json с токеном. Этот токен нужно отсылать вместе с запросами к бэкенду в хедере "Authorization" в виде "Bearer значение_токена" 
