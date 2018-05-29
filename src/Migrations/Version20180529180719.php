<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180529180719 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('DROP INDEX IDX_54F1F40BC7209D4F');
        $this->addSql('DROP INDEX IDX_54F1F40BA76ED395');
        $this->addSql('DROP INDEX IDX_54F1F40B9458D7F4');
        $this->addSql('CREATE TEMPORARY TABLE __temp__advert AS SELECT id, adv_category_id, user_id, region_id_id, adv_title, adv_description, price, image_name, image_size FROM advert');
        $this->addSql('DROP TABLE advert');
        $this->addSql('CREATE TABLE advert (id INTEGER NOT NULL, adv_category_id INTEGER NOT NULL, user_id INTEGER NOT NULL, region_id_id INTEGER DEFAULT NULL, adv_title VARCHAR(255) NOT NULL COLLATE BINARY, adv_description CLOB DEFAULT NULL COLLATE BINARY, price NUMERIC(10, 2) DEFAULT NULL, image_name VARCHAR(255) DEFAULT NULL COLLATE BINARY, image_size INTEGER DEFAULT NULL, is_active BOOLEAN NOT NULL, publish_date DATETIME DEFAULT NULL, PRIMARY KEY(id), CONSTRAINT FK_54F1F40B9458D7F4 FOREIGN KEY (adv_category_id) REFERENCES category_entity (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_54F1F40BA76ED395 FOREIGN KEY (user_id) REFERENCES fos_user (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_54F1F40BC7209D4F FOREIGN KEY (region_id_id) REFERENCES region_entity (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO advert (id, adv_category_id, user_id, region_id_id, adv_title, adv_description, price, image_name, image_size) SELECT id, adv_category_id, user_id, region_id_id, adv_title, adv_description, price, image_name, image_size FROM __temp__advert');
        $this->addSql('DROP TABLE __temp__advert');
        $this->addSql('CREATE INDEX IDX_54F1F40BC7209D4F ON advert (region_id_id)');
        $this->addSql('CREATE INDEX IDX_54F1F40BA76ED395 ON advert (user_id)');
        $this->addSql('CREATE INDEX IDX_54F1F40B9458D7F4 ON advert (adv_category_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('DROP INDEX IDX_54F1F40B9458D7F4');
        $this->addSql('DROP INDEX IDX_54F1F40BA76ED395');
        $this->addSql('DROP INDEX IDX_54F1F40BC7209D4F');
        $this->addSql('CREATE TEMPORARY TABLE __temp__advert AS SELECT id, adv_category_id, user_id, region_id_id, adv_title, adv_description, price, image_name, image_size FROM advert');
        $this->addSql('DROP TABLE advert');
        $this->addSql('CREATE TABLE advert (id INTEGER NOT NULL, adv_category_id INTEGER NOT NULL, user_id INTEGER NOT NULL, region_id_id INTEGER DEFAULT NULL, adv_title VARCHAR(255) NOT NULL, adv_description CLOB DEFAULT NULL, price NUMERIC(10, 2) DEFAULT NULL, image_name VARCHAR(255) DEFAULT NULL, image_size INTEGER DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('INSERT INTO advert (id, adv_category_id, user_id, region_id_id, adv_title, adv_description, price, image_name, image_size) SELECT id, adv_category_id, user_id, region_id_id, adv_title, adv_description, price, image_name, image_size FROM __temp__advert');
        $this->addSql('DROP TABLE __temp__advert');
        $this->addSql('CREATE INDEX IDX_54F1F40B9458D7F4 ON advert (adv_category_id)');
        $this->addSql('CREATE INDEX IDX_54F1F40BA76ED395 ON advert (user_id)');
        $this->addSql('CREATE INDEX IDX_54F1F40BC7209D4F ON advert (region_id_id)');
    }
}
