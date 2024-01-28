<h1 align="center">QR-Generated Visitor Management System</h1>

## 📌 Application/System Environment

1. Laravel Version : 10.39.0
2. PHP Version : 8.2.12
3. Composer Version : 2.6.6

To check your app environment, run the command:

```bash
php artisan about
```

##

## 📌 Installation

Follow the steps below to install and run the QR-Generated VMS.

1. Open the folder in VS Code and open the terminal in your root directory (folder).

- Path on the terminal should be `\xampp\htdocs\vms>` or `\xampp\htdocs\[the downloaded folder name]> `

2. Use the following command to install the composer.

```bash
composer install
```

3. Run the following command to generate the key.

```bash
php artisan key:generate
```

4. By running the following command, you will be able to get all the dependencies in your **node_modules** folder:

```bash
yarn
```

5. To run the project, you need to run the following command in the project directory. It will compile JavaScript and Styles.

```bash
yarn dev
```

6. To serve the application, you need to run the following command in the project directory.

```bash
php artisan serve
```

7. Now navigate to the given address, and you will see your application is running.

##

## 📌 Seed Database

1. Open the folder in VS Code and open the terminal.
2. Use the following command to create a database (vmsdb) and migrate the tables.
   Type `'yes'` if it returns database 'vmsdb' does not exist on the 'mysql' connection.

```bash
php artisan migrate
```

3. Seed the users seeder by running the following command. Users seeder consists of pre-made authorization credentials, so you can access the application.

```bash
php artisan db:seed --class=CreateUsersSeeder
```

- You can see the credentials on `database\seeders\CreateUsersSeeder.php`.

4. **[OPTIONAL & ONLY FOR TESTING]** Seed the visitors seeder by running the following command. Visitors seeder is used to generate random visitors.

- You can change the dates to your desire in the file `database\seeders\DatabaseSeeder.php` and just make sure to run the command below.

```bash
php artisan db:seed --class=DatabaseSeeder
```

5. **[OPTIONAL]** If you want to restart the database, run the command:

```bash
php artisan db:wipe
```

And migrate the tables again with the command:

```bash
php artisan migrate
```
