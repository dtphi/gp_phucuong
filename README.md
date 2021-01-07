## About this application

Application name is NIMO.   
A Communication tool for store and sales-representative of Nittoh.

## Setup

### Requirement

- Nginx/Apache
- PHP7.4
- MySQL

### Process

```
git pull origin git@github.com:primestyle-co/nittoh_wholesale_management.git
cd nittoh_wholesale_management

# install php dependencies.
composer install

# write env key-values
vi .env

# need to set proper values for below
DB
MailServer

# set up laravel
php artisan key:generate

# DB migration

```
php artisan migrate
```

### Insert initial data

1. create an admin account.
1. insert sales-represantative data
1. insert store data

### Data for production

```
php artisan db:seed --class=CatalogSeeder
php artisan db:seed --class=ProdAdminSeeder
php artisan db:seed --class=ProdRepresentativeSeeder
php artisan db:seed --class=ProdStoreSeeder
```
