﻿# Voting-System-Codeigniter
#Setting up project
1. Download the project from the github repository
2. Extract the project to the htdocs folder in xampp (*make sure to empty the htdocs folder first*)
3. Open the project folder in your code editor preferably Visual Studio Code
4. Go to application folder -> config and there you can see the database.php file
5. Open the database.php file and edit the database connection settings to your database settings
6. After editing the database.php file you can save it and go to the browser and type "localhost" or "127.0.0.1"
7. You can now use the system

#Setting up database
1.open localhost/phpmyadmin
2.create database "votingniter"
3.press import you can find the import on the top of the site
4.choose file and select the votingniter.sql
5.press go

open this link on your browser either "127.0.0.1" or "localhost" and you can now use the system
admin login ->
username: pjquiros
password: pjquiros

voters login ->
user: amberbatigbatas
password: amberbatigbatasan

the default password for each login is the username itself or everytime you create a new admin account or a voters account the password is the username itself (*note: the password stored in the database is encrypted with md5 in order to decrypt it you need to use a md5 decrypter*)

----------------------------------------------------------------------------------------------------------------

# Tutorial to edit the system's frontend
1. Open the project folder in your code editor preferably Visual Studio Code
2. Go to application folder -> views and there you can see the files that are used to display the frontend of the system
3. You can edit the files using HTML, CSS, and Javascript to change the frontend of the system to your liking and be more careful not to touch or delete the PHP code in the files. *DO NOT TOUCH THE PHP CODE IF YOU DONT KNOW WHAT YOU ARE DOING*
4. After editing the files you can save it and go to the browser and refresh the page to see the changes you made
5. If you want to change the images in the system you can go to the public folder and there you can see the images that are used in the system
6. You can replace the images with your own images but make sure that the image name is the same as the image you want to replace
7. After replacing the images you can refresh the page in the browser to see the changes you made.

*TAKE NOTE: admin page frontend is in the admin folder
htdocs -> admin folder -> application -> views <------- for admin page
htdocs -> application -> views <------- for voters page
-------------------------------------------------------------------------------------------------------------------

#Tutorial for backend

1. Open the project folder in your code editor preferably Visual Studio Code
2. Go to application folder -> controllers and there you can see the files that are used to control the backend of the system
3. You can edit the files using PHP to change the backend of the system to your liking and be more careful not to touch or delete the existing PHP code in the files. *DO NOT TOUCH THE PHP CODE IF YOU DONT KNOW WHAT YOU ARE DOING*
4. After editing the files you can save it and go to the browser and refresh the page to see the changes you made

*TAKE NOTE: admin page backend is in the admin folder
htdocs -> admin folder -> application -> controllers <------- for admin page
htdocs -> application -> controllers <------- for voters page
-------------------------------------------------------------------------------------------------------------------

#Tutorial for re-routing the pages

1. Open the project folder in your code editor preferably Visual Studio Code
2. Go to application folder -> config and there you can see the routes.php file
3. You can edit the routes.php file to re-route the pages in the system to your liking and be more careful not to touch or delete the existing PHP code in the file. *DO NOT TOUCH THE PHP CODE IF YOU DONT KNOW WHAT YOU ARE DOING*
4. After editing the files you can save it and go to the browser and type the re-routed page in the browser to see the changes you made

example:
$route['default_controller'] = 'admin';
$route['login'] = 'auth';
$route['voting'] = 'admin/voting';
$route['kandidat'] = 'admin/kandidat';
$route['pemilih'] = 'admin/pemilih';
$route['pengaturan'] = 'admin/pengaturan';


if you want to go to admin page you will type "localhost/admin" in the browser
localhost/(*Route Value*) or localhost/admin/voting

*TAKE NOTE: admin page re-routing is in the admin folder
htdocs -> admin folder -> application -> config -> routes.php <------- for admin page
htdocs -> application -> config routes.php <------- for voters page

-------------------------------------------------------------------------------------------------------------------

#DATABASE GUIDE

admin table -> handle the admin account
ikut_kandidat -> handles the votings of the candidates or handles the voting countings
ikut_voting -> this is where the votes are stored
kandidat -> this is where the candidates are stored
pemilih -> this is where the voters are stored
pengaturan -> this is where the settings of the system are stored


--------------------------------------------------------------------------------------------------------------------

#FRAMEWORKS USED

1. CodeIgniter
https://codeigniter.com/
2. Bootstrap (AdminLite Template)
https://adminlte.io/
3. Xampp 8.0.30
https://sourceforge.net/projects/xampp/files/XAMPP%20Windows/8.0.30/xampp-windows-x64-8.0.30-0-VS16-installer.exe/download
