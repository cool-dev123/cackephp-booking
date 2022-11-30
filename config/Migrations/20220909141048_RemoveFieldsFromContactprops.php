<?php
use Migrations\AbstractMigration;

class RemoveFieldsFromContactprops extends AbstractMigration
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
        $table = $this->table('contactprops');
        $table->removeColumn('nom');
        $table->removeColumn('prenom');
        $table->removeColumn('telephone');
        $table->removeColumn('email');
        $table->update();
    }
}
