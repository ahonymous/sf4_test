<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190630210132 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf('mysql' !== $this->connection->getDatabasePlatform()->getName(), 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE statistic (id INT AUTO_INCREMENT NOT NULL, currency_from_id INT DEFAULT NULL, currency_to_id INT DEFAULT NULL, time DATETIME NOT NULL, average NUMERIC(10, 2) NOT NULL, INDEX IDX_649B469CA56723E4 (currency_from_id), INDEX IDX_649B469C67D74803 (currency_to_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE currency (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, code VARCHAR(3) NOT NULL, UNIQUE INDEX UNIQ_6956883F77153098 (code), INDEX currency_code (code), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE statistic ADD CONSTRAINT FK_649B469CA56723E4 FOREIGN KEY (currency_from_id) REFERENCES currency (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE statistic ADD CONSTRAINT FK_649B469C67D74803 FOREIGN KEY (currency_to_id) REFERENCES currency (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf('mysql' !== $this->connection->getDatabasePlatform()->getName(), 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE statistic DROP FOREIGN KEY FK_649B469CA56723E4');
        $this->addSql('ALTER TABLE statistic DROP FOREIGN KEY FK_649B469C67D74803');
        $this->addSql('DROP TABLE statistic');
        $this->addSql('DROP TABLE currency');
    }
}
