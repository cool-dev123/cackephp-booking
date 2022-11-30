<?php
use Migrations\AbstractMigration;

class AddMontantToAnnulationReservations extends AbstractMigration
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
        $table = $this->table('annulation_reservations');
        $table->addColumn('statut', 'string', ['after' => 'reservation_id']);
        $table->addColumn('montant_rembourser', 'float', ['after' => 'statut']);
        $table->update();
    }
}
