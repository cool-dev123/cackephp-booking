<?php
use Migrations\AbstractMigration;

class CreateOptionscontrats extends AbstractMigration
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
        $table = $this->table('optionscontrats')
        ->addPrimaryKey('id')
        ->addColumn('titre','string')
        ->addColumn('text', 'text')
        ->addColumn('variables_id','string', [
            'default' => "2;",
        ]);
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
