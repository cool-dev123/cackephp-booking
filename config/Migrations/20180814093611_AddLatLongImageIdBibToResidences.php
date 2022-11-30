<?php
use Migrations\AbstractMigration;

class AddLatLongImageIdBibToResidences extends AbstractMigration
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
        $table = $this->table('residences');
        
        $table->addColumn('latitude','string',[
            'default' => null,
            'limit' => 255,
            'null' => false,]);
        
        $table->addColumn('longitude','string',[
            'default' => null,
            'limit' => 255,
            'null' => false,]);
        
        $table->addColumn('bibliotheque_id','integer', ['after' => 'id_village']);
        
        $table->update();
    }
}
