<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190626230925 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE conference_lecturer (id INT AUTO_INCREMENT NOT NULL, lecturer_id INT DEFAULT NULL, conference_id INT DEFAULT NULL, INDEX IDX_D18E9767BA2D8762 (lecturer_id), INDEX IDX_D18E9767604B8382 (conference_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE conference (id INT AUTO_INCREMENT NOT NULL, uploader_id INT DEFAULT NULL, year_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, name_of_conference VARCHAR(255) NOT NULL, type_of_participation INT NOT NULL, conference_date DATE NOT NULL, place VARCHAR(255) NOT NULL, level SMALLINT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_911533C816678C77 (uploader_id), INDEX IDX_911533C840C1FEA7 (year_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE conference_lecturer ADD CONSTRAINT FK_D18E9767BA2D8762 FOREIGN KEY (lecturer_id) REFERENCES lecturer (id)');
        $this->addSql('ALTER TABLE conference_lecturer ADD CONSTRAINT FK_D18E9767604B8382 FOREIGN KEY (conference_id) REFERENCES conference (id)');
        $this->addSql('ALTER TABLE conference ADD CONSTRAINT FK_911533C816678C77 FOREIGN KEY (uploader_id) REFERENCES lecturer (id)');
        $this->addSql('ALTER TABLE conference ADD CONSTRAINT FK_911533C840C1FEA7 FOREIGN KEY (year_id) REFERENCES year (id)');
        $this->addSql('ALTER TABLE information CHANGE created_at created_at DATETIME DEFAULT \'2019-02-01\' NOT NULL, CHANGE updated_at updated_at DATETIME DEFAULT \'2019-02-01\' NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE conference_lecturer DROP FOREIGN KEY FK_D18E9767604B8382');
        $this->addSql('DROP TABLE conference_lecturer');
        $this->addSql('DROP TABLE conference');
        $this->addSql('ALTER TABLE information CHANGE created_at created_at DATETIME DEFAULT \'2019-02-01 00:00:00\' NOT NULL, CHANGE updated_at updated_at DATETIME DEFAULT \'2019-02-01 00:00:00\' NOT NULL');
    }
}
