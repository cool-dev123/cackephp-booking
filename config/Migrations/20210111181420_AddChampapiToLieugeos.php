<?php
use Migrations\AbstractMigration;

class AddChampapiToLieugeos extends AbstractMigration
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
        $table = $this->table('lieugeos');
        $table->addColumn('sous_description', 'text');
        $table->addColumn('description_api', 'text');
        $table->addColumn('description_ete', 'text');
        $table->addColumn('description_act_ete', 'text');
        $table->addColumn('description_hiver', 'text');
        $table->addColumn('description_act_hiver', 'text');
        $table->addColumn('description_acc', 'text');
        $table->update();
    }
}
