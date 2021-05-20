<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210509160611 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE communaute (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, univers_id INT NOT NULL, createur_id INT NOT NULL, reglement LONGTEXT NOT NULL, date_creation DATETIME NOT NULL, description LONGTEXT NOT NULL, etat VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE perso_dispo (id INT AUTO_INCREMENT NOT NULL, univers_id INT NOT NULL, personnage_id INT NOT NULL, communaute_id INT NOT NULL, roliste_id INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE personnage (id INT AUTO_INCREMENT NOT NULL, univer_id INT NOT NULL, lien_ref VARCHAR(255) NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE roliste (id INT AUTO_INCREMENT NOT NULL, personnage_id INT NOT NULL, communaute_id INT NOT NULL, user_id INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sites (id INT AUTO_INCREMENT NOT NULL, univers_id INT NOT NULL, type VARCHAR(255) NOT NULL, site VARCHAR(255) NOT NULL, user_id INT NOT NULL, description LONGTEXT NOT NULL, histoire LONGTEXT NOT NULL, etat VARCHAR(255) NOT NULL, date_creation DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE univers (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, photo_couverture VARCHAR(255) NOT NULL, lien_ref VARCHAR(255) NOT NULL, createur_id INT NOT NULL, date_creation DATETIME NOT NULL, etat VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `user` (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, genre VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, date_naissance VARCHAR(255) NOT NULL, pdp VARCHAR(255) NOT NULL, date_inscription DATETIME NOT NULL, etat VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649F85E0677 (username), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE communaute');
        $this->addSql('DROP TABLE perso_dispo');
        $this->addSql('DROP TABLE personnage');
        $this->addSql('DROP TABLE roliste');
        $this->addSql('DROP TABLE sites');
        $this->addSql('DROP TABLE univers');
        $this->addSql('DROP TABLE `user`');
    }
}
