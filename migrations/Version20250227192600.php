<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250227192600 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE inscription DROP INDEX IDX_5E90F6D6FB88E14F, ADD UNIQUE INDEX UNIQ_5E90F6D6FB88E14F (utilisateur_id)');
        $this->addSql('ALTER TABLE utilisateur DROP FOREIGN KEY FK_1D1C63B35DAC5993');
        $this->addSql('DROP INDEX UNIQ_1D1C63B35DAC5993 ON utilisateur');
        $this->addSql('ALTER TABLE utilisateur DROP inscription_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE inscription DROP INDEX UNIQ_5E90F6D6FB88E14F, ADD INDEX IDX_5E90F6D6FB88E14F (utilisateur_id)');
        $this->addSql('ALTER TABLE utilisateur ADD inscription_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE utilisateur ADD CONSTRAINT FK_1D1C63B35DAC5993 FOREIGN KEY (inscription_id) REFERENCES utilisateur (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1D1C63B35DAC5993 ON utilisateur (inscription_id)');
    }
}
