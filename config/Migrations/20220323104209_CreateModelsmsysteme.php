<?php
use Migrations\AbstractMigration;

class CreateModelsmsysteme extends AbstractMigration
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
        $table = $this->table('modelsmsysteme')
                ->addPrimaryKey('id')                
                ->addColumn('titre', 'string')
                ->addColumn('txtsms', 'text')
                ->addColumn('indication', 'text')
                ->addColumn('destinataire', 'string')
                ->addColumn('txtsmsEn', 'text', ['null' => true]);
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
