<?php
use Migrations\AbstractMigration;

class CreateMassif extends AbstractMigration
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
        $table->addColumn('nom', 'string');
        $table->addColumn('descreption', 'text', [
            'default' => null,
            'null' => true,
        ]);
        // $table->addColumn('image','string');
        $table->create();
    }
}
