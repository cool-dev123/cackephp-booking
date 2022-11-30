<?php
use Migrations\AbstractMigration;

class AddArticlesToLieugeos extends AbstractMigration
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
        $table->addColumn('preposition_a', 'string');
        $table->addColumn('article_de', 'string');
        $table->update();
    }
}
