#Features of a simple blog

    As a guest I want to see a listing of all the blog posts so I get a quick overview of the news.
    As a guest I want to see a blog post in detail so I can get better understanding of the subject.
    As a guest I want to comment on a blog post so I can share my feelings.
    As an editor I want to have a listing of all the blog posts so I can quickly find what I am looking for.
    As an editor I want to be able to create a new blog post so I can share my thoughts with the rest of the world
    As an editor I want to be able to edit a blog post so I can correct typeo’s
    As an editor I want to be able to publish, unpublish and delete a blog post in case I wrote something I am not allowed to write.


#Technology Used

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
