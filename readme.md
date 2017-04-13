JWT Wih Native PHP
===================
This is a very simple implementation of **JWT (JSON Web Token)** using native **PHP**, **jQuery**, and **firebase/php-jwt** package

----------

Documentation
-------------

### file explanation
##### /composer.json
This file will handler your composer package

##### /src/server/doGetToken.php
This file will receive a username and password using POST method, and then validate the username and password, if authenticated then return the JWT Token, if not authenticated then return the error message

##### /src/server/doValidateToken.php
This file will validate a token for every request made from client (if you include this file in every php script requires token), if not validated then return an error message, if validated then return the requested resource

##### /src/server/doGetData.php
This is the example of endpoint to get the data resource needed by the client side, this file will require **doValidateToken.php** file.

##### /src/index.html
This file contains a simple login form that will send an username and password using post method to the server.

##### /src/home.html
This is a very simple client that request a data from the server and then update a token for every response by the server.