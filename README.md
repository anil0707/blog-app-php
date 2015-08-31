Developed app using

Language: PHP 5.5.9
Framework: Symfony 2.7
Database: Mysql
Doctrine: version 2.2.3

Steps for installation:

1) git clone https://github.com/CuelogicTech/simple-blog.git

2) Install symfony - refer this link to install

	http://symfony.com/doc/current/book/installation.html

3) Running the Symfony Application

	cd simple-blog/

	sudo chmod 777 app/cache -R
	sudo chmod 777 app/logs -R

	php app/console server:run

4) Load sample data using data fixtures

	php app/console doctrine:fixtures:load

5) URL to access app

	localhost:{portnumber}/app_dev.php/

Note: You can get login credentials from data fixtures in LoadUserData.php file.