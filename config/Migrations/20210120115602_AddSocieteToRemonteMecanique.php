<?php
use Migrations\AbstractMigration;

class AddSocieteToRemonteMecanique extends AbstractMigration
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
        $table->addColumn('societe_RM', 'string');
        $table->update();
    }
}
