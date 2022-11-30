<?php
use Migrations\AbstractMigration;

class AlterLieugeoOnPartenaires extends AbstractMigration
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
        $table = $this->table('partenaires');
        $table->changeColumn('lieugeo_id', 'string');
        $table->update();
    }
}
