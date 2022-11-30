<?php
use Migrations\AbstractMigration;

class AddNbrannulationToUtilisateurs extends AbstractMigration
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
        $table = $this->table('utilisateurs');
        $table->addColumn('nbr_annulation', 'integer', [
            'default' => 0,
        ]);
        $table->update();
    }
}
