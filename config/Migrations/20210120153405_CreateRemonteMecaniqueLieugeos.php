<?php
use Migrations\AbstractMigration;

class CreateRemonteMecaniqueLieugeos extends AbstractMigration
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
        $table = $this->table('remonte_mecanique_lieugeos', ['id' => false, 'primary_key' => ['remonte_mecanique_id','lieugeo_id']]);
        $table->addColumn('remonte_mecanique_id','integer');
        $table->addColumn('lieugeo_id','integer');
        $table->create();
    }
}
