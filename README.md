# csv-upload
 Uploads a csv file contents to the database

## Installation
```
git clone https://github.com/somuoki/csv-upload.git
cd csv-upload
composer install
php artisan migrate
php artisan serve
```

## How it works

Upload your csv via the upload button.
The application stores the csv in the server locally before sending it the database.
The process may take a while depending on size of data
