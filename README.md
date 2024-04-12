# cip.gov.ua - Отримання списку доменів

## Встановлення 
Необхідно встановити php (7.4+, 8+) та composer     
Модулі php:

* json
* intl
* mbstring

```shell
git clone https://github.com/meklis/ua-blocking-parser.git
cd ua-blocking-parser
composer install
```

## Використання 
### Отримання списку доменів в .txt файл 
```shell
php ./scripts/get_domains_list.php 
```   
Результат роботи скрипту буде завантажено в `files/domains.txt`    
 
# Працівникам з cip.gov.ua - ви знущаєтесь? Дайте нормальне API зі списком доменів, а не блокуйте костилі, які доводиться робити через вашу лінь! (наразі скрипт не працює, заблокували)
