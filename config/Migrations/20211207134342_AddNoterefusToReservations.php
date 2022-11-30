<?php
use Migrations\AbstractMigration;

class AddNoterefusToReservations extends AbstractMigration
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
        $table->addColumn('note_refus', 'text', [
            'default' => "",
        ]);
        $table->update();
    }
}
