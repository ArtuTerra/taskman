<h1 align="center">Taskman</h1>

<div align="center">

[![Status](https://img.shields.io/badge/status-active-success.svg)]()
[![GitHub Issues](https://img.shields.io/github/issues/artuterra/taskman.svg)](https://github.com/artuterra/taskman/issues)
[![GitHub Pull Requests](https://img.shields.io/github/issues-pr/artuterra/taskman.svg)](https://github.com/artuterra/taskman/pulls)
[![License](https://img.shields.io/badge/license-MIT-blue.svg)](/LICENSE)

## </div>

<p align="center">Task Manager Application 
    <br> 
</p>

## 📝 Table of Contents

-   [About](#about)
-   [Getting Started](#getting_started)
-   [Usage](#usage)
-   [Built Using](#built_using)
-   [Acknowledgments](#acknowledgement)

## 🧐 About <a name = "about"></a>

This is a task manager REST API made by me <a href="https://github.com/ArtuTerra">(this is me)</a> using Laravel 11, it was a `task assigned to me` as a test of my skills but also to practice and learn from the experience.
Taskman is an aplication made to be easy to use but still very useful, this part of the project is only the back-end part of the whole. You can access the front end <a href=https://github.com/ArtuTerra/taskman-front>clicking here</a>

<p><bold>Special thanks to all my friends and family that supported me on my journey so far, and to my co-workers for helping out whenever i asked.</bold></p>

## 🏁 Getting Started <a name = "getting_started"></a>

### Prerequisites

Before starting the installation, make sure that your local machine has PHP 8.3 and Composer installed. It is also recomended you have a MySQL Ver 8.0.39 or higher database setup for the project.
Useful links:
[PHP Installation on Windows](https://www.php.net/manual/en/install.windows.php)
[PHP Installation on macOS](https://www.php.net/manual/en/install.macosx.php)
[PHP Installation on Linux](https://php.watch/articles/php-8.3-install-upgrade-on-debian-ubuntu#quick-start)

[Composer installation](https://getcomposer.org/doc/00-intro.md)

[MySQL Installation](https://www.mysql.com/downloads/)

If you are developing on macOS or Windows, you could try [Laravel Herd](https://herd.laravel.com/windows) to quickly install PHP, Composer, Node and NPM in minutes.

### Installing

It's very simple to install this project, follow the step by step below to get a development env running:

-   First step:
    `Git Clone https://github.com/ArtuTerra/taskman.git`
-   Second Step:
    `cd taskman`
-   Third Step:
    `composer install` (Make sure you have installed composer-setup in your device)
-   Forth Step:
    `cp .env.example .env` to copy the .env.example and create a new .env
-   Fifth Step:
    Configure the `.env` file for databse connection and go to mysql server and create a desired database
-   Sixth Step:
    Execute `php artisan key:generate` command to generate your laravel key
-   Seventh Step:
    `php artisan jwt:secret` to generate your JWT auth secret token in your .env
-   Eighth Step:
    Run the migrations to create the tables in the database: `php artisan migrate`
-   Ninth Step:
    Execute the command `php artisan serve` to run the app
-   Tenth Step
    Import the `taskman.insomnia_collection.json` file to Insomnia software (Optional)

## 🎈 Usage <a name="usage"></a>

The instructions to use the REST API of the Taskman application is described below.

# Auth Routes

## Register into the application

### Request

`POST /api/register`

    curl --request POST \
    --url http://127.0.0.1:8000/api/register \
    --header 'Accept: application/json' \
    --header 'Content-Type: multipart/form-data' \
    --form name=arthur \
    --form email=example.email@test.com \
    --form password_confirmation=password1234 \
    --form password=password1234

### Response

    < HTTP/1.1 201 Created
    < Host: 127.0.0.1:8000
    < Connection: close
    < X-Powered-By: PHP/8.3.9
    < Cache-Control: no-cache, private
    < Date: Fri, 09 Aug 2024 11:02:42 GMT
    < Content-Type: application/json
    < Vary: Origin

    {"message":"Success!"}

## Login into the application

### Request

`POST /api/login`

    curl --request POST \
    --url http://127.0.0.1:8000/api/login \
    --header 'Accept: application/json' \
    --header 'Content-Type: multipart/form-data' \
    --form email=example.email@test.com \
    --form password=password1234

### Response

    < HTTP/1.1 200 OK
    < Host: 127.0.0.1:8000
    < Connection: close
    < X-Powered-By: PHP/8.3.9
    < Cache-Control: no-cache, private
    < Date: Fri, 09 Aug 2024 11:23:22 GMT
    < Content-Type: application/json
    < Vary: Origin

    {"id":9,"name":"arthur","email":"example.email@test.com","access_token":"<your_token>","expires_in":60}

## Logout of the application

### Request

`POST /api/logout`

    curl --request POST \
    --url http://127.0.0.1:8000/api/logout \
    --header 'Accept: application/json' \
    --header 'Authorization: Bearer <your_token>' \

### Response

    < HTTP/1.1 204 No Content
    < Host: 127.0.0.1:8000
    < Connection: close
    < X-Powered-By: PHP/8.3.9
    < Cache-Control: no-cache, private
    < Date: Fri, 09 Aug 2024 11:54:40 GMT
    < Vary: Origin

## Get current user data

### Request

`GET /api/me`

    curl --request GET \
    --url http://127.0.0.1:8000/api/me \
    --header 'Authorization: Bearer <your_token>' \
    --header 'accept: application/json'

### Response

    < HTTP/1.1 200 OK
    < Host: 127.0.0.1:8000
    < Connection: close
    < X-Powered-By: PHP/8.3.9
    < Cache-Control: no-cache, private
    < Date: Fri, 09 Aug 2024 11:55:47 GMT
    < Content-Type: application/json
    < Vary: Origin

    {"id":9,"name":"arthur","email":"example.email@test.com"}

## Refresh token

### Request

`POST /api/refresh`

    curl --request POST \
    --url http://127.0.0.1:8000/api/refresh \
    --header 'Accept: application/json' \
    --header 'Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOi8vMTI3LjAuMC4xOjgwMDAvYXBpL2xvZ2luIiwiaWF0IjoxNzIzMjA0NTQ1LCJleHAiOjE3MjMyMDgxNDUsIm5iZiI6MTcyMzIwNDU0NSwianRpIjoiNEtMelpJb2oxdk1EU3NhYSIsInN1YiI6IjkiLCJwcnYiOiIyM2JkNWM4OTQ5ZjYwMGFkYjM5ZTcwMWM0MDA4NzJkYjdhNTk3NmY3In0.t5N1hsrGAGbUXIswFuBUcGL8Mt_g1Lpf-sWUjjPyTHk' \
    --header 'User-Agent: insomnia/9.3.1'

### Response

    < HTTP/1.1 200 OK
    < Host: 127.0.0.1:8000
    < Connection: close
    < X-Powered-By: PHP/8.3.9
    < Cache-Control: no-cache, private
    < Date: Fri, 09 Aug 2024 11:56:49 GMT
    < Content-Type: application/json
    < Vary: Origin

    {"id":9,"name":"arthur","email":"example.email@test.com","access_token":"<your_token>","expires_in":60}

# Task Routes

## Get list of all tasks

### Request

`GET /api/tasks`

    curl --request GET \
    --url http://127.0.0.1:8000/api/tasks \
    --header 'Accept: application/json' \
    --header 'Authorization: Bearer <your_token>' \

### Response

    < HTTP/1.1 200 OK
    < Connection: close
    < X-Powered-By: PHP/8.3.9
    < Cache-Control: no-cache, private
    < Date: Thu, 08 Aug 2024 19:32:19 GMT
    < Content-Type: application/json
    < Vary: Origin

    [
        {
            "id": 0,
    	    "title": "",
    	    "description": "",
    	    "completed": false,
    	    "creator_id": 0,
        },
        {...},
    ]

## Get list of tasks with assigned users

### Request

`GET /api/tasks/assigns`

    curl --request GET \
    --url http://127.0.0.1:8000/api/tasks/assigns \
    --header 'Accept: application/json' \
    --header 'Authorization: Bearer <your_token>' \

### Response

    < HTTP/1.1 200 OK
    < Connection: close
    < X-Powered-By: PHP/8.3.9
    < Cache-Control: no-cache, private
    < Date: Thu, 08 Aug 2024 19:32:19 GMT
    < Content-Type: application/json
    < Vary: Origin

    [
        {
            "id": 0,
    	    "title": "",
    	    "description": "",
    	    "completed": false,
    	    "creator_id": 0,
    	    "assigned_users": [
                {
                    "id": 0,
    			    "name": "user name",
    			    "email": "user email",
    			    "pivot": {
    				    "task_id": 0,
    				    "user_id": 0
                    }
                }
            ]
        },
        {...},
    ]

## Create a new Task

### Request

`POST /api/task`

    curl --request POST \
    --url http://127.0.0.1:8000/api/tasks \
    --header 'Accept: application/json' \
    --header 'Authorization: Bearer <your_token>' \
    --header 'Content-Type: application/json' \
    --data '{
        "title": "Task Title",
        "description": "Task Description"
    }'

### Response

    < HTTP/1.1 201 Created
    < Host: 127.0.0.1:8000
    < Connection: close
    < X-Powered-By: PHP/8.3.9
    < Cache-Control: no-cache, private
    < Date: Thu, 08 Aug 2024 20:05:31 GMT
    < Content-Type: application/json
    < Vary: Origin

    {"title":"Task Title","description":"Task Description","completed":false,"creator_id":1,"id":69}

## Get Task by id

### Request

`GET /task/{id}`

    curl --request GET \
    --url http://127.0.0.1:8000/api/tasks/69 \
    --header 'Accept: application/json' \
    --header 'Authorization: Bearer <your_token>' \

### Response

    < HTTP/1.1 200 OK
    < Host: 127.0.0.1:8000
    < Connection: close
    < X-Powered-By: PHP/8.3.9
    < Cache-Control: no-cache, private
    < Date: Thu, 08 Aug 2024 20:14:31 GMT
    < Content-Type: application/json
    < Vary: Origin

    {"id":69,"title":"Task Title","description":"Task Description","completed":false,"creator_id":1,"assigned_users":[]}

## Update a task's information

### Request

`PUT /task/{id}`

    curl --request PUT \
    --url http://127.0.0.1:8000/api/tasks/69 \
    --header 'Accept: application/json' \
    --header 'Authorization: Bearer <your_token>' \
    --header 'Content-Type: application/json' \
    --data '{
        "title": "New name",
        "description": "New description!",
        "completed": true
    }'

### Response

    < HTTP/1.1 200 OK
    < Host: 127.0.0.1:8000
    < Connection: close
    < X-Powered-By: PHP/8.3.9
    < Cache-Control: no-cache, private
    < Date: Thu, 08 Aug 2024 20:23:31 GMT
    < Content-Type: application/json
    < Vary: Origin

    {"id":69,"title":"New name","description":"New description!","completed":true,"creator_id":5,"assigned_users":[]}

## Delete a task

### Request

`DELETE /task/{id}`

    curl --request DELETE \
    --url http://127.0.0.1:8000/api/tasks/69 \
    --header 'Accept: application/json' \
    --header 'Authorization: Bearer <your_token>' \

### Response

    < HTTP/1.1 204 No Content
    < Host: 127.0.0.1:8000
    < Connection: close
    < X-Powered-By: PHP/8.3.9
    < Cache-Control: no-cache, private
    < Date: Thu, 08 Aug 2024 20:25:51 GMT
    < Vary: Origin

# User Routes

## Get a list with all users

### Request

`GET /api/users`

    curl --request GET \
    --url http://127.0.0.1:8000/api/users \
    --header 'Accept: application/json' \
    --header 'Authorization: Bearer <your_token>' \

### Response

    < HTTP/1.1 200 OK
    < Host: 127.0.0.1:8000
    < Connection: close
    < X-Powered-By: PHP/8.3.9
    < Cache-Control: no-cache, private
    < Date: Fri, 09 Aug 2024 12:07:15 GMT
    < Content-Type: application/json
    < Vary: Origin

    [
        {
            "id": 1,
            "name": "arthur",
            "email": "example.email@test.com"
        },
        {...},
    ]

## Assign user(s) to a task

### Request

`POST /api/tasks/assign/{task id}`

    curl --request POST \
    --url http://127.0.0.1:8000/api/tasks/assign/69 \
    --header 'Accept: application/json' \
    --header 'Authorization: Bearer <your_token>' \
    --header 'Content-Type: application/json' \
    --data '{
        "user_ids":[1,2]
    }'

### Response

    < HTTP/1.1 200 OK
    < Host: 127.0.0.1:8000
    < Connection: close
    < X-Powered-By: PHP/8.3.9
    < Cache-Control: no-cache, private
    < Date: Fri, 09 Aug 2024 12:15:18 GMT
    < Content-Type: application/json
    < Vary: Origin

    {
        "id": 69,
        "title": "New name",
        "description": "New description!",
        "completed": false,
        "creator_id": 1,
        "assigned_users": [
            {
                "id": 1,
                "name": "arthur",
                "email": "example.email@test.com",
                "pivot": {
                    "task_id": 69,
                    "user_id": 1
                }
            },
            {
                "id": 2,
                "name": "Text",
                "email": "test.email@example.com",
                "pivot": {
                    "task_id": 69,
                    "user_id": 2
                }
            }
        ]
    }

## Remove assigned user(s)

### Request

`DELETE /api/tasks/assign/{task id}`

    curl --request DELETE \
    --url http://127.0.0.1:8000/api/tasks/assign/69 \
    --header 'Accept: application/json' \
    --header 'Authorization: Bearer <your_token>' \
    --header 'Content-Type: application/json' \
    --data '{
        "user_ids":[2]
    }'

### Response

    < HTTP/1.1 200 OK
    < Host: 127.0.0.1:8000
    < Connection: close
    < X-Powered-By: PHP/8.3.9
    < Cache-Control: no-cache, private
    < Date: Fri, 09 Aug 2024 12:21:02 GMT
    < Content-Type: application/json
    < Vary: Origin

    {
        "id": 69,
        "title": "New name",
        "description": "New description!",
        "completed": false,
        "creator_id": 5,
        "assigned_users": [
            {
                "id": 1,
                "name": "Test User",
                "email": "test@example.com",
                "pivot": {
                    "task_id": 69,
                    "user_id": 1
                }
            }
        ]
    }

## ⛏️ Built Using <a name = "built_using"></a>

-   [MySQL](https://www.mysql.com/) - Database
-   [Laravel](https://laravel.com/) - Server Framework
-   [NuxtJs v3](https://nuxt.com/) - Web Framework [(find that code Here)](https://github.com/ArtuTerra/taskman-front)

## 🎉 Acknowledgements <a name = "acknowledgement"></a>

-   Special thanks to:

    [Dan](https://github.com/daniellucasdev)

    [Wesley](https://github.com/wesley-gomes-sje)

    [Matheuzinho](https://github.com/matheus-alvs01dev)

    [Matheuzão](https://github.com/MatheusFelipeMarinho)

    [Marcão](https://github.com/marcusslv)

-   Some links that helped me out a lot during the creation of the project:

    https://www.binaryboxtuts.com/php-tutorials/laravel-11-json-web-tokenjwt-authentication/#Step1_Install_Laravelnbsp11

    https://blog.logrocket.com/implementing-jwt-authentication-laravel-10/

    https://rezakhademix.medium.com/laravel-11-no-http-kernel-no-casts-no-console-kernel-721c62adb6ef

    https://www.linkedin.com/pulse/jwt-authentication-laravel-11-sanjay-jaiswar-kbelf/

    https://github.com/tymondesigns/jwt-auth/issues/186

    https://stackoverflow.com/questions/50843841/tymon-jwtauthtouser-error-a-token-is-required

    https://github.com/solomoreal/laravel-jwt-with-todo/blob/main/app/Http/Kernel.php

    https://rezakhademix.medium.com/laravel-11-no-http-kernel-no-casts-no-console-kernel-721c62adb6ef

    https://www.avyatech.com/rest-api-with-laravel-8-using-jwt-token/
