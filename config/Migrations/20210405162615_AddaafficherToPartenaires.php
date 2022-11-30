<?php
use Migrations\AbstractMigration;

class AddaafficherToPartenaires extends AbstractMigration
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
        $table->addColumn('aAfficher', 'string', ['default' => 'OUI']);
        $table->update();
    }
}
