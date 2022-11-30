<?php
use Migrations\AbstractMigration;

class CreateCalendarsynchro extends AbstractMigration
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
        $table = $this->table('calendarsynchro')
            ->addPrimaryKey('id')
            ->addColumn('nom', 'string')
            ->addColumn('url', 'text');
        $table->addColumn('annonce_id', 'integer', ['default' => 0]);
        $table->addColumn('created', 'datetime', [
            'default' => null,
            'null' => false,
        ]);
        $table->addColumn('modified', 'datetime', [
            'default' => null,
            'null' => false,
        ]);
        $table->create();
    }
}
