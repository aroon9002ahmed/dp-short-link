<p align="center"><a href="https://qit-eg.com" target="_blank"><img src="https://www.qit-eg.com/assets/images/logo/logo.png" width="60" alt=""></a></p>

## About Project

<p>this is short link system, help you to create short links and redirect them to the original urls.</p>
<p>system use filament 5 framework and laravel 12.</p>

## Before Starting

- Update APP_URL in .env file
- Update APP_URL_MIAN_WEBSITE in .env file (this will used to redirect expired or inactive links)

## Make Sure to add queue service in start of project:

- `php artisan queue:work`
- `php artisan queue:restart`

## install

```bash
composer install
npm install
npm run build

cp .env.example .env

php artisan key:generate
php artisan migrate
php artisan db:seed --class=LinkSeeder

php artisan serve
php artisan queue:work
```

## Important to know

- Short code will be generated randomly and will be unique.
- Short code will be 6 characters long.
- Short code will be generated for each link.

## About Author

<p>this system made by Eng. Ahmed Saad hassan</p>
<p>
for more information or custom work contact me on whatsapp: <a href="https://wa.me/+201005222130" style="color: green; font-weight: bold;">+201005222130</a> or visit our website: <a href="https://qit-eg.com" style="color: orange; font-weight: bold;">qit-eg.com</a></p>

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
