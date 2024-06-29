
## Описание проекта

Реализованы все 5 пунктов основного функционала и 1 пункт дополнительного.
Онлайн версия тут `#`

Стек: Laravel 10, PHP 8.2 fpm, Postgresql 16.2, NodeJs, JQuery, Nginx, Docker

<details>

<summary>Как поднять:</summary>

- Скачиваем репозиторий и помещаем в домашнюю папку пользователя
- `docker-compose up -d --build` находясь в директории проекта
- Обновляем\устанавливаем зависимости и ставим ноду `composer update` и `npm install`
- Делаем миграции `php artisan migrate`
- Даем доступ к хранилищу `php artisan storage:link`


Стандартный url `http://127.0.0.1`
</details>

~~В онлайн версии для демонстрации создано 2 аккаунта `admin@admin.com` и `admin@admin1.com` пароль одинаковый `123123123`. Пользователь 1 (admin) имеет доступ к списку с id 2 пользователя 2 (user).~~

## Задание
<details>
<summary>ТЗ</summary>

Тестовое задание, результат необходимо выложить в git репозиторий и написать инструкцию по деплою.

Для реализации использовать на бекенде PHP, фреймворк - Laravel, на фронте JS / jQuery. Для элементов интерфейса - Bootstrap

Отдельный плюс, если получится самостоятельно развернуть проект и предоставить на него ссылку
Реализовать ToDo список.

Необходимый функционал:

1) Хранение списков в БД. Сохранение сделать без перезагрузки страницы (ajax)
2) Регистрация / авторизация пользователей для создания личных списков. Возможность редактирования сохраненных списков
3) Возможность прикрепить к пункту списка изображение. Для изображения должно автоматически создаваться квадратное превью размером 150x150px. При нажатие на превью - в новой вкладке открывается исходное изображение. Изображение можно заменить / удалить
4) Возможность тегировать пункты списка. Кол-во тегов может быть не ограниченым. Теги формируются самим пользователем, т.е. набор произвольный, не фиксированный.
5) Поиск по элементам списка. Фильтрация элементов списка по тегам (одному или нескольким)

Если подытожить, то структура следующая:
список = оболочка-контейнер, в котором создаются задачи
Списков может быть несколько, задач в списках также может быть несколько
Для списка достаточно задать наименование (остальное - по вашему усмотрению)
Тегирование/изображение/поиск - всё это относится к задачам (не спискам)

Дополнительный функционал (реализация - по желанию)

1) Возможность расшарить список другому пользователю (т.е. пользователь А может дать доступ на чтение пользователю Б)
2) Разграничение прав доступа к списку (пользователь А может только читать, пользователь Б может читать и редактировать)
</details>
