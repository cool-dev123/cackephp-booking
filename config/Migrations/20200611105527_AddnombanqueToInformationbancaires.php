<?php
use Migrations\AbstractMigration;

class AddnombanqueToInformationbancaires extends AbstractMigration
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
        $table = $this->table('informationbancaires');
        $table->addColumn('nom_banque', 'string');
        $table->addColumn('RIB', 'string');
        $table->update();
    }
}
