<?php
use Migrations\AbstractMigration;

class CreateAnnulations extends AbstractMigration
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
        $table = $this->table('annulations')
                ->addPrimaryKey('id')                
                ->addColumn('name', 'string')
                ->addColumn('interval_1', 'integer')
                ->addColumn('interval_2', 'integer')
                ->addColumn('service_pourc', 'integer')
                ->addColumn('reservation_pourc', 'integer');
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
