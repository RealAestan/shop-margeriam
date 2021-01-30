<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210120205530 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE sylius_course_translation (id INT AUTO_INCREMENT NOT NULL, translatable_id INT NOT NULL, name VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, locale VARCHAR(255) NOT NULL, INDEX IDX_EF437C2D2C2AC5D3 (translatable_id), UNIQUE INDEX sylius_course_translation_uniq_trans (translatable_id, locale), PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8 COLLATE `UTF8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE sylius_course_translation ADD CONSTRAINT FK_EF437C2D2C2AC5D3 FOREIGN KEY (translatable_id) REFERENCES sylius_course (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE sylius_course_page ADD course_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE sylius_course_page ADD CONSTRAINT FK_7BEA12DF591CC992 FOREIGN KEY (course_id) REFERENCES sylius_course (id) ON DELETE SET NULL');
        $this->addSql('CREATE INDEX IDX_7BEA12DF591CC992 ON sylius_course_page (course_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE sylius_course_translation');
        $this->addSql('ALTER TABLE sylius_course_page DROP FOREIGN KEY FK_7BEA12DF591CC992');
        $this->addSql('DROP INDEX IDX_7BEA12DF591CC992 ON sylius_course_page');
        $this->addSql('ALTER TABLE sylius_course_page DROP course_id');
    }
}
