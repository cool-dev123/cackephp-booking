<?php
use Migrations\AbstractMigration;

class AddColumnsToAnnonces extends AbstractMigration
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
        $table = $this->table('annonces');
        $table
            ->addColumn('position_cle','string')
            ->addColumn('visible','integer',['limit'=>1])
            ->addColumn('id_gestionnaires','integer')
            ->update();
    }
}
