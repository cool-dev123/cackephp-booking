<?php
use Migrations\AbstractMigration;

class CreateDomaine extends AbstractMigration
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
        $table = $this->table('domaine');
        $table->addColumn('nom', 'string');
        $table->addColumn('descreption', 'text', [
            'default' => null,
            'null' => true,
        ]);
        // $table->addColumn('url','string');
        $table->addColumn('massif_id','integer',['null' => false]);
        $table->create();
    }
}
