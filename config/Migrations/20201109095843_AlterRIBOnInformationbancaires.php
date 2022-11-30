<?php
use Migrations\AbstractMigration;

class AlterRIBOnInformationbancaires extends AbstractMigration
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
        $table->renameColumn('RIB', 'IBAN');
        $table->renameColumn('code_securite', 'BIC');
        $table->renameColumn('nom_banque', 'titulaire_compte');
        $table->update();
    }
}
