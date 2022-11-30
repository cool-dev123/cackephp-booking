<?php
use Migrations\AbstractMigration;

class AddActifToCalendarsynchro extends AbstractMigration
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
        $table = $this->table('calendarsynchro');
        $table->addColumn('actif', 'integer', [
            'default' => 1,
        ]);
        $table->update();
    }
}
