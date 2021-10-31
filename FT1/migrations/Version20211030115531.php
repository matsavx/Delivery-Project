<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211030115531 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE delivery_drink (id INT AUTO_INCREMENT NOT NULL, drink_name VARCHAR(255) NOT NULL, drink_price INT NOT NULL, drink_composition VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE delivery_kit (id INT AUTO_INCREMENT NOT NULL, delivery_pizza_in_kit_id INT DEFAULT NULL, delivery_drink_in_kit_id INT DEFAULT NULL, delivery_roll_in_kit_id INT DEFAULT NULL, session_id VARCHAR(255) DEFAULT NULL, INDEX IDX_7F3BF3BCB921B361 (delivery_pizza_in_kit_id), INDEX IDX_7F3BF3BCBAC90ADF (delivery_drink_in_kit_id), INDEX IDX_7F3BF3BC7CD34AC (delivery_roll_in_kit_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE delivery_order (id INT AUTO_INCREMENT NOT NULL, order_kit_id INT DEFAULT NULL, order_address VARCHAR(255) DEFAULT NULL, order_session_id VARCHAR(255) DEFAULT NULL, INDEX IDX_E522750AF901703A (order_kit_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE delivery_pizza (id INT AUTO_INCREMENT NOT NULL, pizza_name VARCHAR(255) NOT NULL, pizza_price INT NOT NULL, pizza_composition VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE delivery_roll (id INT AUTO_INCREMENT NOT NULL, roll_name VARCHAR(255) NOT NULL, roll_price INT NOT NULL, roll_composition VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE delivery_kit ADD CONSTRAINT FK_7F3BF3BCB921B361 FOREIGN KEY (delivery_pizza_in_kit_id) REFERENCES delivery_pizza (id)');
        $this->addSql('ALTER TABLE delivery_kit ADD CONSTRAINT FK_7F3BF3BCBAC90ADF FOREIGN KEY (delivery_drink_in_kit_id) REFERENCES delivery_drink (id)');
        $this->addSql('ALTER TABLE delivery_kit ADD CONSTRAINT FK_7F3BF3BC7CD34AC FOREIGN KEY (delivery_roll_in_kit_id) REFERENCES delivery_roll (id)');
        $this->addSql('ALTER TABLE delivery_order ADD CONSTRAINT FK_E522750AF901703A FOREIGN KEY (order_kit_id) REFERENCES delivery_kit (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE delivery_kit DROP FOREIGN KEY FK_7F3BF3BCBAC90ADF');
        $this->addSql('ALTER TABLE delivery_order DROP FOREIGN KEY FK_E522750AF901703A');
        $this->addSql('ALTER TABLE delivery_kit DROP FOREIGN KEY FK_7F3BF3BCB921B361');
        $this->addSql('ALTER TABLE delivery_kit DROP FOREIGN KEY FK_7F3BF3BC7CD34AC');
        $this->addSql('DROP TABLE delivery_drink');
        $this->addSql('DROP TABLE delivery_kit');
        $this->addSql('DROP TABLE delivery_order');
        $this->addSql('DROP TABLE delivery_pizza');
        $this->addSql('DROP TABLE delivery_roll');
    }
}
