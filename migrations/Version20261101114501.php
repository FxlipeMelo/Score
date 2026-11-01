<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20261101114501 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE game (id INT AUTO_INCREMENT NOT NULL, date_game DATETIME NOT NULL, home_registration_id INT DEFAULT NULL, away_registration_id INT DEFAULT NULL, INDEX IDX_232B318C146F2E13 (home_registration_id), INDEX IDX_232B318C68806D4E (away_registration_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE game ADD CONSTRAINT FK_232B318C146F2E13 FOREIGN KEY (home_registration_id) REFERENCES registration (id)');
        $this->addSql('ALTER TABLE game ADD CONSTRAINT FK_232B318C68806D4E FOREIGN KEY (away_registration_id) REFERENCES registration (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE game DROP FOREIGN KEY FK_232B318C146F2E13');
        $this->addSql('ALTER TABLE game DROP FOREIGN KEY FK_232B318C68806D4E');
        $this->addSql('DROP TABLE game');
    }
}
