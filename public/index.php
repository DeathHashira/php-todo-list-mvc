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
    $email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_SPECIAL_CHARS);
    $password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_SPECIAL_CHARS);
    $username = filter_input(INPUT_POST, "username", FILTER_SANITIZE_SPECIAL_CHARS);
    $confpassword = filter_input(INPUT_POST, "confirm_password", FILTER_SANITIZE_SPECIAL_CHARS);

    if ($confpassword != $password) {
        header("Location: /register");exit;
    }
    
    unset($_POST['confirm_password']);
    (new RegisterController())->register(["email" => $email,
                                        "password" => $password,
                                        "username" => $username]);
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

Router::get('/todos/logout', function() {
    session_unset();
    header("Location: /login");
});

Router::get('/login', function() use ($blade) {
    echo $blade->run('loginview');
});

Router::post('/login', function() {
    $email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_SPECIAL_CHARS);
    $password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_SPECIAL_CHARS);

    (new LoginController)->checkLogin($email, $password);
});

Router::run();