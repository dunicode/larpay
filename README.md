#INSTRUCTIONS

mkdir public/products
cp .env.example .env
php artisan key:generate
php artisan migrate
npm install
npm run dev