<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260918153118 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE championship (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, date_start DATETIME NOT NULL, date_end DATETIME NOT NULL, status VARCHAR(255) NOT NULL, sport_id INT NOT NULL, INDEX IDX_EBADDE6AAC78BCF8 (sport_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE player (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, birth_date DATE NOT NULL, height DOUBLE PRECISION NOT NULL, cpf VARCHAR(14) NOT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE sport (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, max_player_per_team INT NOT NULL, match_type VARCHAR(255) NOT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE team (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, date_created DATE NOT NULL, sport_id INT NOT NULL, INDEX IDX_C4E0A61FAC78BCF8 (sport_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE team_roster (id INT AUTO_INCREMENT NOT NULL, shirt_number INT NOT NULL, entry_date DATE NOT NULL, team_id INT DEFAULT NULL, player_id INT DEFAULT NULL, INDEX IDX_16A2EA20296CD8AE (team_id), INDEX IDX_16A2EA2099E6F5DF (player_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE championship ADD CONSTRAINT FK_EBADDE6AAC78BCF8 FOREIGN KEY (sport_id) REFERENCES sport (id)');
        $this->addSql('ALTER TABLE team ADD CONSTRAINT FK_C4E0A61FAC78BCF8 FOREIGN KEY (sport_id) REFERENCES sport (id)');
        $this->addSql('ALTER TABLE team_roster ADD CONSTRAINT FK_16A2EA20296CD8AE FOREIGN KEY (team_id) REFERENCES team (id)');
        $this->addSql('ALTER TABLE team_roster ADD CONSTRAINT FK_16A2EA2099E6F5DF FOREIGN KEY (player_id) REFERENCES player (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE championship DROP FOREIGN KEY FK_EBADDE6AAC78BCF8');
        $this->addSql('ALTER TABLE team DROP FOREIGN KEY FK_C4E0A61FAC78BCF8');
        $this->addSql('ALTER TABLE team_roster DROP FOREIGN KEY FK_16A2EA20296CD8AE');
        $this->addSql('ALTER TABLE team_roster DROP FOREIGN KEY FK_16A2EA2099E6F5DF');
        $this->addSql('DROP TABLE championship');
        $this->addSql('DROP TABLE player');
        $this->addSql('DROP TABLE sport');
        $this->addSql('DROP TABLE team');
        $this->addSql('DROP TABLE team_roster');
    }
}
