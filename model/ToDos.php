<?php namespace Model;

use Override;

/**
 * Extended class of database for todos table
 */
class ToDos extends DataBase {
    protected string $table_name = 'todos';

    public function getTableName() {
        return $this->table_name;
    }

    #[Override]
    public function create(array $data): bool
    {
        return parent::create($data);
    }

    #[Override]
    public function delete(int $id): bool
    {
        return parent::delete($id);
    }

    #[Override]
    public function update(int $id, array $data,): bool
    {
        return parent::update($id, $data);
    }
}