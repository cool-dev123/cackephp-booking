<?php
use Migrations\AbstractMigration;

class AddVariablesOptionsIdToContratypes extends AbstractMigration
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
        $table = $this->table('contratypes');
        $table->addColumn('variables_id', 'string', [
            'default' => "1;",
        ]);
        $table->addColumn('options_id', 'string', [
            'default' => NULL,
        ]);
        $table->update();
    }
}
