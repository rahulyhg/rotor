<?php

use Phinx\Migration\AbstractMigration;

class CreateAdvertsTable extends AbstractMigration
{
    /**
     * Change Method.
     */
    public function change()
    {
        if (! $this->hasTable('adverts')) {
            $table = $this->table('adverts', ['engine' => env('DB_ENGINE'), 'collation' => env('DB_COLLATION')]);
            $table
                ->addColumn('site', 'string', ['limit' => 100])
                ->addColumn('name', 'string', ['limit' => 50])
                ->addColumn('color', 'string', ['limit' => 10, 'null' => true])
                ->addColumn('bold', 'boolean', ['default' => 0])
                ->addColumn('user_id', 'integer')
                ->addColumn('created_at', 'integer')
                ->addColumn('deleted_at', 'integer', ['null' => true])
                ->create();
        }
    }
}
