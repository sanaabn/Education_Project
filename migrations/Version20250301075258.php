<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250301075258 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE emploi DROP FOREIGN KEY FK_74A0B0FADC304035');
        $this->addSql('DROP INDEX IDX_74A0B0FADC304035 ON emploi');
        $this->addSql('ALTER TABLE emploi CHANGE salles_id salle_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE emploi ADD CONSTRAINT FK_74A0B0FADC304035 FOREIGN KEY (salle_id) REFERENCES salles (id)');
        $this->addSql('CREATE INDEX IDX_74A0B0FADC304035 ON emploi (salle_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE emploi DROP FOREIGN KEY FK_74A0B0FADC304035');
        $this->addSql('DROP INDEX IDX_74A0B0FADC304035 ON emploi');
        $this->addSql('ALTER TABLE emploi CHANGE salle_id salles_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE emploi ADD CONSTRAINT FK_74A0B0FADC304035 FOREIGN KEY (salles_id) REFERENCES salles (id)');
        $this->addSql('CREATE INDEX IDX_74A0B0FADC304035 ON emploi (salles_id)');
    }
}
