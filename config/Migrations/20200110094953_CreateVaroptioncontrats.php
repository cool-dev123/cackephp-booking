<?php
use Migrations\AbstractMigration;

class CreateVaroptioncontrats extends AbstractMigration
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
        $table = $this->table('varoptioncontrats')
            ->addPrimaryKey('id')
            ->addColumn('contrat_id','integer')
            ->addColumn('variable_valeur', 'text')
            ->addColumn('option_id','integer');
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
