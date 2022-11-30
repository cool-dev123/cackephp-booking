<?php
use Migrations\AbstractMigration;

class CreateUtilisateursCautions extends AbstractMigration
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
        $table = $this->table('utilisateurs_cautions', ['id' => false, 'primary_key' => ['utilisateur_id','caution_id']]);
        $table->addColumn('utilisateur_id','integer');
        $table->addColumn('caution_id','integer');
        $table->create();
    }
}
