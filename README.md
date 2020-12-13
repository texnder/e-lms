# e-Loan Management system

	the project requirements is: PHP(>= 5.6.*), mySql(>=4.7.9)

In this project [texnder](http://texnder.com/) components are used for routing, dependency Injection, and sessions.. 

all components are design and develope by 
{ 
	"name" : "Inderjeet",
	 "Email" : "inderjeetchohana1431996@gmail.com" 
}

## Installation

This project is uses texnder components so many configration is already done. project needs to connect with database. so configure database credential according to your system. 

go to: 
	config/database.php

once you provide database details. put whole project into your servers public/public_html directory. or if you are on local computer just change your server path to this project. if you are using 'Xampp' server in your computer you can change it by

go to:
	C:\xampp\apache\conf\extra\httpd-vhosts.conf

you can google if any doubt how to change root directory or create virtual host..

NOTE: remember without setting virtual host. '.htaccess' could not redirect http requests to public folder and you'll get error.

Once, you'll set virual host you are done. you'll get index page by simply going to your [localhost](http://127.0.0.1).

## create tables

you can create tables manualy or use project link, once you successfully get home page in your system screen. 

so, To create database tables
	
go to the link: (http://yourhost.com/migrate-tables-in-database)

or 

go to:
	database/migrations.php  => check this file to create tables in database accordingly.

once table created for application in database. you can remove this url by going to: 'routes/web.php' (in this file all routes are defined for the project) or you can left it as it is there is no issue in that i've code everything in that way.

if you've worked in laravel before. you'll understand everthing. otherwise delete this code: 'Route::get('/migrate-tables-in-database', "App\controllers\adminController@migrate");'


here we are using texnder components not any well known php framework like laravel and cake php. so we need to migrate database manualy or by link. because still i'm working on database migration part. soon i'll release database component too on [my server](http://texnder.com/). than, we'll able to do it by command prompt.

Texnder framework uses laravel syntax style thats why it's very easy to understand. here i've not copied any code or used laravel components. it's all coded by me. I've just created similar syntax style to understand easly, for any other coders.


## Controllers

all controllers of the application in app/controllers/..

## views

views is in resources/views/..


## Application:

application is designed for e-loan request, customer can fill there details through our user portal. loan application will be handle by our agents to check or verify and forworded to our admin to approve it.. 

Once customer submit there form and get 'customer_id', they can check application status by entering there 'customer_id' on customer portal  

### Customer

customer can apply for loan by customer portal simply by filling the form. he needs to upload one photo and id card(eg. aadhar card) by default interest rate is 18% per year. minimun loan approval for one year, interest rate can be manage by agent or admin, customer can contact to them.

after submiting the form customer will get a "customer id", so he needs to wait for 5 sec after submission. if form successfully  submitted page will reload and customer_id will pop-up. customer needs to save that id to check status of the loan application.

### Agent

agent need to log in to agent dashboard for any kind of task performance update delete or forwording to admin. without agent approval admin will not approve any application. this is only for security perpose.

Agent can register only by admin.. 

### Admin 

Admin is the boss. he has all authority and to do anything related database.

admin can add agent through there dashboard and approve any loan application. but here for security admin can only approve forworded application by agent. 

once application forworded, admin can update or reject for review, agent can review and update application and can forword again. 

here customer image and id image cant be update. so customer needs to fill there full details again. 

both 'admin' and 'agent' can delete permanently any loan application, not after approved. 


================================== end =====================================

To get vendor components documentation please visit [texnder](http://texnder.com/)

