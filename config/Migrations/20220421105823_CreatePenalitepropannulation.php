<?php
use Migrations\AbstractMigration;

class CreatePenalitepropannulation extends AbstractMigration
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
        $table = $this->table('penalitepropannulation')
                ->addPrimaryKey('id')                
                ->addColumn('utilisateur_id', 'integer')
                ->addColumn('nbr_penalite', 'integer');
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
