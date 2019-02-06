# Test Laravel

## Step
1. Clone repository
``https://github.com/jovelasquez/laravel-testing.git``
2. Move into directory and run ``composer update`` command

3. Create .env config file ``cp env.example .env``

4. Run key generate
```
php artisan key:generate
```

5. Configure MongoDB database connection
```
DB_CONNECTION=mongodb
DB_HOST=127.0.0.1
DB_PORT=27017
DB_DATABASE=laravel
DB_USERNAME=
DB_PASSWORD=
```
6. Run the Migration and Seeders.

```
php artisan migrate:refresh --seed 
```
7. Run JWT key
```
php artisan jwt:generate
```
8. In your ``.env`` configure queue connection
```
QUEUE_CONNECTION=database
```
And in your ``config/queue.php`` change the connection values
```
    'connections' => [
       'database' => [
          'driver' => 'mongodb',
          'table' => 'jobs',
          'queue' => 'default',
          'retry_after' => 90,
       ]
    ]
```
9. Configure Mail Connection. Modify your ``.env`` file. eg:
```
MAIL_DRIVER=mailgun
MAIL_HOST=smtp.mailgun.org
MAIL_PORT=587
MAIL_USERNAME=postmaster@sandbox1...07d766.mailgun.org
MAIL_PASSWORD=54e5f7c...37f37bc7
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=postmaster@sandbox1...07d766.mailgun.org
MAILGUN_DOMAIN=sandbox1....07d766.mailgun.org
MAILGUN_SECRET=8e01304e.....df3sd355sdf
```

## Custom Command
This command generates a new password for the user, updates it in the database and sends password by email
```
php artisan passwd:renew
```

## Postman Collection 
https://documenter.getpostman.com/view/687537/RztoN9DS

