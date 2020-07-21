#/bin/bash
cd ../..

gsutil cp gs://schedulia-access/.env.staging .env
composer install

docker build -f ./.deploy/heroku/Dockerfile -t registry.heroku.com/schedulia-api/web .
docker push registry.heroku.com/schedulia-api/web
