<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210124154502 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE shopuser_course (shopuser_id INT NOT NULL, course_id INT NOT NULL, INDEX IDX_6AF469DADBFF1294 (shopuser_id), INDEX IDX_6AF469DA591CC992 (course_id), PRIMARY KEY(shopuser_id, course_id)) DEFAULT CHARACTER SET UTF8 COLLATE `UTF8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE shopuser_course ADD CONSTRAINT FK_6AF469DADBFF1294 FOREIGN KEY (shopuser_id) REFERENCES sylius_shop_user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE shopuser_course ADD CONSTRAINT FK_6AF469DA591CC992 FOREIGN KEY (course_id) REFERENCES sylius_course (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE shopuser_course');
    }
}
