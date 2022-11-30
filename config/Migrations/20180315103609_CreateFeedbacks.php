<?php
use Migrations\AbstractMigration;

class CreateFeedbacks extends AbstractMigration
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
        $table = $this->table('feedbacks', ['id' => false, 'primary_key' => ['id']]);
        $table->addColumn('id', 'integer', ['autoIncrement' => true])
              ->addColumn('titre', 'string')
              ->addColumn('commentaire', 'text')
              ->addColumn('annonce_id', 'integer')
              ->addColumn('utilisateur_id', 'integer');
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
