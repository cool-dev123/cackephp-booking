<?php
use Migrations\AbstractMigration;

class AlterLieugeoOnRemonteMecanique extends AbstractMigration
{
    /**
     * Change Method.
     *
     * More information on this method is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-change-method
     * @return void
     */
    public function change()
    {
        $table = $this->table('remonte_mecanique');
        $table->renameColumn('lieugeo_id', 'massif_id');
        $table->update();
    }
}
