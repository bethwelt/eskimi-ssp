
# eskimi-ssp


# How to run the app and migrate database 

## First configure the database  parameters on .env file

	DB_CONNECTION=mysql
	DB_HOST=127.0.0.1
	DB_PORT=3306
	DB_DATABASE=eskimi
	DB_USERNAME=eskimi
	DB_PASSWORD=eskimi

## Two make some database migrations

** php artisan migrate 

# Running Tests 
 to run the test run the following commands ,the command will run all the tests i.e create,update,list and delete campaign...

** php artisan test


# Deploying on Docker

Considering docker is already install on the server  the following is the process of deploying it.

## At the root directory of the project i.e  >>>>>>> /var/www/html/eskimi-ssp/ run the following command to build and deploy the app.


>>>>>>> docker-compose up -d 

This  command with build and deploy the app plus installing any required dependency.

To stop docker container run the following 

  >>>>>>> docker-compose down 





