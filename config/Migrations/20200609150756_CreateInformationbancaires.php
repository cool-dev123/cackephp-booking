<?php
use Migrations\AbstractMigration;

class CreateInformationbancaires extends AbstractMigration
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
        $table = $this->table('informationbancaires')
            ->addPrimaryKey('id')
            ->addColumn('num_carte', 'string')
            ->addColumn('mois_expiration', 'integer')
            ->addColumn('annee_expiration', 'integer')
            ->addColumn('code_securite', 'string');
        $table->create();
    }
}
