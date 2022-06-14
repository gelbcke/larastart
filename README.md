<div id="header" align="center">

<img src="public/img/LaraStartBanner_white.png" width="100%">

</div>

---

<div align="center">

[![pt-br](https://img.shields.io/badge/lang-pt--br-green.svg)](https://github.com/gelbcke/larastart/blob/main/README-pt_br.md)
[![en](https://img.shields.io/badge/lang-en-red.svg)](https://github.com/gelbcke/larastart/blob/main/README.md)

---

**Laravel Version: 9.x**

**AdminLTE Version: 3.2.0**

</div>

---

# About

LaraStart is your tool to start a new project. It contains the most important and necessary resources to start a new project.

---

# **!!! Atention !!!**

If you find any security issue, please contact me on juniorgelbcke@gmail.com

**Please, don't open a Issue**

---

# Done and To Do

<input type="checkbox" checked /> User Authentication

<input type="checkbox" checked /> User default primary key as UUID

<input type="checkbox" checked /> Single session for users

<input type="checkbox" checked /> Option to deactivate user access

<input type="checkbox" checked /> 2FA autentication with Google Authenticator/Authy _(Enabled by user)_

<input type="checkbox" checked /> Auto Lock system by inactivity _(Enabled by user)_

<input type="checkbox" checked /> Backend with AdminLTE 3.2.0

<input type="checkbox" checked /> Multi theme

<input type="checkbox" checked /> Language Switcher

<input type="checkbox" checked /> Log System

<input type="checkbox" checked /> System Settings (currency, timezone, date and time format)

<input type="checkbox" /> Groups and Roles Permission

<input type="checkbox" /> 2FA authentication with e-mail

<input type="checkbox" /> Internal Chat

<input type="checkbox" /> Mailbox (Inbox, Composer and Read)

<input type="checkbox" /> Translation to German, French and Spanish

---

# Setting Up

---

1. Run `git clone https://github.com/gelbcke/larastart.git`

2. Go to folder project
    - `cd /var/www/html/lara_start`
3. From the project root folder run
    - `sudo cp .env.example .env`
4. Configure your `.env` file
5. From the project root folder run

    - `composer install`
    - `php artisan key:generate`
    - `php artisan migrate`
    - `php artisan db:seed`
    - `php artisan storage:link`
    - `composer dump-autoload`

6. Set Folders and Files Permissions

-   `sudo chmod -R 777 ./`
-   `sudo chown -R www-data:www-data ./`
-   `sudo find ./ -type f -exec chmod 644 {} \;`
-   `sudo find ./ -type d -exec chmod 755 {} \;`
-   `sudo chgrp -R www-data storage bootstrap/cache`
-   `sudo chmod -R ug+rwx storage bootstrap/cache`
-   `sudo chmod -R 777 ./bootstrap/cache/`

---

# Credentials from SEED

> -   User: admin@larastart.com
> -   Password: secret
