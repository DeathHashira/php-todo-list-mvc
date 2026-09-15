<?php 

error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

require_once __DIR__ . '/../vendor/autoload.php';

use Controller\HomeController;
use Controller\LoginController;
use Src\Router;
use Src\Sessions;
use eftec\bladeone\BladeOne;
use Controller\RegisterController;

$blade = new BladeOne(__DIR__ . '/../views', __DIR__ . '/../cache', BladeOne::MODE_DEBUG);

session_start();

Router::get('/', function() {
    header('Location: /register');
});

Router::get('/register', function() use ($blade) {
    echo $blade->run('registerview');
});

Router::post('/register', function() {
    unset($_POST['confirm_password']);
    (new RegisterController())->register($_POST);
});

Router::get('/todos', function() use ($blade) {
    Sessions::checkAuthentication();
    $todos = (new HomeController)->returnList($_SESSION["user_id"]);
    echo $blade->run('homeview', ['todos' => $todos]);
});

Router::get('/todos/update', function() {
    (new HomeController)->addTodo($_SESSION["user_id"], $_GET["newtask"]);
    header("Location: /todos");
});

Router::get('/todos/delete', function() {
    (new HomeController)->deleteTodo($_GET["task_id"]);
    header("Location: /todos");
});

Router::get('/todos/updatestatus', function() {
    (new HomeController)->updateTodo($_GET["task_id"]);
    header("Location: /todos");
});

Router::get('/login', function() use ($blade) {
    echo $blade->run('loginview');
});

Router::post('/login', function() {
    (new LoginController)->checkLogin($_POST["email"], $_POST["password"]);
});

Router::run();