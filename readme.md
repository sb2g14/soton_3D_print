# 3dprint.clients.soton.ac.uk web site 
[![License](https://img.shields.io/badge/License-MIT-blue.svg)](https://opensource.org/licenses/MIT)
[![GitHub contributers](https://img.shields.io/github/contributors/sb2g14/soton_3D_print.svg)](https://github.com/sb2g14/soton_3D_print/graphs/contributors)
[![GitHub issues](https://img.shields.io/github/issues/sb2g14/soton_3D_print.svg)](https://github.com/sb2g14/soton_3D_print/issues)

## Installation instruction

### Register on the website

  1. Ask the team member to add you to the database.
  2. Register on the website
  
### GitHub

  3. Join GitHub repository (please ask a member of the team to send you an invitation).
  4. Run ```git clone https://github.com/sb2g14/soton_3D_print```
  
### Stack installation

  5. You need to install one of the following stacks: 
  
  WAMP (Windows) -> Windows, Apache, MySQL, PHP
  
  LAMP (Linux) -> Linux, Apache, MySQL, PHP. (You can find it here: https://tecadmin.net/install-laravel-framework-on-ubuntu/)
  
  MAMP (Mac OS) -> Mac OS, Apache, MySQL, PHP. (You can find it here: https://www.mamp.info/en/)
  
  We're currently running ## Apache 2.0, ## PhP 7.1, ## MySql 5.6 and ## Laravel 5.5 so we recommend you to stick to this versions.
  
### MySql setup

  6. Setup the database. Ask a member of the team (Svitlana or Andrew) for the latest dump file containing the database.
  7. Enter MySql: ```mysql -u username -p;```
  8. Create the database: ```CREATE DATABASE 3dprint_workshop; exit;```
  9. Write tables from your dump file: ```mysql -u username -p 3dprint_workshop < dumpfilename.sql```
  
### Running Laravel

  10. Go to the ```soton_3D_print``` directory and open ```.env.example``` file, write the relevant mysql and mail server information and rename it to ```.env```. Now run following in your terminal:
  11. ```composer update```
  12. ```php artisan key:generate```
  13. ```php artisan serve```
  14. If everything is successful the link to your local host will appear in the terminal window. Normally it's http://127.0.0.1:8000 
If you experience any issues please contact us.

## Known issues:
Linux error: unable to locate ext-bcmath. 
    Just type this ```sudo apt install php7.1-bcmath``` in your terminal. Remember to use the correct version of your php. If you are unsure chek it with ```php -v```.
    
## We recommend you to use JetBrains intelligent IDEs
You need to visit https://www.jetbrains.com/ apply for a student license and then install PhPStorm and DataGrip IDEs to work with PHP and SQL languages.

## Running the project
1. Go to the soton_3D_print
  ```php artisan serve```
  copy the link which appeared in the browser.
  
2. If you experience any issues try:

   ```composer update```
  
    ```composer dumpautoload```
  
    If you still have errors your database might be outdated. Go to 4 and 7 of this installation manual.

### Installing NPM
```sudo apt install npm```

```npm install less```

```sudo apt install node-less```

you can now compile less to css using

```lessc resources/assets/less/app.less > public/css/app.css```

### Deploy the project on the RaspberyPi server

The full instruction can be found on the next link, however, several first steps has been done before 
https://medium.com/laravel-news/the-simple-guide-to-deploy-laravel-5-application-on-shared-hosting-1a8d0aee923e

So next we present a short instuction what should be done to update the project on server from the github repository
1. Merge branches ```master``` and ```develop```
2. ```ssh server@3dprint.clients.soton.ac.uk```
3. ```cd /var/soton_3D_print/```
4. ```sudo git pull```
5. ```sudo composer update```
6. ```sudo composer dumpautoload -o```
7. ```sudo php artisan config:cache```
8. ```sudo php artisan route:cache```
9. ```cd ..```
10. ```sudo chmod +x sync.sh```
11. ```sudo ./sync.sh```
12. Check https://3dprint.clients.soton.ac.uk/ if everything works.

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
- *Font-Awesome* for icons (https://fontawesome.com/v4.7.0/icons/) [![License: CC BY 4.0](https://img.shields.io/badge/License-CC%20BY%204.0-lightgrey.svg)](https://creativecommons.org/licenses/by/4.0/)
- *Bootstrap 3 Datepicker* for date-time picker (http://eonasdan.github.io/bootstrap-datetimepicker/) [![License](https://img.shields.io/badge/License-MIT-blue.svg)](https://opensource.org/licenses/MIT)

## Style Guidelines we try to follow:
- *University Colours* (https://generic.wordpress.soton.ac.uk/brand/category/logo-and-templates/office-templates/%22http:/www.southampton.ac.uk/brand/category/colour/)
- *Material Design Colours* (https://material.io/color/#!/?view.left=1&view.right=1&primary.color=315765&secondary.color=0097c2)

## TODO:
- [ ] Remember to fulfil all license requirements for the pulled packages ASAP...
- [x] Add Laravel installation instructions/ link to this readme so future programmers can set up their own environment

## License

The [MIT license](http://opensource.org/licenses/MIT).


