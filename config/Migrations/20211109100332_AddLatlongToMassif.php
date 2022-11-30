<?php
use Migrations\AbstractMigration;

class AddLatlongToMassif extends AbstractMigration
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
        $table = $this->table('massif');
        $table->addColumn('latitude', 'string', [
            'default' => null,
            'limit' => 255,
        ]);
        $table->addColumn('longitude', 'string', [
            'default' => null,
            'limit' => 255,
        ]);
        $table->update();
    }
}
