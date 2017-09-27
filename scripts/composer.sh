#!/bin/bash

if ! type "composer" > /dev/null 2>&1; then
    cd / && curl -sS https://getcomposer.org/installer | php
    mv composer.phar /usr/local/bin/composer
fi;
