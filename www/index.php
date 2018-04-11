<?php
require_once("3rdparty/flight/Flight.php");
require_once("conf/config.php");
require_once("php/settings.php");
require_once("php/routes.php");

Flight::set('flight.views.path', './php');

Flight::stop();
Flight::start();

