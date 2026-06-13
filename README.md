## Meal Order

An internal restaurant ordering system built with Laravel.

## Project Overview

Meal Order is a graduation project designed to simplify the ordering process inside a restaurant. Customers can scan a QR code to browse the menu and place orders digitally, while restaurant staff can manage menus and monitor incoming orders through an administration panel.

<!-- ## Features -->

## Tech Stack
Laravel 11
PHP 8.x
MySQL
Eloquent ORM
## Database
Approximately 8 database tables.
Relationships defined using Eloquent ORM.
## Notes
This project is being developed as a graduation project.
The system is intended for internal restaurant use.
Customers scan a QR code to select meals and submit their orders.
## User Roles & Authentication Rules

* The system has three employee roles: Admin, Cashier, and Chef.
* Admin accounts are predefined by the system owner.
* Only Admin users can create accounts for Cashiers and Chefs.
* Cashiers and Chefs can log in using the credentials assigned by the Admin.
* Customers do not need an account to use the system.
* Customers scan a QR code to access the menu and place orders as guests.
