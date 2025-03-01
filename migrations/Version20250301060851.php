<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250301060851 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE student (id INT AUTO_INCREMENT NOT NULL, assignment_id INT NOT NULL, student_id INT NOT NULL, score DOUBLE PRECISION DEFAULT NULL, INDEX IDX_B723AF33D19302F8 (assignment_id), INDEX IDX_B723AF33CB944F1A (student_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE student ADD CONSTRAINT FK_B723AF33D19302F8 FOREIGN KEY (assignment_id) REFERENCES assignment (id)');
        $this->addSql('ALTER TABLE student ADD CONSTRAINT FK_B723AF33CB944F1A FOREIGN KEY (student_id) REFERENCES student (id)');
        $this->addSql('ALTER TABLE assignment CHANGE due_date due_date DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE grade ADD student_id INT NOT NULL');
        $this->addSql('ALTER TABLE grade ADD CONSTRAINT FK_595AAE34CB944F1A FOREIGN KEY (student_id) REFERENCES student (id)');
        $this->addSql('CREATE INDEX IDX_595AAE34CB944F1A ON grade (student_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE grade DROP FOREIGN KEY FK_595AAE34CB944F1A');
        $this->addSql('ALTER TABLE student DROP FOREIGN KEY FK_B723AF33D19302F8');
        $this->addSql('ALTER TABLE student DROP FOREIGN KEY FK_B723AF33CB944F1A');
        $this->addSql('DROP TABLE student');
        $this->addSql('ALTER TABLE assignment CHANGE due_date due_date DATE DEFAULT NULL');
        $this->addSql('DROP INDEX IDX_595AAE34CB944F1A ON grade');
        $this->addSql('ALTER TABLE grade DROP student_id');
    }
}
