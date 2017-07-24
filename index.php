<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;


require 'vendor/autoload.php';
$app = new \Slim\App;


require 'php/connection.php';
require 'php/mysqltodb.php';

require 'php/Courses.php';
require 'php/admins.php';
require 'php/login.php';
require 'php/students.php';







$app->run();