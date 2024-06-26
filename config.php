<?php
session_start();

require_once 'vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

// init configuration
$clientID = $_ENV['GOOGLE_CLIENT_ID'];
$clientSecret = $_ENV["GOOGLE_CLIENT_SECRET"];
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
