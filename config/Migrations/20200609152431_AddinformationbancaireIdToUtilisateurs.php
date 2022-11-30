<?php
use Migrations\AbstractMigration;

class AddinformationbancaireIdToUtilisateurs extends AbstractMigration
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
        $table->addColumn('informationbancaire_id', 'integer');
        $table->update();
    }
}
