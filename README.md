
# ProjectzPilot 
> ProjectzPilot is an app that helps to simplify project management, boost team collaboration, and stay on track. App is still currently being worked on

## Description
This project was built with Vue.js,Tailwind,Laravel and MYSQL.


## Running the App
To run the App, you must have:
- **PHP** (https://www.php.net/downloads)
- **MySQL** (https://www.mysql.com/downloads/)

Clone the repository to your local machine using the command
```console
$ git clone *remote repository url*
```
```console
$ cp .env.example .env
```

### Environment
Configure environment variables in `.env` for dev environment based on your MYSQL database configuration


```  
DB_CONNECTION=<YOUR_MYSQL_TYPE>
DB_HOST=<YOUR_MYSQL_HOST>
DB_PORT=<YOUR_MYSQL_PORT>
DB_DATABASE=<YOUR_DB_NAME>
DB_USERNAME=<YOUR_DB_USERNAME>
DB_PASSWORD=<YOUR_DB_PASSWORD>

```
Also, Ensure to set your mailclient configuration in the `.env` (test will fail if this is not done)

```
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=
MAIL_PASSWORD=
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=hello@example.com
MAIL_FROM_NAME="${APP_NAME}"

```
### LARAVEL INSTALLATION
Install the dependencies and start the server and run app setup command.
Also Seeder was set up for emails. Emails can be seeded into database together with thier attachments using
`php artisan db:seed` as stated below

```console
$ composer install
$ php artisan key:generate
$ php artisan migrate
$ php artisan db:seed 
$ php artisan serve
```

### NPM INSTALLATION 
Install the dependencies and start the server

```console
$ npm install && npm run dev
```

You should be able to visit your app at your laravel app base url e.g http://localhost:8000 or http://projectzpilot.test/ (Provided you use Laravel Valet).


>If you will like to setup queue,Database was used as queue driver. When app is setup, Update `QUEUE_CONNECTION` to `database` in `.env`and ensure to run `php artisan queue:work` in seperate terminal of your project to make sure your queue worker runs in background otherwise leave the queue driver as default `sync` in `.env`

