<?php
use Migrations\AbstractMigration;

class CreateMedia extends AbstractMigration
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
        $table = $this->table('media')
                ->addPrimaryKey('id')                
                ->addColumn('name_key', 'string')
                ->addColumn('title_ete', 'string')
                ->addColumn('title_hiver', 'string')
                ->addColumn('lien_ete', 'string')
                ->addColumn('lien_hiver', 'string');
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
