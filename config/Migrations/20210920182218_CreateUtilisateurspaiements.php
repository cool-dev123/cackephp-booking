<?php
use Migrations\AbstractMigration;

class CreateUtilisateurspaiements extends AbstractMigration
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
        $table = $this->table('utilisateurs_paiements', ['id' => false, 'primary_key' => ['utilisateur_id','paiement_id']]);
        $table->addColumn('utilisateur_id','integer');
        $table->addColumn('paiement_id','integer');
        $table->create();
    }
}
