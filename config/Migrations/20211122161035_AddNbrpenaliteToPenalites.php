<?php
use Migrations\AbstractMigration;

class AddNbrpenaliteToPenalites extends AbstractMigration
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
        $table = $this->table('penalites');
        $table->addColumn('nbr_penalite', 'integer');
        $table->update();
    }
}
