<?php
use Migrations\AbstractMigration;

class AddNomapiToLieugeos extends AbstractMigration
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
        $table = $this->table('lieugeos');
        $table->addColumn('nom_api', 'string');
        $table->addColumn('nom_url', 'string');
        $table->addColumn('from_api', 'integer', [
            'default' => 0
        ]);
        $table->update();
    }
}
