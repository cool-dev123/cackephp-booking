<?php
use Migrations\AbstractMigration;

class AddcommentaireinventaireToReservations extends AbstractMigration
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
        $table = $this->table('reservations');
        $table->addColumn('commentaire_inventaire', 'text');
        $table->update();
    }
}
