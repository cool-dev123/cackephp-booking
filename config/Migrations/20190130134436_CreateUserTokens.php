<?php
use Migrations\AbstractMigration;

class CreateUserTokens extends AbstractMigration
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
        $table = $this->table('utilisateurs_tokens')
        ->addPrimaryKey('id')
        ->addColumn('user_id','integer',['limit' => 11])
        ->addColumn('token','string')
        ->addColumn('expired_at','date');
        $table->create();
    }
}
