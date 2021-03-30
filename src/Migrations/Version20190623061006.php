<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190623061006 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE information CHANGE created_at created_at DATETIME DEFAULT \'2019-02-01\' NOT NULL, CHANGE updated_at updated_at DATETIME DEFAULT \'2019-02-01\' NOT NULL');
        $this->addSql('ALTER TABLE intellectual_property_lecturer DROP FOREIGN KEY FK_AE754D185E62765');
        $this->addSql('DROP INDEX IDX_AE754D185E62765 ON intellectual_property_lecturer');
        $this->addSql('ALTER TABLE intellectual_property_lecturer DROP intellectual_property_id');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE information CHANGE created_at created_at DATETIME DEFAULT \'2019-02-01 00:00:00\' NOT NULL, CHANGE updated_at updated_at DATETIME DEFAULT \'2019-02-01 00:00:00\' NOT NULL');
        $this->addSql('ALTER TABLE intellectual_property_lecturer ADD intellectual_property_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE intellectual_property_lecturer ADD CONSTRAINT FK_AE754D185E62765 FOREIGN KEY (intellectual_property_id) REFERENCES intellectual_property (id)');
        $this->addSql('CREATE INDEX IDX_AE754D185E62765 ON intellectual_property_lecturer (intellectual_property_id)');
    }
}
