<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220614190836 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE application_compatibles (application_id INT NOT NULL, application_compatible_id INT NOT NULL, INDEX IDX_2DE6B3B3E030ACD (application_id), INDEX IDX_2DE6B3B68BC8DE2 (application_compatible_id), PRIMARY KEY(application_id, application_compatible_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE application_compatible (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE developer (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, url VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE application_compatibles ADD CONSTRAINT FK_2DE6B3B3E030ACD FOREIGN KEY (application_id) REFERENCES application (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE application_compatibles ADD CONSTRAINT FK_2DE6B3B68BC8DE2 FOREIGN KEY (application_compatible_id) REFERENCES application_compatible (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE application ADD developer_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE application ADD CONSTRAINT FK_A45BDDC164DD9267 FOREIGN KEY (developer_id) REFERENCES developer (id)');
        $this->addSql('CREATE INDEX IDX_A45BDDC164DD9267 ON application (developer_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE application_compatibles DROP FOREIGN KEY FK_2DE6B3B68BC8DE2');
        $this->addSql('ALTER TABLE application DROP FOREIGN KEY FK_A45BDDC164DD9267');
        $this->addSql('DROP TABLE application_compatibles');
        $this->addSql('DROP TABLE application_compatible');
        $this->addSql('DROP TABLE developer');
        $this->addSql('DROP INDEX IDX_A45BDDC164DD9267 ON application');
        $this->addSql('ALTER TABLE application DROP developer_id');
    }
}
