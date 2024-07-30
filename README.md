# SILAJANG WEB-BASED

## Specification
- PHP 8.2
- Node 18.*
- Laravel 10
- Vue 3
- Metronic 8

### Cara Installasi

1. Clone Repo
   ```sh
    $ git clone https://github.com/KOMINFO-JOMBANG/silajang-dlh.git
    $ cd silajang-dlh
   ```

2. Install Dependencies
   ```sh
    $ npm install

    $ composer install
   ```

3. Setup .env
    - ```sh
        $ php artisan secret:key
        $ php artisan jwt:secret
        $ php artisan jwt:generate-certs
        ```
    - Isikan field-field yang tersedia dengan data yang ada, seperti URL, Domain, Secret-Key, dan beberapa field lainnya
    - ```env
        APP_NAME=Laravel
        APP_ENV=local
        APP_KEY=
        APP_DEBUG=true
        APP_URL=http://localhost

        ...
        ```

4. Jalankan Aplikasi
   ```sh
    $ npm run build
   ```
