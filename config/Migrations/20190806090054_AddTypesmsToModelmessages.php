<?php
use Migrations\AbstractMigration;

class AddTypesmsToModelmessages extends AbstractMigration
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
        $table = $this->table('modelmessages');
        $table->addColumn('typesms','string', [
            'default' => 'info',
            'limit' => 60,
            'null' => false,
        ]);
        $table->update();
    }
}
