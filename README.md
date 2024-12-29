# Supportify
PHP/Web Coding Test

# How to Set Up the Supportify System

Follow the steps below to set up and run the Supportify system on your local environment.


## Requirements

- git
- make
- docker
- docker-compose


## Installation

### Clone the Repository
Start by cloning the Supportify repository to your local machine:

```bash
git clone <repository-url>
```

### Navigate to the Project Folder
After cloning the repository, navigate to the project folder:

```bash
cd Supportify/
```

### Create a `.env` file by copying the `.env.example` file:

```bash
cp .env.example .env
```

### Set your `.env` values in the `.env` file.

- Ports.
    > APP_PORT=
    >
    > PHP_MYADMIN_PORT=

- Linux User ID.
    > UID=

- Database details.
    > DB_DATABASE=
    > 
    > DB_USERNAME=
    > 
    > DB_PASSWORD=

- You can change your **"from" email address** in the `.env` file if needed.
    > MAIL_FROM_ADDRESS=

### After creating the `.env` file, start the project using

Spin up main system docker containers.

```bash
make up
```
   *(Run this command inside the Supportify folder terminal.)*

### The project is successfully up, run the following command to enter the system shell

```bash
make shell
```

### Run the following command to install Composer to project

```bash
composer install
```

 Successfully installing Composer, generate the application key

```bash
php artisan key:generate
```
Go to [http://localhost:8001](http://localhost:8001) to access the database manager and create a database using the given database name.

### Run the following command to create the database tables
```bash
php artisan migrate
```
### Install NPM dependencies using
```bash
npm install
```

Compile the frontend assets (CSS and JS) using:

```bash
npm run dev
```

Now you can see the project running in [http://localhost:8000](http://localhost:8000).


### Shutdown main system docker containers.
```bash
make down
```
 *(Run this command inside the Supportify folder terminal.)*


## Create Agent

```bash
php artisan agent:create
```

 **create agent using shell**


# Reference

There are references I used during the system development.

- [Laravel Documentation](https://laravel.com/docs/11.x)
- [Stack overflow](https://stackoverflow.com/)
- [Flowbite - Tailwind CSS component library](https://flowbite.com/docs/getting-started/introduction/)
- [Alpine.js](https://alpinejs.dev/)