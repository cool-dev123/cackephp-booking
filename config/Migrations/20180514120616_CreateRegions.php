<?php
use Migrations\AbstractMigration;

class CreateRegions extends AbstractMigration
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
        $table = $this->table('regions', ['id' => false, 'primary_key' => ['id']]);
        $table->addColumn('id', 'integer', [
                'autoIncrement' => true,
                'limit' => 11
            ])
            ->addPrimaryKey('id')
            ->addColumn('name', 'string');
        $table->create();
    }
}
