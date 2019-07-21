### This is the api created using laravel, complete project working here : [Ver proyecto](http://moviesapp.gmsdevelopment.com.mx/movies)

### Run the project locally
1. Firstable download this project to your local machine.
2. Therafter install all dependencies:
    ```
        composer install
    ```
3. Then, copy the .env.example and name it as .env, at this point you need to add you db credentials and the api key to consume the external api to fetch movies [https://www.themoviedb.org](https://www.themoviedb.org).

4. Thereafter, create a secrete key and run the migrations to create all tables on the database:
    ```
    php artisan key:generate && php artisan migrate
    ```
5. Then you need to create the tokens credentials for passport:
    ```
        php artisan passport:install
    ```
6. Then you can run the web server executing:
    ```
        php artisan serve
    ```

