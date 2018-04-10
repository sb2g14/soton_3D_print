# 3dprint.clients.soton.ac.uk web site 
[![License](https://img.shields.io/badge/License-MIT-blue.svg)](https://opensource.org/licenses/MIT)
[![GitHub contributers](https://img.shields.io/github/contributors/sb2g14/soton_roles.svg)](https://github.com/sb2g14/soton_roles/graphs/contributors)
[![GitHub issues](https://img.shields.io/github/issues/sb2g14/soton_roles.svg)](https://github.com/sb2g14/soton_roles/issues)

## Installtion instruction
Register on the website
  1. Ask the team member to add you to the database.
  2. Register on the website
GitHub
  3. Join GitHub repository (please ask a member of team to send you an invitation).
  4. Run ```git clone https://github.com/sb2g14/soton_roles```
Stack installation
  5. You need to install on of the following stacks: 
  WAMP (Windows) -> Windows, Apache, MySQL, PHP, 
  LAMP (Linux) -> Linux, Apache, MySQL, PHP. (You can find it here: https://tecadmin.net/install-laravel-framework-on-ubuntu/), 
  MAMP (Mac OS) -> Mac OS, Apache, MySQL, PHP. (You can find it here: https://www.mamp.info/en/)
  We're currently running ## Apache 2.0, ## PhP 7.1, ## MySql 5.6 and ## Laravel 5.5 so we recommend you to stick to this versions.
MySql setup
  6. Setup the database. Ask a member of team (Svitlana or Andrew) for a latest dump file containing the database.
  7. Enter MySql: ```mysql -u username -p;```
  8. Create the database: ```CREATE DATABASE 3dprint_workshop; exit;```
  9. Write tables from your dump file: ```mysql -u username -p 3dprint_workshop < dumpfilename.sql```
Running Laravel
  10. Go to ```soton_roles``` directory and open ```.env.example``` file, write the relevant mysql and mail server information and rename it to ```.env```. Now run following in your terminal:
  11. ```composer update```
  12. ```php artisan key:generate```
  13. ```php artisan serve```
  14. If everything is successful the link to your local host will appear in the terminal window. Normally it's http://127.0.0.1:8000 
If you experience any issues please contact us.

## Known issues:
  1. Linux error: unable to locate ext-bcmath. 
    Just type this ```sudo apt install php7.1-bcmath``` in your terminal
    
## We recommend you to use JetBrains intelligent IDEs
  15. You need to visit https://www.jetbrains.com/ apply for a student license and then install PhPStorm and DataGrip IDEs to work with PHP and SQL languages.

## Running the project
1. Go to the soton_roles
  ```php artisan serve```
  copy the link which appeared in the browser.
  
2. If you experience any issues try:
  ```composer upadte```
  ```composer dump-autoload```
  
If you still have errors your database might be outdated
  Go to 4 and 7 of this installation manual.

### Installing NPM
```sudo apt install npm```

```npm install less```

```sudo apt install node-less```

you can now compile less to css using

```lessc resources/assets/less/app.less > public/css/app.css```

## Database updates
### Linux/MacOS
- Dump lates database with mysql dump 
```mysqldump -u root -p[root_password] [database_name] > dumpfilename.sql```
- Feed the dump file into the working database
```mysqldump -u root -p[root_password] [database_name] < dumpfilename.sql```
- Alternatively, edit the sql file and add `USE [database_name];` in the beginning.
  You can then run
```mysql -u root -p < dumpfilename.sql```
### Windows
Do the same but you may encounter issues with ">" and "<". Look for substitutions online. Possibly "-e"

## See it live:
http://3dprint.clients.soton.ac.uk/printers/index

## Get Help on Libraries used:
- *Laravel 5.5* as the PHP framework (https://laravel.com/docs/5.6)
- *Bootstrap 3* (https://getbootstrap.com/docs/3.3/) [![License](https://img.shields.io/badge/License-MIT-blue.svg)](https://opensource.org/licenses/MIT)
- *jQuery* for easy JavaScript (http://jquery.com/) 
- *Carbon* for PHP DateTime variables (http://carbon.nesbot.com/docs/) [![License](https://img.shields.io/badge/License-MIT-blue.svg)](https://opensource.org/licenses/MIT)
- *Charts* by ConsoleTV for easily creating charts in Laravel (https://github.com/ConsoleTVs/Charts/tree/5.4.0/docs/5) [![License](https://img.shields.io/badge/License-MIT-blue.svg)](https://opensource.org/licenses/MIT)
- *Font-Awesome* for icons (https://fontawesome.com/icons?d=gallery&m=free) [![License: CC BY 4.0](https://img.shields.io/badge/License-CC%20BY%204.0-lightgrey.svg)](https://creativecommons.org/licenses/by/4.0/)
- *Bootstrap 3 Datepicker* for date-time picker (http://eonasdan.github.io/bootstrap-datetimepicker/) [![License](https://img.shields.io/badge/License-MIT-blue.svg)](https://opensource.org/licenses/MIT)

## Style Guidelines we try to follow:
- *University Colours* (https://generic.wordpress.soton.ac.uk/brand/category/logo-and-templates/office-templates/%22http:/www.southampton.ac.uk/brand/category/colour/)
- *Material Design Colours* (https://material.io/color/#!/?view.left=1&view.right=1&primary.color=315765&secondary.color=0097c2)

## TODO:
- [ ] Remember to fulfill all license requirements for the pulled packages ASAP...
- [ ] Add Laravel installation instructions/ link to this readme so future programmers can set up their own environment

## License

The [MIT license](http://opensource.org/licenses/MIT).


