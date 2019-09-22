# About
This is an event services ordering website written in PHP NOT BY ME, it was written by my predecessor for a client I do a lot of work for. I have modified it slightly to keep it running on a Debian server as I upgraded it from Debian 6 to Debian 9. 
<br><br>
## Features:
- User management with three levels of permissions
 <br>   -> Admin can edit all including users 
 <br>   -> User can only view and update orders
 <br>   -> Unsure of what Order Admin can do right now
- Associate email addresses with certain service categories so an email is sent when services in that category are ordered
- Mark orders as assigned, partially complete, complete, and decommisioned


# Requirements
- OS: Anything that can run MySQL, PHP 5.6, and some sort of web server that is compatible with PHP 5.6
- MySQL 5.5 (5.7 should work, MariaDB does work)
- PHP 5.6 (Requires CLI, FPM, JSON, ADODB, readline, and MySQL PHP 5.6 extensions)
- Apache 2.4 but confirmed working wiht Nginx and probably works with Lighttpd

# Environment Setup
Setup your LAMP and install the Event Services site. I am using Debian 9, but you can alter any of these instructions for another distribution.

1) First lets install Apache, MySQL (MariaDB), and PHP 5.6 in Debian.
```
apt-get update
apt-get install apache2 mysql-server
apt-get install apt-transport-https lsb-release ca-certificates
wget -O /etc/apt/trusted.gpg.d/php.gpg https://packages.sury.org/php/apt.gpg
echo "deb https://packages.sury.org/php/ $(lsb_release -sc) main" > /etc/apt/sources.list.d/php.list
apt-get update
apt-get install php5.6
apt-get install php5.6-mysql php5.6-fpm libphp-adodb
service apache2 restart
```

2) Copy the folder containing all of the files from github to the web root (Usually /var/www/html/) and rename to eventservices. I'll put the git command here if you insist....

3) Now we'll setup the databse in SQL. Login to sql with: 
```
mysql -u root -p
```
Password will be your root password
You will now be at a sql prompt.
Run this to create the database: 
```
CREATE DATABASE lineorder_production;
```
Then create your user and set their password to something complex (DOCUMENT IT SOMEWHERE): 
```
CREATE USER 'eventservices' IDENTIFIED BY 'mypassword';
```
Grant your user rights to access sql from localhost:  
```
GRANT USAGE ON *.* TO 'eventservices'@localhost IDENTIFIED BY 'mypassword';
```
Grant user rights to the database we made: 
```
GRANT ALL privileges ON `lineorder_production`.* TO 'eventservices'@localhost;
```
Apply what we've done: 
```
FLUSH PRIVILEGES;
```
Exit the sql prompt: 
```
QUIT;
```

4) Now that the database is setup lets import the tables and columns we'll need. Run the following:
```
mysql -u root -p lineorder_production < /var/www/html/eventservices/lineorder_production.sql
```

5) Make Apache's user the owner of the folder and files that are part of the event ordering site: 
```
chown -R www-data:www-data /var/www/html/eventservices
```

6) Now edit your php.ini to allow short open tags, you're looking for the line short_open_tag = Off. Change it to On. Then restart Apache.
```
nano /etc/php/5.6/apache2/php.ini
service apache2 restart
```
Now let's edit some important files. See next section.

# Files to Change
We need to make some changes in the files that are part of this event services site.
## connection.inc.php
Set this to the password used above for the mysql user eventservices 
```
$dbpass1 = "PASSWORD";
```
## completeOrder.php
Change the following line, self explanatory
```
<p /><a href="http://YOUR_DOMAIN_HERE/eventservices/placeorder.php">Place another order</a>
```

## header.php 
Change two lines, first 
```
<title>YOUR COMPANY HERE - Event Service Orders</title>
```
Then change
```
<tr><td class="layout" width="180" style="background-color: #ef1f1f"><img src="YOUR LOGO URL" border="0" width="400" height="39" /></td>
```


## processPendingOrder.php
This is an important one, it redirects the information entered in the order to the payment processing site.
This specific example uses VISA's authorize.net service but since I did not set it up I am not sure what the 
two key values were for (Except that they are private so I removed them). Please see any documentation authorize.net offers 
you if you are a customer of theirs. 
```
<form name="paymentForm" id="paymentForm" method="post" action="Authorize.net Transaction Gateway URL">
 <? InsertFP("KEY1", "KEY2", $ordertotal, mt_rand(1, 1000)) ?>
 <input type="hidden" name="x_login" value="KEY1" />
```
Also update the following for your logo and order completion URL
```
 <input type="hidden" name="x_logo_url" value="YOUR LOGO URL" />
```
 AND
```
 <input type="hidden" name="x_relay_url" value="http://YOUR_DOMAIN_HERE/eventservices/completeOrder.php" />
```
 
 
## processorder.php
Similar to the above, change the following
```
<form name="paymentForm" id="paymentForm" method="post" action="Authorize.net Transaction Gateway URL">
 <? InsertFP("KEY1", "KEY2", $order['cost'], mt_rand(1, 1000)) ?>
 <input type="hidden" name="x_login" value="KEY1" />
```
AND
```
 <input type="hidden" name="x_logo_url" value="YOUR LOGO URL" />
```
AND
```
 <input type="hidden" name="x_relay_url" value="http://YOUR_DOMAIN_HERE/eventservices/completeOrder.php" />
```

## verifyorder.php
This line is specific to the location I use this ordering site, feel free to change for your needs or remove it.
```
<p />If your order includes more than 5 telephone lines, please email lineorders@YOUR_DOMAIN to inquire about special pricing.
```

# Initial Setup
1) Navigate to your newly setup Event Services ordering page at http://Your_Domain_or_Server_IP/eventservices
2) At the bottom of the page click login, login with initialize / logitin
3) Create a new user for yourself with Admin permissions under User List > Add User
4) Logout and login as that new user then delete the user named initialize. 
5) Begin configuring your events and services. For event dates use the format YEAR-MO-DY <br><br>
Example of some services and service categories:
![alt text](https://github.com/ITGoon/Event-Services-Ordering/blob/master/Example.png)

# Cleanup
Once you're ready lets remove some files you don't need. 
```
rm /var/www/html/eventservices/lineorder_production.sql
rm /var/www/html/eventservices/README.md
rm /var/www/html/eventservices/Example.png
rm /var/www/html/eventservices/UnlistedExample.PNG
```

# OPTIONAL: Configure Unlisted Event Option
This option allows your customers to put in a custom event name and date. Here is an example of what it looks like:
![alt text](https://github.com/ITGoon/Event-Services-Ordering/blob/master/UnlistedExample.PNG)

1) First log into sql: 
```
mysql -u root -p
```
2) Next lets select our database.
```
USE lineorder_production;
```
3) To add this feature let's run this SQL query:
```
INSERT INTO events (id, name, start_date, end_date, deleted) VALUES ('1', 'Unlisted Event', NULL, NULL, '0');
```
This adds an event entry in the database with NULL values for the dates, this will allow a pair of text boxes to appear when Unlisted Event is selected and the customer can put in their event name.

To remove this feature run the following SQL query: 
```
DELETE FROM `events` WHERE `name` = 'Unlisted Event';
```


# Features that have been disabled:
- Receipts<br>
You'll notice  lot of preliminary work done for this feature but I have never tested to see if it was ever working



 
 
