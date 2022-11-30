<?php
use Migrations\AbstractMigration;

class CreateGestionnairesVillages extends AbstractMigration
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
        $table = $this->table('gestionnaires_villages', ['id' => false, 'primary_key' => ['gestionnaire_id','villages_id']]);
        $table->addColumn('gestionnaire_id','integer');
        $table->addColumn('villages_id','integer');
        $table->create();
    }
}
