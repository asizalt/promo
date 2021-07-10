## Promo Parser and mp3 Extractor

# Extract mp3 data by Category name

Execute a POST request to `https:<domain>/api/promo2mp3` with the Category Name In Body:

Example Output:
```json
{
    "id": "5c1b7e0d76e0df18377b24fa",
    "mp3": "http://promo.test/api/mp3/5c1b7e0d76e0df18377b24fa.mp3"
}
```
#get BODY data according to file name:

Execute a GET request to `https:<domain>/api/mp3/<file name>.mp3`
