# VEIL - Online Clothing Shop

A PHP + MySQL e-commerce website built with OpenCart, developed using XAMPP.

---

## Requirements

- XAMPP (Apache + MySQL): https://www.apachefriends.org/download.html
- PHP 7+
- phpMyAdmin

---

## Setup Instructions

1. Clone this repo into your XAMPP `htdocs` folder:
   - **Download** .zip folder
   - Extract the file into a folder
   - Rename folder from '**VEIL-main**' to '**shop**'
   - Place '**shop**' folder inside the 'C:\xampp\htdocs' folder
   - Navigate to 'C:\xampp\php' and open 'php.ini'. Find the ';extension=gd' line and remove the ';' making it just 'extension=gd'

2. Start **Apache** and **MySQL** in XAMPP

3. Import the database:
   - Open **phpMyAdmin**: http://localhost/phpmyadmin
   - Create a new database called `shop`
   - Click **Import** and select `database/shop.sql`

4. Visit the site at:
```
   http://localhost/shop
```
   Or, visit the admin dashboard at:
```
   http://localhost/shop/admin
```
---


## Built With

- PHP
- MySQL
- OpenCart
- XAMPP