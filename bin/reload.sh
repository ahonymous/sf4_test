#!/bin/bash

jobPath="$(pwd)/bin/console statistic:history:fetch"

echo ""
echo "Выберите необходимое действие:"
echo "    1 - Установка."
echo "    2 - Перезагрузка БД."
echo "    3 - Cron задача для обновления данных с внешнего ресурса."
echo "    4 - Запуск сервера."
echo "    5 - Загрузить данные из внешних источников."
echo "    0 - Выход."
read reload

case $reload in
1)
    echo "Установка."
    composer install

    php bin/console doctrine:database:create -e dev
    php bin/console doctrine:migrations:migrate -n -e dev
    php bin/console doctrine:fixtures:load -n -e dev
    php bin/console cache:clear
    yarn encore prod
;;
2)
    echo "Перезагрузка БД."
    php bin/console doctrine:schema:drop --force -e dev
    php bin/console doctrine:migrations:version --delete --all -n -e dev
    php bin/console doctrine:migrations:migrate -n -e dev
    php bin/console doctrine:fixtures:load -n -e dev
    php bin/console cache:clear
;;
3)
    echo "Cron задача для обновления данных с внешнего ресурса."
    if [[ ! $(crontab -l | grep -i jobPath) ]];
    then
        crontab -l > mycron
        echo "0 * * * * $jobPath" >> mycron
        crontab mycron
        rm mycron
    fi
;;
4)
    echo "Запуск сервераю."
    yarn install
    yarn encore prod
    php bin/console server:run -e dev
;;
4)
    echo "Загрузить данные из внешних источников."
    php bin/console statistic:history:fetch -e prod
;;
0)
    exit 0
;;
*)
    echo "Введите правильное действие!"
    sh bin/reload.sh

esac
