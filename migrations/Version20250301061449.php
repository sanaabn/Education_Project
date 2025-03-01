<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250301061449 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE grade DROP FOREIGN KEY FK_595AAE34D19302F8');
        $this->addSql('ALTER TABLE grade CHANGE score score DOUBLE PRECISION NOT NULL');
        $this->addSql('ALTER TABLE grade ADD CONSTRAINT FK_595AAE34CB944F1A FOREIGN KEY (student_id) REFERENCES student (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE grade ADD CONSTRAINT FK_595AAE34D19302F8 FOREIGN KEY (assignment_id) REFERENCES assignment (id) ON DELETE CASCADE');
        $this->addSql('CREATE INDEX IDX_595AAE34CB944F1A ON grade (student_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE grade DROP FOREIGN KEY FK_595AAE34CB944F1A');
        $this->addSql('ALTER TABLE grade DROP FOREIGN KEY FK_595AAE34D19302F8');
        $this->addSql('DROP INDEX IDX_595AAE34CB944F1A ON grade');
        $this->addSql('ALTER TABLE grade CHANGE score score DOUBLE PRECISION DEFAULT NULL');
        $this->addSql('ALTER TABLE grade ADD CONSTRAINT FK_595AAE34D19302F8 FOREIGN KEY (assignment_id) REFERENCES assignment (id)');
    }
}
