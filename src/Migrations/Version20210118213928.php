<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210118213928 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE productvariant_course (productvariant_id INT NOT NULL, course_id INT NOT NULL, INDEX IDX_767994B31855BE3F (productvariant_id), INDEX IDX_767994B3591CC992 (course_id), PRIMARY KEY(productvariant_id, course_id)) DEFAULT CHARACTER SET UTF8 COLLATE `UTF8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE productvariant_course ADD CONSTRAINT FK_767994B31855BE3F FOREIGN KEY (productvariant_id) REFERENCES sylius_product_variant (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE productvariant_course ADD CONSTRAINT FK_767994B3591CC992 FOREIGN KEY (course_id) REFERENCES sylius_course (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE productvariant_course');
    }
}
