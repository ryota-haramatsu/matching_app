# matching_app

docker-compose up -d && docker-compose exec app bash && php artisan serve --host 0.0.0.0 --port 80

docker-compose up -d / docker-compose restart

docker-compose exec app bash

composer create-project --prefer-dist "laravel/laravel=6.*" .

npm install -D vue

npm install -D vue-template-compiler

composer require laravel/ui:^1.0 --dev

php artisan ui vue

npm install && npm run dev

npm install --save vue-router

npm run dev / npm run watch

php artisan serve --host 0.0.0.0 --port 80

php artisan make:migration create_tasks_table

php artisan make:model Task

php artisan make:seeder TasksTableSeeder

php artisan migrate --seed

mysql -u root -p -h 127.0.0.1 -P 3306 // これ

docker-compose exec db bash

docker-compose up -d // docker-compose.ymlファイルの更新後

composer require laravel/socialite


circleci
ローカルジョブ実行
circleci local execute --job build
Error: Could not find picard image: failed to pull latest docker image: exit status 1

コードの間違い確認
circleci config validate