<?php
use Migrations\AbstractMigration;

class AddColumnsToLieugeos extends AbstractMigration
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
        $table = $this->table('lieugeos');
        $table->addColumn('domaine_id','integer',['null' => true]);
        $table->addColumn('massif_id','integer',['null' => false]);
        $table->addColumn('latitude','string');
        $table->addColumn('longitude','string');
        $table->addColumn('descreption','text', [
            'default' => null,
            'null' => true,
        ]);
        $table->addColumn('ALT_BAS','decimal');
        $table->addColumn('ALT_HAUT','decimal');
        // $table->addColumn('etat','boolean');
        $table->addColumn('urlBlog','string', [
            'default' => null,
            'null' => true,
        ]);
        $table->update();
    }
}
