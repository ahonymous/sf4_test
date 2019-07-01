# BTC Chart on Symfony 4 Demo

## Requirements

* PHP 7.1.3
* Mysql 8.0
* composer
* yarn

## Installation Steps

1. Copy .env file to .env.local and correct credentials to Database


    ...
    DATABASE_URL=mysql://<YOUR_USER>:<YOUR_PASSWORD@127.0.0.1:3306/<YOUR_DATABASE_NAME>
    ...

2. Run  reload script and choice install 


    ./bin/reload.sh


3. Change variable APP_ENV in .env.local on prod value


    ...
    APP_ENV=prod
    ...

3. Run server


    ./bin/console server:run    

4. Open link [http://127.0.0.1:8000](http://127.0.0.1:8000)


## Admin side

Admin side is available on [http://127.0.0.1:8000/admin](http://127.0.0.1:8000/admin) 
