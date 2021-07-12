# Promo Parser and mp3 Extractor


## Starting The project:
This configuration is for running the project on vagrant machine.

1. Execute `docker-compose up -d`
2. login to the app contaniner : `docker exec -it <id> bash`

    `
        composer install
        php artisan ket:genrate
    `

2. create the database according to env file or rename it to suite your needs
3. login to vagrant machine `vgarant ssh`
4. execute `composer install`
5. create migration by executing the command `php artisan migrate`
6. execute `php artisan key:generate`
7. make sure that ffmpeg and ffprobe are installed
8. Run `$php artisan queue:listen`

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
