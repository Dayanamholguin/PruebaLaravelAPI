- PHP >= 8.4.5
- Composer
- Node.js y npm
- MySQL
- Laravel 12
- Livewire 3

  git clone https://github.com/Dayanamholguin/PruebaLaravelAPI.git
  
  cd PruebaMantum

  composer install
  npm install

  copia cp .env.example .env

  php artisan key:generate

  php artisan migrate

  php artisan db:seed

  php artisan serve
