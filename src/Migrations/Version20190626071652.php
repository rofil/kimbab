<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190626071652 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE community_service_partner (id INT AUTO_INCREMENT NOT NULL, community_service_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, business_entity VARCHAR(255) NOT NULL, increase_in_profit DOUBLE PRECISION DEFAULT NULL, funding_provision DOUBLE PRECISION DEFAULT NULL, INDEX IDX_4E4C975ADC97DFFA (community_service_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE community_service (id INT AUTO_INCREMENT NOT NULL, year_id INT DEFAULT NULL, uploader_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, duration INT NOT NULL, level INT NOT NULL, funding_source VARCHAR(255) NOT NULL, funding DOUBLE PRECISION NOT NULL, number_of_students INT NOT NULL, number_of_alumni DOUBLE PRECISION NOT NULL, number_of_staff DOUBLE PRECISION NOT NULL, document VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_C558F38140C1FEA7 (year_id), INDEX IDX_C558F38116678C77 (uploader_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE community_service_lecturer (id INT AUTO_INCREMENT NOT NULL, lecturer_id INT DEFAULT NULL, community_service_id INT DEFAULT NULL, order_number INT DEFAULT NULL, INDEX IDX_6BDA3B54BA2D8762 (lecturer_id), INDEX IDX_6BDA3B54DC97DFFA (community_service_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE community_service_partner ADD CONSTRAINT FK_4E4C975ADC97DFFA FOREIGN KEY (community_service_id) REFERENCES community_service (id)');
        $this->addSql('ALTER TABLE community_service ADD CONSTRAINT FK_C558F38140C1FEA7 FOREIGN KEY (year_id) REFERENCES year (id)');
        $this->addSql('ALTER TABLE community_service ADD CONSTRAINT FK_C558F38116678C77 FOREIGN KEY (uploader_id) REFERENCES lecturer (id)');
        $this->addSql('ALTER TABLE community_service_lecturer ADD CONSTRAINT FK_6BDA3B54BA2D8762 FOREIGN KEY (lecturer_id) REFERENCES lecturer (id)');
        $this->addSql('ALTER TABLE community_service_lecturer ADD CONSTRAINT FK_6BDA3B54DC97DFFA FOREIGN KEY (community_service_id) REFERENCES community_service (id)');
        $this->addSql('ALTER TABLE information CHANGE created_at created_at DATETIME DEFAULT \'2019-02-01\' NOT NULL, CHANGE updated_at updated_at DATETIME DEFAULT \'2019-02-01\' NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE community_service_partner DROP FOREIGN KEY FK_4E4C975ADC97DFFA');
        $this->addSql('ALTER TABLE community_service_lecturer DROP FOREIGN KEY FK_6BDA3B54DC97DFFA');
        $this->addSql('DROP TABLE community_service_partner');
        $this->addSql('DROP TABLE community_service');
        $this->addSql('DROP TABLE community_service_lecturer');
        $this->addSql('ALTER TABLE information CHANGE created_at created_at DATETIME DEFAULT \'2019-02-01 00:00:00\' NOT NULL, CHANGE updated_at updated_at DATETIME DEFAULT \'2019-02-01 00:00:00\' NOT NULL');
    }
}
