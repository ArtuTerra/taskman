# Taskman REST API application

This is a task manager REST API made by me <a href="https://github.com/ArtuTerra">(this is me)</a> using Laravel 11, it was a `task assigned to me` as a test of my skills but also to practice and learn from the experience.
Taskman is an aplication made to be easy to use but still very useful, this part of the project is only the back-end part of the whole. You can access the front end <a href=https://github.com/ArtuTerra/taskman-front>clicking here</a>

## Installation

It's very simple to install this project

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
    Execute the command `php artisan serve` to run the app
-   Ninth Step:
    Import the `taskman.insomnia_collection.json` file to insomnia software (Optional)

# REST API

The instructions to use the REST API of the Taskman application is described below.

# Auth Routes

## Register into the application

### Request

### Response

## Login into the application

### Request

### Response

## Logout //TODO

### Request

### Response

## Me //TODO

### Request

### Response

## Refresh //TODO

### Request

### Response

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

## Change a Task's state

### Request

`PUT /task/{id}`

    curl --request PUT \
    --url http://127.0.0.1:8000/api/tasks/69 \
    --header 'Accept: application/json' \
    --header 'Authorization: Bearer <your_token>' \
    --header 'Content-Type: application/json' \
    --data '{
        "completed": true
    }'

### Response

    < HTTP/1.1 200 OK
    < Host: 127.0.0.1:8000
    < Connection: close
    < X-Powered-By: PHP/8.3.9
    < Cache-Control: no-cache, private
    < Date: Thu, 08 Aug 2024 20:21:13 GMT
    < Content-Type: application/json
    < Vary: Origin

    {"id":69,"title":"Task Title","description":"Task Description","completed":true,"creator_id":5,"assigned_users":[]}

## Change a Task's Title/Description

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
        "completed": false
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

    {"id":69,"title":"New name","description":"New description!","completed":false,"creator_id":5,"assigned_users":[]}

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
