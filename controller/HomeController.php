<?php namespace Controller;

require_once __DIR__ . "/../vendor/autoload.php";
use Model\ToDos;

class HomeController
{
    /**
     * Return all tasks for specific user
     */
    public function returnList(int $userId) : array 
    {
        $todos = (new Todos())->read(['title', 'status', 'id'], ['user_id' => $userId]);
        return $todos;
    }

    /**
     * Update status of specific task
     */
    public function updateTodo(int $todoId) : bool
    {
        $data = [
            'status' => true
        ];

        return (new ToDos())->update($todoId, $data);
    }

    /**
     * Create new task for specific user
     */
    public function addTodo(int $userId, string $title) : bool 
    {
        $data = [
            'user_id' => $userId,
            'title' => $title
        ];
        return (new Todos())->create($data);
    }

    /**
     * Delete specific task
     */
    public function deleteTodo(int $todoId) : bool 
    {
        return (new Todos())->delete($todoId);
    }
}