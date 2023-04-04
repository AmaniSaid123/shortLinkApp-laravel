# shortLinkApp-laravel
Test of application shortLinkApp


## Installation

Clone the repository-

```
git clone https://github.com/AmaniSaid123/shortLinkApp-laravel.git
```

Then cd into the folder with this command-

```
cd shortLinkApp-laravel
```

Then do a composer install

```
composer install
```

Then do a npm install

```
npm install
```

Then create a environment file using this command-

```
cp .env.example .env
```

Then edit `.env` file with appropriate credential for your database server. Just edit these two parameter(`DB_CONNECTION`,`DB_DATABASE`,`DB_USERNAME`, `DB_PASSWORD`).

Then create a database named `shortLinkApp` and then do a database migration using this command-

```
php artisan migrate
```

## Run server

Run server using this command-

```
php artisan serve
```

Then go to `http://localhost:8000` from your browser and see the app.
## Run Unit test
./vendor/bin/phpunit

## Run schedule
php artisan schedule:work



