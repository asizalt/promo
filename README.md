# Promo Parser and mp3 Extractor


## Starting The project:

1. `cp .emv.example .env`
2. Execute `docker-compose up -d`
4. login to app container `docker-compose exec app bash` and run the fallowing

  ```
        composer install
        
        php artisan ket:genrate
        
        php artisan config:cache
        
        php artisan queue:listen
        
 ```
        
5. login to db container `docker-compose exec db bash` and run the fallowing:

    ```
    
    mysql -u root -p
       
    GRANT ALL ON laravel_web.* TO 'homestead'@'%' IDENTIFIED BY 'secret'
    
    FLUSH PRIVILEGES;  
      
    ```
    
6. finnaly will login to the app container  `docker-compose exec app bash` and run the fallowing:

    ```
    
    php artisan migrate
    
    php artisan queue:listen
    
    ```

## Extract mp3 data by Category name

The project utilize queues for audio processing. please make sure the the listener is running

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
