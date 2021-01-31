# AIST task



## Installation


setup email service
```bash
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=(mailtrap username)
MAIL_PASSWORD=(mailtrap password)
```
setup pusher
```bash
PUSHER_APP_ID=(pusher app id)
PUSHER_APP_KEY=(pusher app key)
PUSHER_APP_SECRET=(pusher app secret)
PUSHER_CLUSTER=eu
PUSHER_APP_CLUSTER=eu
```
enable Client events from pusher dashboard to receive typing events...

## run app
- composer update
- npm install
- php artisan migrate
- php artisan db:seed  // default emails and passwords are : user1/2@gmail.com / tmp_password
- php artisan serve 
- php artisan queue:work
- npm run watch
