<?php
use Migrations\AbstractMigration;

class AddEnglishToModelmailsysteme extends AbstractMigration
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
        $table = $this->table('modelmailsysteme');
        $table->addColumn('sujetEn','string');
        $table->addColumn('txtmailEn','text');
        $table->addColumn('blockreductionEn','text');
        $table->update();
    }
}
