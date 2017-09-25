#!/bin/bash

sed -i -e 's$display_errors = Off$display_errors = On$g' /etc/php/7.1/apache2/php.ini
sed -i -e 's/error_reporting = E_ALL \\& ~E_DEPRECATED \\& ~E_STRICT/error_reporting = E_ALL \\& ~E_NOTICE \\& ~E_DEPRECATED \\& ~E_STRICT/g' /etc/php/7.1/apache2/php.ini
