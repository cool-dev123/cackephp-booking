<?php
use Migrations\AbstractMigration;

class AddFraisToAnnonces extends AbstractMigration
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
        $table = $this->table('annonces');
        $table->addColumn('montant_frais_menage', 'float', [
                'default' => 0,
            ])
            ->addColumn('accept_animaux', 'integer', [
                'default' => 0,
            ])
            ->addColumn('demande_frais_animaux', 'integer', [
                'default' => 0,
            ])
            ->addColumn('montant_frais_animaux', 'float', [
                'default' => 0,
            ]);
        $table->update();
    }
}
