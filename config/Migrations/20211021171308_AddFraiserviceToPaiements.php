<?php
use Migrations\AbstractMigration;

class AddFraiserviceToPaiements extends AbstractMigration
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
        $table = $this->table('paiements');
        $table->addColumn('frais_service', 'float');
        $table->addColumn('type_frais', 'string');
        $table->update();
    }
}
