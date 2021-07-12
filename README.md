# Promo Parser and mp3 Extractor


## Starting The project:
This configuration is for running the project on vagrant machine.

1. Execute `docker-compose up -d`
2. login to the app contaniner : `docker exec -it <id> bash`
3. execute the fallowing from container : 
        `composer install`
        `php artisan ket:genrate`
        `php artisan migrate`
        `php artisan queue:listen`

## Extract mp3 data by Category name

Execute a POST request to `https:<domain>/api/promo2mp3` with the Category Name In Body:

Example Output:
```json
{
    "id": "5c1b7e0d76e0df18377b24fa",
    "mp3": "http://promo.test/api/mp3/5c1b7e0d76e0df18377b24fa.mp3"
}
```
# get BODY data according to file name:

Execute a GET request to `https:<domain>/api/mp3/<file name>.mp3`
