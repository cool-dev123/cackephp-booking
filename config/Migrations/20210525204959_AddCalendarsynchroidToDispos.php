<?php
use Migrations\AbstractMigration;

class AddCalendarsynchroidToDispos extends AbstractMigration
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
        $table = $this->table('dispos');
        $table->addColumn('calendarsynchro_id', 'integer', ['default' => 0]);
        $table->update();
    }
}
