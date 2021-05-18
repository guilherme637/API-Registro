<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210413222136 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE conta (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, grupo_id INTEGER NOT NULL, financa_id INTEGER DEFAULT NULL, nome VARCHAR(100) NOT NULL, valor DOUBLE PRECISION NOT NULL, data DATE NOT NULL, data_feed_back VARCHAR(255) DEFAULT NULL)');
        $this->addSql('CREATE INDEX IDX_485A16C39C833003 ON conta (grupo_id)');
        $this->addSql('CREATE INDEX IDX_485A16C3D1E53195 ON conta (financa_id)');
        $this->addSql('CREATE TABLE financa (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, saldo DOUBLE PRECISION NOT NULL, data DATE DEFAULT NULL, dispesa DOUBLE PRECISION DEFAULT NULL)');
        $this->addSql('CREATE TABLE grupo (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, tipo VARCHAR(50) NOT NULL)');
        $this->addSql('CREATE TABLE user (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, username VARCHAR(120) NOT NULL, roles CLOB NOT NULL --(DC2Type:json_array)
        , password VARCHAR(255) NOT NULL)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649F85E0677 ON user (username)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE conta');
        $this->addSql('DROP TABLE financa');
        $this->addSql('DROP TABLE grupo');
        $this->addSql('DROP TABLE user');
    }
}
