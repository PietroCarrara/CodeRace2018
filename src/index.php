<?php

// Error handling
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once 'vendor/autoload.php';
require 'rb-mysql.php';

use Phroute\Phroute\RouteCollector;
use Phroute\Phroute\Dispatcher;

// Carregar .env
$dotenv = new Dotenv\Dotenv(__DIR__);
$dotenv->load();

// Banco
$hostname = "localhost";
$user = "root";
$pass = NULL; // getenv('MYSQL_PASSWORD');
$db = "coderace2018";
R::setup("mysql:host=$hostname;dbname=$db", "$user", "$pass");

# Sessão
session_start();

# Definir as rotas
# TODO: Definir essas funções em outros arquivos pra ficar bonito
$router = new RouteCollector();

// Model
require 'model/Peso.php';
require 'model/Error.php';
require 'model/Success.php';
require 'model/Session.php';

// Routes
require 'routes/animal/create.php';
require 'routes/animal/get.php';
require 'routes/animal/pesos/add.php';

require 'routes/auth/register.php';
require 'routes/auth/login.php';
require 'routes/auth/info.php';

# Preparar o cara que escolhe a rota certa
$dispatcher = new Dispatcher($router->getData());
# Escolher a rota
$dispatcher->dispatch($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);

?>
