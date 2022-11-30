<?php
use Migrations\AbstractMigration;

class AddFlagscodeToLanguages extends AbstractMigration
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
        $table = $this->table('languages')
                ->addColumn('flag_code', 'string', ['after' => 'datatable_file']);
        $table->update();
    }
}
