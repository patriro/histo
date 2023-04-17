<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230414153217 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE address_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE company_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE address (id INT NOT NULL, company_id INT NOT NULL, number VARCHAR(10) NOT NULL, road_type VARCHAR(255) NOT NULL, road_name VARCHAR(255) NOT NULL, city VARCHAR(255) NOT NULL, post_code INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_D4E6F816AE4741E ON address (company_id)');
        $this->addSql('CREATE TABLE company (id INT NOT NULL, legal_status_id INT NOT NULL, name VARCHAR(255) NOT NULL, siren VARCHAR(255) NOT NULL, registration_date DATE NOT NULL, capital INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_4FBF094F873E3FEC ON company (legal_status_id)');
        $this->addSql('ALTER TABLE address ADD CONSTRAINT FK_D4E6F816AE4741E FOREIGN KEY (company_id) REFERENCES company (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE company ADD CONSTRAINT FK_4FBF094F873E3FEC FOREIGN KEY (legal_status_id) REFERENCES legal_status (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE address_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE company_id_seq CASCADE');
        $this->addSql('ALTER TABLE address DROP CONSTRAINT FK_D4E6F816AE4741E');
        $this->addSql('ALTER TABLE company DROP CONSTRAINT FK_4FBF094F873E3FEC');
        $this->addSql('DROP TABLE address');
        $this->addSql('DROP TABLE company');
    }
}
