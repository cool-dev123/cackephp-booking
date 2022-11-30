<?php
use Migrations\AbstractMigration;

class AddOptionsToAnnonces extends AbstractMigration
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
        $table = $this->table('annonces')
            ->addColumn('espace_plein_air', 'integer')
            ->addColumn('brasero', 'integer')
            ->addColumn('barbecue', 'integer')
            ->addColumn('plancha', 'integer')
            ->addColumn('linge_lit', 'integer')
            ->addColumn('serviettes', 'integer')
            ->addColumn('quoi_lire', 'integer')
            ->addColumn('espace_piscine', 'integer')
            ->addColumn('salle_fitness', 'integer')
            ->addColumn('lit_bebe', 'integer')
            ->addColumn('chaise_bebe', 'integer')
            ->addColumn('baigoire_bebe', 'integer')
            ->addColumn('reserv_sur_place', 'integer');
        $table->update();
    }
}
