<?php
use Migrations\AbstractMigration;

class AddFromapiToMassif extends AbstractMigration
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
        $table = $this->table('massif');
        $table->addColumn('from_api', 'integer', [
            'default' => 0
        ]);
        $table->update();
    }
}
