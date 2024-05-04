<?php

require_once 'vendor/autoload.php';

session_start();

// init configuration
$clientID = '1030904583782-a2ja0ge3eqoaebbh67l36thk95cptfov.apps.googleusercontent.com';
$clientSecret = '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';
$redirectUri = 'http://localhost/TodosApp/welcome.php';

// create Client Request to access Google API
$client = new Google_Client();
$client->setClientId($clientID);
$client->setClientSecret($clientSecret);
$client->setRedirectUri($redirectUri);
$client->addScope("email");
$client->addScope("profile");

// Connect to database
$hostname = "localhost";
$username = "root";
$password = "";
$database = "todos_app";

$conn = mysqli_connect($hostname, $username, $password, $database);
