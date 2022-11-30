<?php
use Migrations\AbstractMigration;

class AddReservationIdToContactprops extends AbstractMigration
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
        $table->addColumn('reservation_id', 'integer', [
            'default' => 0,
        ]);
        $table->addForeignKey('reservation_id', 'reservations', 'id', ['delete'=> 'CASCADE', 'update'=> 'CASCADE']);
        $table->update();
    }
}
