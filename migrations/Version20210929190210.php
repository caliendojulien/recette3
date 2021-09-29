<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210929190210 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE recette (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, ingredient1 VARCHAR(255) NOT NULL, ingredient2 VARCHAR(255) DEFAULT NULL, ingredient3 VARCHAR(255) DEFAULT NULL, quantite1 VARCHAR(255) NOT NULL, quantite2 VARCHAR(255) DEFAULT NULL, quantite3 VARCHAR(255) DEFAULT NULL, description CLOB NOT NULL, est_favori BOOLEAN NOT NULL)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE recette');
    }
}
