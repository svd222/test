# svd test package

для разворачивания приложения потребуется:
1) composer: https://getcomposer.org/
2) apache ant: http://ant.apache.org/ 

```bash
sudo apt-get install ant
```

Склонировать репозиторий в рабочий каталог

```bash
cd /var/www
sudo mkdir -m 0755 myproject && cd myproject
$ git clone https://github.com/svd222/test/test.git ./ 
```
 
 и далее выполнить

```bash
$ composer update
$ cd ./vendor/phpunit/phpunit
$ ant
```

## Содержание теста:

1. ./tests/YandexResponseParserTest.php 

```bash
$ vendor/phpunit/phpunit/phpunit ./tests/YandexResponseParserTest.php
```

2. ./index.html

Открыть в браузере

