#!/bin/bash
cd /home/site/www/
/usr/local/bin/php.ORIG.7_1 -d magic_quotes_gpc=0 -d register_globals=0 /home/site/www/bin/console fg:cron-monthly