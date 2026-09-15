<?php namespace Model;

use Override;

class Users extends DataBase {
    public function __construct() {
        parent::__construct();
        $this->table_name = 'users';
    }

    public function getTableName() : string
    {
        return $this->table_name;
    }

    #[Override]
    public function create(array $data) : bool
    {
        return parent::create($data);
    }

    #[Override]
    public function delete(int $id) : bool
    {
        return parent::delete($id);
    }

    #[Override]
    public function update(int $id, array $data, $userIdNeeded=false) : bool
    {
        return parent::update($id, $data);
    }

    #[Override]
    public function read(array $wanteds, array $conditions = []) : array
    {
        return parent::read($wanteds, $conditions);
    }

    public function getUserIdByEmail(string $email) : ?int
    {
        $result = $this->read(['id'], ['email' => $email]);
        return !empty($result) ?? (int)$result[0]['id'];
    }
}