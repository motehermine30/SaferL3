<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230108072622 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE bien ADD created_at DATETIME NOT NULL, CHANGE numero numero INT NOT NULL, CHANGE surface surface INT NOT NULL, CHANGE prix_mensuel prix_mensuel INT NOT NULL, CHANGE prix_final prix_final INT NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE bien DROP created_at, CHANGE numero numero VARCHAR(255) NOT NULL, CHANGE surface surface VARCHAR(255) NOT NULL, CHANGE prix_mensuel prix_mensuel VARCHAR(255) NOT NULL, CHANGE prix_final prix_final VARCHAR(255) NOT NULL');
    }
}
