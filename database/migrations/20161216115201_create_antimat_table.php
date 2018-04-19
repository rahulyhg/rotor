<?php

use Phinx\Migration\AbstractMigration;

class CreateAntimatTable extends AbstractMigration
{
    /**
     * Migrate Change.
     */
    public function change()
    {
        if (! $this->hasTable('antimat')) {
            $table = $this->table('antimat', ['collation' => env('DB_COLLATION')]);
            $table
                ->addColumn('string', 'string', ['limit' => 100])
                ->create();
        }
    }
}
