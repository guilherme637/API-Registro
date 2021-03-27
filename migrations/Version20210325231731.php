<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210325231731 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE user (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, username VARCHAR(180) NOT NULL, roles CLOB NOT NULL --(DC2Type:json)
        , password VARCHAR(255) NOT NULL)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649F85E0677 ON user (username)');
        $this->addSql('DROP INDEX IDX_485A16C39C833003');
        $this->addSql('CREATE TEMPORARY TABLE __temp__conta AS SELECT id, grupo_id, nome, valor, data FROM conta');
        $this->addSql('DROP TABLE conta');
        $this->addSql('CREATE TABLE conta (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, grupo_id INTEGER NOT NULL, nome VARCHAR(120) NOT NULL COLLATE BINARY, valor DOUBLE PRECISION NOT NULL, data DATE NOT NULL, CONSTRAINT FK_485A16C39C833003 FOREIGN KEY (grupo_id) REFERENCES grupo (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO conta (id, grupo_id, nome, valor, data) SELECT id, grupo_id, nome, valor, data FROM __temp__conta');
        $this->addSql('DROP TABLE __temp__conta');
        $this->addSql('CREATE INDEX IDX_485A16C39C833003 ON conta (grupo_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP INDEX IDX_485A16C39C833003');
        $this->addSql('CREATE TEMPORARY TABLE __temp__conta AS SELECT id, grupo_id, nome, valor, data FROM conta');
        $this->addSql('DROP TABLE conta');
        $this->addSql('CREATE TABLE conta (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, grupo_id INTEGER NOT NULL, nome VARCHAR(120) NOT NULL, valor DOUBLE PRECISION NOT NULL, data DATE NOT NULL)');
        $this->addSql('INSERT INTO conta (id, grupo_id, nome, valor, data) SELECT id, grupo_id, nome, valor, data FROM __temp__conta');
        $this->addSql('DROP TABLE __temp__conta');
        $this->addSql('CREATE INDEX IDX_485A16C39C833003 ON conta (grupo_id)');
    }
}
