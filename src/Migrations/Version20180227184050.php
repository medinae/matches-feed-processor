<?php declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180227184050 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        $this->skipIf($schema->hasTable('game'));

        $this->addSql('
          CREATE TABLE game (
            id VARCHAR (255) NOT NULL, 
            venue VARCHAR(255) NOT NULL, 
            played_at DATE NOT NULL, 
            home_team VARCHAR(255) NOT NULL, 
            away_team VARCHAR(255) NOT NULL, 
            home_team_score INT NOT NULL, 
            away_team_score INT NOT NULL, 
            competition_name VARCHAR(255) NOT NULL, 
            PRIMARY KEY(id)
          )
        ');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs

    }
}
