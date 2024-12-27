<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

<h2>Version :</h2>
<ul>
    <li>
        <p style="font-size: 20px"> LARAVEL  <span style="color: red">10</span></p>
    </li>
    <li>
        <p style="font-size: 20px"> PHP <span style="color: red">min 8.2</span></p>
    </li>
    <li>
        <p style="font-size: 20px"> COMPOSER <span style="color: red">2.7</span></p>
    </li>
    <li>
        <p style="font-size: 20px"> PostgreSQL</p>
    </li>
    <li>
        <p style="font-size: 20px"> NPM  <span style="color: red">10</span></p>
    </li>
    <li>
        <p style="font-size: 20px"> NODE.JS  <span style="color: red">min 18
    </span></p>
    </li>
    <li>
        <p style="font-size: 20px"> DOCKER  <span style="color: red">min 3</span></p>
    </li>
</ul>

- [Docker install](#docker-install)
- [Install Laravel](#install-laravel)
    - [Commands of first install](#commands-of-first-install)
    - [For update](#--for-update)
    - [Full reinstall database tables](#full-reinstall-database-tables)
- [REST API](#rest-api)
    - [Films](#films)
        - [Get films](#get-films)
        - [Get one film](#get-one-film)
        - [Create film](#create-film)
        - [Update film](#update-film)
        - [Public film](#public-film)
        - [Un-public film](#un-public-film)
        - [Delete film](#delete-film)
    - [Genres](#genres)
       - [Get genres](#get-genres)
       - [Get one genre](#get-one-genre)
       - [Create genre](#create-genre)
       - [Update genre](#update-genre)
       - [Delete genre](#delete-genre)


Clone the project and in the terminal go to the level with the backend and frontend folders

You need to create a `.env` file. To register a user, you need to configure the parameters in the file. After registration, a letter is sent to the email address to verify the email.

### docker install

    docker-compose up -d

Next, go to the backend folder and run the list of commands

## INSTALL LARAVEL

### commands of first install

```
composer install

php artisan key:generate
php artisan migrate
php artisan db:seed

npm install
```

#### - for update
```
composer install

php artisan cache:clear
php artisan config:clear
php artisan route:clear

php artisan migrate
php artisan db:seed

npm install
```

### full reinstall database tables
```
php artisan migrate:fresh --seed
```

## REST API

### FILMS

### Get films

Request `GET /api/v1/films`

    Params: { page, limit }

Response `200 Success`

    { 
      "success": bool,
      "message": string,
      "data": array
    }

### Get one film

Request `GET /api/v1/films/{id}`

Response `200 Success`

    { 
      "success": bool,
      "message": string,
      "data": array
    }

Bad Response `404 Not Found`

    {
      'success': bool,
      'message': string
    }

### Create film

Request `POST /api/v1/films/store`

    Body: { name: required|string, link_poster: file|jpeg,jpg,png,svg,webp|maxsize:5000, genre: required|string id (Example: '3,8,12')}

Response `201 Created`

    { 
      "success": bool,
      "message": string,
      "data": array
    }

Bad Response `400 Bad Request`

    {
      'success': bool,
      'message': string
    }

### Update film

Request `POST /api/v1/films/update/{id}`

    Body: { name: required|string, link_poster: file|jpeg,jpg,png,svg,webp|maxsize:5000, genre: required|string id (Example: '3,8,12')}

Response `200 Success`

    { 
      "success": bool,
      "message": string,
      "data": array
    }

Bad Response `400 Bad Request`

    {
      'success': bool,
      'message': string
    }

Bad Response `404 Not Found`

    {
      'success': bool,
      'message': string
    }

### Delete film

Request `DELETE /api/v1/films/destroy/{id}`

Response `204 No Content`

Bad Response `404 Not Found`

    {
      'success': bool,
      'message': string
    }

### Public film

Request `PUT /api/v1/films/public/{id}`

Response `200 Success`

    { 
      "success": bool,
      "message": string,
      "data": array
    }

Bad Response `404 Not Found`

    {
      'success': bool,
      'message': string
    }

### Un-public film

Request `PUT /api/v1/films/un-public/{id}`

Response `200 Success`

    { 
      "success": bool,
      "message": string,
      "data": array
    }

Bad Response `404 Not Found`

    {
      'success': bool,
      'message': string
    }



### Genres

### Get genres

Request `GET /api/v1/genres`

    Params: { page, limit }

Response `200 Success`

    { 
      "success": bool,
      "message": string,
      "data": array
    }

### Get one genre

Request `GET /api/v1/genres/{id}`

Response `200 Success`

    { 
      "success": bool,
      "message": string,
      "data": array
    }

Bad Response `404 Not Found`

    {
      'success': bool,
      'message': string
    }

### Create genre

Request `POST /api/v1/genres/store`

    Body: { name: required|string }

Response `201 Created`

    { 
      "success": bool,
      "message": string,
      "data": array
    }

Bad Response `400 Bad Request`

    {
      'success': bool,
      'message': string
    }

### Update genre

Request `POST /api/v1/genres/update/{id}`

    Body: { name: required|string }

Response `200 Success`

    { 
      "success": bool,
      "message": string,
      "data": array
    }

Bad Response `400 Bad Request`

    {
      'success': bool,
      'message': string
    }

Bad Response `404 Not Found`

    {
      'success': bool,
      'message': string
    }

### Delete genre

Request `DELETE /api/v1/genres/destroy/{id}`

Response `204 No Content`

Bad Response `404 Not Found`

    {
      'success': bool,
      'message': string
    }
