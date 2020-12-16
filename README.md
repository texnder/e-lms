# e-Loan Management system

	the project requirements is: PHP, mySql

In this project [texnder](http://texnder.com/) components are used for routing, dependency Injection, and sessions.. 

all components are design and develope by 
{ 
	"name" : "Inderjeet",
	 "Email" : "inderjeetchohana1431996@gmail.com" 
}

## Setting Up

create docker container using this cmd: "docker-compose up -d"
open your browser and go to localhost. you should get landing page.

if error throw:

Error Message: SQLSTATE[HY000] [2002] Connection refused
Error Code: 2002

++ go to : config/database.php ++
and change the port number 3306 to 8080. In windows, mysql uses 3306 port. wait if you are window user and still show same error. check mysql log: 

[System] [MY-010931] [Server] /usr/sbin/mysqld: ready for connections. Version: '8.0.22' socket: '/var/run/mysqld/mysqld.sock' port: 3306 MySQL Community Server - GPL.

wait till this message occurs on log.. than refresh your page.. which is on localhost i'm assuming..everything will work well after that.. 

=>step-1 :create database in mysql

go to: http://localhost:8080 , and use database="db" username="root" password="example" to login mysql using Adminer UI

The project uses database for crud oprations. here, we are using mysql, and to make project functional we need to create a database.

=>step-2 :update database configuration file

go to: config/database.php and update database name you created. if you are on linux os change db port to 8080 if connection refused.

=>step-3 :migrate tables in database

To migrate tables in database go to: (http://localhost/migrate-tables-in-database)
here localhost could be replace by your domain name. if you are not on local machine.

=> step-4 : admin register by clicking sign up on login page

to perform crud oprations on upcoming requests applications register first admin. and than admin can register agents.


## Controllers

all controllers of the application is in app/controllers/..

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

