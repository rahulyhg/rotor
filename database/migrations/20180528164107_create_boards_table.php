<?php

use Phinx\Migration\AbstractMigration;

class CreateBoardsTable extends AbstractMigration
{
    /**
     * Change Method.
     */
    public function change()
    {
        if (! $this->hasTable('boards')) {
            $table = $this->table('boards', ['engine' => env('DB_ENGINE'), 'collation' => env('DB_COLLATION')]);
            $table
                ->addColumn('sort', 'integer', ['default' => 0])
                ->addColumn('parent_id', 'integer', ['default' => 0])
                ->addColumn('name', 'string', ['limit' => 100])
                ->addColumn('count_items', 'integer', ['default' => 0])
                ->addColumn('closed', 'boolean', ['default' => 0])
                ->create();
        }
    }
}
