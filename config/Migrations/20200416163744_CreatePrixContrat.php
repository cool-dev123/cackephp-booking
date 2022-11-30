<?php
use Migrations\AbstractMigration;

class CreatePrixContrat extends AbstractMigration
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
        $table = $this->table('prix_contrat')
            ->addPrimaryKey('id')
            ->addColumn('contrat_id','integer')            
            ->addColumn('prix', 'float')
            ->addColumn('date_create', 'date');
        $table->addColumn('created', 'datetime', [
            'default' => null,
            'null' => false,
        ]);
        $table->addColumn('modified', 'datetime', [
            'default' => null,
            'null' => false,
        ]);
        $table->create();
    }
}
