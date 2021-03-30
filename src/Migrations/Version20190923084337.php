<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190923084337 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE research (id INT AUTO_INCREMENT NOT NULL, year_id INT NOT NULL, uploader_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, funding_source VARCHAR(255) NOT NULL, funding DOUBLE PRECISION NOT NULL, document VARCHAR(255) DEFAULT NULL, INDEX IDX_57EB50C240C1FEA7 (year_id), INDEX IDX_57EB50C216678C77 (uploader_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE research_lecturer (research_id INT NOT NULL, lecturer_id INT NOT NULL, INDEX IDX_E934068C7909E1ED (research_id), INDEX IDX_E934068CBA2D8762 (lecturer_id), PRIMARY KEY(research_id, lecturer_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE research ADD CONSTRAINT FK_57EB50C240C1FEA7 FOREIGN KEY (year_id) REFERENCES year (id)');
        $this->addSql('ALTER TABLE research ADD CONSTRAINT FK_57EB50C216678C77 FOREIGN KEY (uploader_id) REFERENCES lecturer (id)');
        $this->addSql('ALTER TABLE research_lecturer ADD CONSTRAINT FK_E934068C7909E1ED FOREIGN KEY (research_id) REFERENCES research (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE research_lecturer ADD CONSTRAINT FK_E934068CBA2D8762 FOREIGN KEY (lecturer_id) REFERENCES lecturer (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE information CHANGE created_at created_at DATETIME DEFAULT \'2019-02-01\' NOT NULL, CHANGE updated_at updated_at DATETIME DEFAULT \'2019-02-01\' NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE research_lecturer DROP FOREIGN KEY FK_E934068C7909E1ED');
        $this->addSql('DROP TABLE research');
        $this->addSql('DROP TABLE research_lecturer');
        $this->addSql('ALTER TABLE information CHANGE created_at created_at DATETIME DEFAULT \'2019-02-01 00:00:00\' NOT NULL, CHANGE updated_at updated_at DATETIME DEFAULT \'2019-02-01 00:00:00\' NOT NULL');
    }
}
