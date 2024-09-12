# LIBSYS (Library Management System)

## System Requirements

To run this application, you will need:

- PHP version 8.0 or later
- Composer
- MySQL or other database supported by Laravel
- Node.js and NPM (Optional)

## How to Install

Here are the steps to clone this project and install it in your local environment:

1. **Clone Repository**

    First, clone this repository to your local directory using the git command:

    ```bash
    git clone https://github.com/damaskus92/libsys-api.git
    ```

2. **Go to Project Directory**

    Move to the newly cloned project directory:

    ```bash
    cd libsys-api
    ```

3. **Install PHP Dependencies with Composer**

    Run the following command to install all dependencies PHP Required:

    ```bash
    composer install
    ```

4. **Install JavaScript Dependencies with NPM (Optional)**

    To manage front-end dependencies and compile assets, run:

    ```bash
    npm install
    npm run dev
    ```

5. **Copy `.env` File**

    Make a copy of the `.env.example` file and name it `.env`:

    ```bash
    cp .env.example .env
    ```

6. **Set Application Key**

    Create a new application key with the following command:

    ```bash
    php artisan key:generate
    ```

7. **Database Configuration**

    Open the `.env` file and adjust the database configuration according to your locale:

    ```env
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=libsys
    DB_USERNAME=root
    DB_PASSWORD=
    ```

8. **Database Migration and Seeding**

    Run migrations to create database tables and seeders to populate initial data (if any):

    ```bash
    php artisan migrate --seed
    ```

9. **Run Application Server**

    Start Laravel development server using the following command:

    ```bash
    php artisan serve
    ```

    The application will run on <http://localhost:8000>.

## Testing

To run tests, we can use the `.env.testing` file for the test environment configuration.

1. **Create `.env.testing` File**

    Create `.env.testing` file by copying `.env` file:

    ```bash
    cp .env .env.testing
    ```

    Change database settings in `.env.testing` according to your test database:

    ```bash
    DB_CONNECTION=sqlite
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_USERNAME=root
    DB_PASSWORD=
    ```

2. **Create Test Database**

    Create SQlite database for testing:

    ```bash
    touch database/database.sqlite
    ```

3. **Migrate Tables**

    Run migrations to create test tables:

    ```bash
    php artisan migrate --env=testing
    ```

4. **Run Test**

    Use the command below to run the test:

    ```bash
    php artisan test
    ```

## Author

### [Damas Eka Kusuma](https://github.com/damaskus92)
