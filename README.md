# BTC Chart on Symfony 4 Demo

## Requirements

* PHP 7.1.3
* Mysql 8.0
* composer
* yarn
* cron

## Installation Steps

1. Copy .env file to .env.local and correct credentials to Database and api key to external api


    ...
    DATABASE_URL=mysql://<YOUR_USER>:<YOUR_PASSWORD@127.0.0.1:3306/<YOUR_DATABASE_NAME>
    ...
    BITCOINAVERAGE_API_KEY='YOUR_API_KEY'
    ...

2. Run reload script and choice install 


    ./bin/reload.sh

3. Start cron job for fetch data from internal by menu item 3 in reload script

4. Run menu item 4 for starting dev server and open link [http://127.0.0.1:8000](http://127.0.0.1:8000)


## Admin side

Admin side is available on [http://127.0.0.1:8000/admin](http://127.0.0.1:8000/admin)


