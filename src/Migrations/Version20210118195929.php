<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210118195929 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE sylius_course_page_translation ADD translatable_id INT NOT NULL, ADD content LONGTEXT NOT NULL, ADD locale VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE sylius_course_page_translation ADD CONSTRAINT FK_6050E0B62C2AC5D3 FOREIGN KEY (translatable_id) REFERENCES sylius_course_page (id) ON DELETE CASCADE');
        $this->addSql('CREATE INDEX IDX_6050E0B62C2AC5D3 ON sylius_course_page_translation (translatable_id)');
        $this->addSql('CREATE UNIQUE INDEX sylius_course_page_translation_uniq_trans ON sylius_course_page_translation (translatable_id, locale)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE sylius_course_page_translation DROP FOREIGN KEY FK_6050E0B62C2AC5D3');
        $this->addSql('DROP INDEX IDX_6050E0B62C2AC5D3 ON sylius_course_page_translation');
        $this->addSql('DROP INDEX sylius_course_page_translation_uniq_trans ON sylius_course_page_translation');
        $this->addSql('ALTER TABLE sylius_course_page_translation DROP translatable_id, DROP content, DROP locale');
    }
}
