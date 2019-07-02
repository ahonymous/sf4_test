#!/bin/bash

echo ""
echo "Выберите необходимое действие:"
echo "    1 - Установка."
echo "    2 - Перезагрузка БД."
echo "    0 - Выход."
read reload

case $reload in
1)
    echo "Установка."
    composer install

    php bin/console doctrine:database:create
    php bin/console doctrine:migrations:migrate -n
    php bin/console doctrine:fixtures:load -n
    php bin/console cache:clear
    yarn encore prod
    php bin/console server
;;
2)
    echo "Перезагрузка БД."
    php bin/console doctrine:database:create
    php bin/console doctrine:migrations:migrate -n -e dev
    php bin/console doctrine:fixtures:load -n -e dev
    php bin/console cache:clear
;;
0)
    exit 0
;;
*)
    echo "Введите правильное действие!"
    sh bin/reload.sh

esac
