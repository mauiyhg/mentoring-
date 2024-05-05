<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240425182205 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE mentoroffers DROP FOREIGN KEY FK_9772E17887B967E8');
        $this->addSql('DROP INDEX IDX_9772E17887B967E8 ON mentoroffers');
        $this->addSql('ALTER TABLE mentoroffers CHANGE Mentor mentor VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE mentoroffers CHANGE mentor Mentor INT DEFAULT NULL');
        $this->addSql('ALTER TABLE mentoroffers ADD CONSTRAINT FK_9772E17887B967E8 FOREIGN KEY (Mentor) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_9772E17887B967E8 ON mentoroffers (Mentor)');
    }
}
