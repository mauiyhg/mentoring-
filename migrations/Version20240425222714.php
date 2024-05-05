<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240425222714 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE commentaires (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, titre VARCHAR(255) NOT NULL, commentaire LONGTEXT NOT NULL, note INT NOT NULL, INDEX IDX_D9BEC0C4A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE commentaires ADD CONSTRAINT FK_D9BEC0C4A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE mentoroffers CHANGE title title VARCHAR(255) NOT NULL, CHANGE description description VARCHAR(255) NOT NULL, CHANGE duration duration INT NOT NULL, CHANGE price price DOUBLE PRECISION NOT NULL, CHANGE mentor mentor VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE commentaires DROP FOREIGN KEY FK_D9BEC0C4A76ED395');
        $this->addSql('DROP TABLE commentaires');
        $this->addSql('ALTER TABLE mentoroffers CHANGE title title VARCHAR(255) DEFAULT NULL, CHANGE description description VARCHAR(255) DEFAULT NULL, CHANGE duration duration INT DEFAULT NULL, CHANGE mentor mentor VARCHAR(255) DEFAULT NULL, CHANGE price price DOUBLE PRECISION DEFAULT NULL');
    }
}
