<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210117093638 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE bitbag_mollie_configuration DROP FOREIGN KEY FK_23CC85048298F');
        $this->addSql('DROP INDEX UNIQ_23CC85048298F ON bitbag_mollie_configuration');
        $this->addSql('ALTER TABLE bitbag_mollie_configuration CHANGE default_category defaultCategory_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE bitbag_mollie_configuration ADD CONSTRAINT FK_23CC8504BFB2B62E FOREIGN KEY (defaultCategory_id) REFERENCES bitbag_mollie_product_type (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_23CC8504BFB2B62E ON bitbag_mollie_configuration (defaultCategory_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE bitbag_mollie_configuration DROP FOREIGN KEY FK_23CC8504BFB2B62E');
        $this->addSql('DROP INDEX UNIQ_23CC8504BFB2B62E ON bitbag_mollie_configuration');
        $this->addSql('ALTER TABLE bitbag_mollie_configuration CHANGE defaultcategory_id default_category INT DEFAULT NULL');
        $this->addSql('ALTER TABLE bitbag_mollie_configuration ADD CONSTRAINT FK_23CC85048298F FOREIGN KEY (default_category) REFERENCES bitbag_mollie_product_type (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_23CC85048298F ON bitbag_mollie_configuration (default_category)');
    }
}
