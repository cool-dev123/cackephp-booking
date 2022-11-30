<?php
use Migrations\AbstractMigration;

class CreateLanguages extends AbstractMigration
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
        $table = $this->table('languages')
                ->addPrimaryKey('id')
                ->addColumn('name', 'string')
                ->addColumn('code', 'string')
                ->addColumn('url_code', 'string')
                ->addColumn('datatable_file', 'string');
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
