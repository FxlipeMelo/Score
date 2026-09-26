<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260926120815 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE registration (id INT AUTO_INCREMENT NOT NULL, pay_date DATETIME DEFAULT NULL, status VARCHAR(255) NOT NULL, team_id INT DEFAULT NULL, championship_id INT DEFAULT NULL, INDEX IDX_62A8A7A7296CD8AE (team_id), INDEX IDX_62A8A7A794DDBCE9 (championship_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE registration ADD CONSTRAINT FK_62A8A7A7296CD8AE FOREIGN KEY (team_id) REFERENCES team (id)');
        $this->addSql('ALTER TABLE registration ADD CONSTRAINT FK_62A8A7A794DDBCE9 FOREIGN KEY (championship_id) REFERENCES championship (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE registration DROP FOREIGN KEY FK_62A8A7A7296CD8AE');
        $this->addSql('ALTER TABLE registration DROP FOREIGN KEY FK_62A8A7A794DDBCE9');
        $this->addSql('DROP TABLE registration');
    }
}
