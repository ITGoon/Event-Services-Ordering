# About
This is an event services ordering website written in PHP NOT BY ME, it was written by my predecessor for a client I do a lot of work for. I have modified it slightly to keep it running on a Debian server as I upgraded it from version 6 to version 9. 
<br><br>
Jan 26 2019:<br>
I have not done a test run of this distributable version but I will do it to confirm it can be easily setup.


# Requirements
- MySQL 5.5 (Though 5.7 should work)
- PHP 5.6 (Requires CLI, FPM, JSON, ADODB, readline, and MySQL PHP 5.6 packages)
- Apache 2.4 (Though Nginx would work with some tweaks)
- PHP mhash extension


# Setup
Once your LAMP server is setup with the above requirements then you can do the following.
1) To get started create a user in mysql called eventservices and set a password for it
2) Create a database called lineorder_production
3) Importal the lineorder_production.sql file in the Database folder into that database
4) In your php.ini for apache2 (Or Nginx) make sure you set the following:
	- short_open_tag = on
3) Move the eventservices folder to your web root 



# Features that have been disabled:
- Receipts<br>
You'll notice  lot of preliminary work done for this feature but I have never tested to see if it was ever working


# Files to Change
## connection.inc.php
Set this to the password for the mysql user eventservices 
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
 
 
 
## test.php
Not a critical file but go ahead and update it by
adding your eventservices mysql user's password 
```
$dbpass = 'PASSWORD';
```



## verifyorder.php
This line is specific to the location I use this ordering site, feel free to change for your needs.
```
<p />If your order includes more than 5 telephone lines, please email lineorders@YOUR_DOMAIN to inquire about special pricing.
```

 
 
