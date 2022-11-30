<?php
use Migrations\AbstractMigration;

class CreateReponsecontactprops extends AbstractMigration
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
        $table = $this->table('reponsecontactprops', ['id' => false, 'primary_key' => ['id']]);
        $table->addColumn('id', 'integer', ['autoIncrement' => true])
              ->addColumn('contactprops_id', 'integer')
              ->addColumn('message', 'text');
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
