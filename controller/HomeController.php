<?php namespace Controller;

require_once __DIR__ . "/../vendor/autoload.php";
use Model\ToDos;

class HomeController
{
    private $validation;

    public function __construct()
    {
        $this->validation = new \Respect\Validation\Validator();
    }

    public function returnList(int $userId) : array 
    {
        $todos = (new Todos())->read(['title', 'status', 'id'], ['user_id' => $userId]);
        return $todos;
    }

    public function updateTodo(int $todoId) : bool
    {
        $data = [
            'status' => true
        ];

        return (new ToDos())->update($todoId, $data);
    }

    public function addTodo(int $userId, string $title) : bool 
    {
        $data = [
            'user_id' => $userId,
            'title' => $title
        ];
        return (new Todos())->create($data);
    }

    public function deleteTodo(int $todoId) : bool 
    {
        return (new Todos())->delete($todoId);
    }
}