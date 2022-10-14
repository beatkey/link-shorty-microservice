# Link Shorty Microservice
## Usage
```
git clone https://github.com/beatkey/link-shorty-microservice.git
cd link-shorty-microservice
git checkout development
Change the *.env.example* to *.env* and set provider api keys
composer install
php artisan serve
```
## Routes

```
POST   /api/v1/shortlinks
@param: url(required), provider(bit.ly, tinyurl)
```
