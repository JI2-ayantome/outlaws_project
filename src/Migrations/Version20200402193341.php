<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200402193341 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA metier');
        $this->addSql('CREATE SEQUENCE metier.piece_identification_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE metier.nationalite_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE metier.authorite_delivrance_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE metier.mandat_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE metier.type_mandat_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE metier.nationalite_fugitif_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE metier.nature_piece_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE metier.user_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE metier.fugitif_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE metier.piece_identification (id INT NOT NULL, nature_id INT NOT NULL, authorite_id INT NOT NULL, fugitif_id INT NOT NULL, created_by_id INT DEFAULT NULL, updated_by_id INT DEFAULT NULL, libelle VARCHAR(255) NOT NULL, date_delivrance DATE NOT NULL, lieu_delivrance VARCHAR(255) NOT NULL, date_expiration DATE NOT NULL, created_at TIMESTAMP(0) WITH TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITH TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_2915CBED3BCB2E4B ON metier.piece_identification (nature_id)');
        $this->addSql('CREATE INDEX IDX_2915CBED9B236E7C ON metier.piece_identification (authorite_id)');
        $this->addSql('CREATE INDEX IDX_2915CBEDC29BD459 ON metier.piece_identification (fugitif_id)');
        $this->addSql('CREATE INDEX IDX_2915CBEDB03A8386 ON metier.piece_identification (created_by_id)');
        $this->addSql('CREATE INDEX IDX_2915CBED896DBBDE ON metier.piece_identification (updated_by_id)');
        $this->addSql('CREATE TABLE metier.nationalite (id INT NOT NULL, created_by_id INT DEFAULT NULL, updated_by_id INT DEFAULT NULL, libelle VARCHAR(255) NOT NULL, created_at TIMESTAMP(0) WITH TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITH TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_1DBE98D8B03A8386 ON metier.nationalite (created_by_id)');
        $this->addSql('CREATE INDEX IDX_1DBE98D8896DBBDE ON metier.nationalite (updated_by_id)');
        $this->addSql('CREATE TABLE metier.authorite_delivrance (id INT NOT NULL, created_by_id INT DEFAULT NULL, updated_by_id INT DEFAULT NULL, nom VARCHAR(255) NOT NULL, prenoms VARCHAR(255) NOT NULL, titre VARCHAR(255) NOT NULL, created_at TIMESTAMP(0) WITH TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITH TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_8B317D5AB03A8386 ON metier.authorite_delivrance (created_by_id)');
        $this->addSql('CREATE INDEX IDX_8B317D5A896DBBDE ON metier.authorite_delivrance (updated_by_id)');
        $this->addSql('CREATE TABLE metier.mandat (id INT NOT NULL, type_mandat_id INT NOT NULL, fugitif_id INT NOT NULL, created_by_id INT DEFAULT NULL, updated_by_id INT DEFAULT NULL, reference VARCHAR(255) DEFAULT NULL, execute BOOLEAN NOT NULL, infractions TEXT NOT NULL, chambres TEXT DEFAULT NULL, juridictions TEXT NOT NULL, date_emission DATE DEFAULT NULL, archived BOOLEAN DEFAULT \'false\' NOT NULL, created_at TIMESTAMP(0) WITH TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITH TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_5DC1B7C072419C88 ON metier.mandat (type_mandat_id)');
        $this->addSql('CREATE INDEX IDX_5DC1B7C0C29BD459 ON metier.mandat (fugitif_id)');
        $this->addSql('CREATE INDEX IDX_5DC1B7C0B03A8386 ON metier.mandat (created_by_id)');
        $this->addSql('CREATE INDEX IDX_5DC1B7C0896DBBDE ON metier.mandat (updated_by_id)');
        $this->addSql('CREATE TABLE metier.type_mandat (id INT NOT NULL, created_by_id INT DEFAULT NULL, updated_by_id INT DEFAULT NULL, libelle VARCHAR(255) NOT NULL, created_at TIMESTAMP(0) WITH TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITH TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_BEFECB0AB03A8386 ON metier.type_mandat (created_by_id)');
        $this->addSql('CREATE INDEX IDX_BEFECB0A896DBBDE ON metier.type_mandat (updated_by_id)');
        $this->addSql('CREATE TABLE metier.nationalite_fugitif (id INT NOT NULL, nationalite_id INT NOT NULL, fugitif_id INT NOT NULL, created_by_id INT DEFAULT NULL, updated_by_id INT DEFAULT NULL, principale BOOLEAN NOT NULL, created_at TIMESTAMP(0) WITH TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITH TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_C5E868B11B063272 ON metier.nationalite_fugitif (nationalite_id)');
        $this->addSql('CREATE INDEX IDX_C5E868B1C29BD459 ON metier.nationalite_fugitif (fugitif_id)');
        $this->addSql('CREATE INDEX IDX_C5E868B1B03A8386 ON metier.nationalite_fugitif (created_by_id)');
        $this->addSql('CREATE INDEX IDX_C5E868B1896DBBDE ON metier.nationalite_fugitif (updated_by_id)');
        $this->addSql('CREATE TABLE metier.nature_piece (id INT NOT NULL, created_by_id INT DEFAULT NULL, updated_by_id INT DEFAULT NULL, libelle VARCHAR(255) NOT NULL, created_at TIMESTAMP(0) WITH TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITH TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_185C2DDEB03A8386 ON metier.nature_piece (created_by_id)');
        $this->addSql('CREATE INDEX IDX_185C2DDE896DBBDE ON metier.nature_piece (updated_by_id)');
        $this->addSql('CREATE TABLE metier."user" (id INT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, created_at TIMESTAMP(0) WITH TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITH TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_E8A0DB16E7927C74 ON metier."user" (email)');
        $this->addSql('CREATE TABLE metier.fugitif (id INT NOT NULL, created_by_id INT DEFAULT NULL, updated_by_id INT DEFAULT NULL, nom VARCHAR(255) NOT NULL, prenoms VARCHAR(255) NOT NULL, nom_marital VARCHAR(255) DEFAULT NULL, alias VARCHAR(255) DEFAULT NULL, surnom VARCHAR(255) DEFAULT NULL, date_naissance DATE DEFAULT NULL, lieu_naissance VARCHAR(255) DEFAULT NULL, adresse TEXT DEFAULT NULL, taille DOUBLE PRECISION DEFAULT NULL, poids DOUBLE PRECISION DEFAULT NULL, couleur_yeux VARCHAR(255) DEFAULT NULL, couleur_peau VARCHAR(255) DEFAULT NULL, couleur_cheveux VARCHAR(255) DEFAULT NULL, photo_name VARCHAR(255) DEFAULT NULL, photo_size INT DEFAULT NULL, sexe VARCHAR(255) DEFAULT NULL, numero_telephone VARCHAR(255) DEFAULT NULL, observations TEXT DEFAULT NULL, langues VARCHAR(255) DEFAULT NULL, created_at TIMESTAMP(0) WITH TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITH TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_6D518BBBB03A8386 ON metier.fugitif (created_by_id)');
        $this->addSql('CREATE INDEX IDX_6D518BBB896DBBDE ON metier.fugitif (updated_by_id)');
        $this->addSql('ALTER TABLE metier.piece_identification ADD CONSTRAINT FK_2915CBED3BCB2E4B FOREIGN KEY (nature_id) REFERENCES metier.nature_piece (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE metier.piece_identification ADD CONSTRAINT FK_2915CBED9B236E7C FOREIGN KEY (authorite_id) REFERENCES metier.authorite_delivrance (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE metier.piece_identification ADD CONSTRAINT FK_2915CBEDC29BD459 FOREIGN KEY (fugitif_id) REFERENCES metier.fugitif (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE metier.piece_identification ADD CONSTRAINT FK_2915CBEDB03A8386 FOREIGN KEY (created_by_id) REFERENCES metier."user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE metier.piece_identification ADD CONSTRAINT FK_2915CBED896DBBDE FOREIGN KEY (updated_by_id) REFERENCES metier."user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE metier.nationalite ADD CONSTRAINT FK_1DBE98D8B03A8386 FOREIGN KEY (created_by_id) REFERENCES metier."user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE metier.nationalite ADD CONSTRAINT FK_1DBE98D8896DBBDE FOREIGN KEY (updated_by_id) REFERENCES metier."user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE metier.authorite_delivrance ADD CONSTRAINT FK_8B317D5AB03A8386 FOREIGN KEY (created_by_id) REFERENCES metier."user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE metier.authorite_delivrance ADD CONSTRAINT FK_8B317D5A896DBBDE FOREIGN KEY (updated_by_id) REFERENCES metier."user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE metier.mandat ADD CONSTRAINT FK_5DC1B7C072419C88 FOREIGN KEY (type_mandat_id) REFERENCES metier.type_mandat (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE metier.mandat ADD CONSTRAINT FK_5DC1B7C0C29BD459 FOREIGN KEY (fugitif_id) REFERENCES metier.fugitif (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE metier.mandat ADD CONSTRAINT FK_5DC1B7C0B03A8386 FOREIGN KEY (created_by_id) REFERENCES metier."user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE metier.mandat ADD CONSTRAINT FK_5DC1B7C0896DBBDE FOREIGN KEY (updated_by_id) REFERENCES metier."user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE metier.type_mandat ADD CONSTRAINT FK_BEFECB0AB03A8386 FOREIGN KEY (created_by_id) REFERENCES metier."user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE metier.type_mandat ADD CONSTRAINT FK_BEFECB0A896DBBDE FOREIGN KEY (updated_by_id) REFERENCES metier."user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE metier.nationalite_fugitif ADD CONSTRAINT FK_C5E868B11B063272 FOREIGN KEY (nationalite_id) REFERENCES metier.nationalite (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE metier.nationalite_fugitif ADD CONSTRAINT FK_C5E868B1C29BD459 FOREIGN KEY (fugitif_id) REFERENCES metier.fugitif (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE metier.nationalite_fugitif ADD CONSTRAINT FK_C5E868B1B03A8386 FOREIGN KEY (created_by_id) REFERENCES metier."user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE metier.nationalite_fugitif ADD CONSTRAINT FK_C5E868B1896DBBDE FOREIGN KEY (updated_by_id) REFERENCES metier."user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE metier.nature_piece ADD CONSTRAINT FK_185C2DDEB03A8386 FOREIGN KEY (created_by_id) REFERENCES metier."user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE metier.nature_piece ADD CONSTRAINT FK_185C2DDE896DBBDE FOREIGN KEY (updated_by_id) REFERENCES metier."user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE metier.fugitif ADD CONSTRAINT FK_6D518BBBB03A8386 FOREIGN KEY (created_by_id) REFERENCES metier."user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE metier.fugitif ADD CONSTRAINT FK_6D518BBB896DBBDE FOREIGN KEY (updated_by_id) REFERENCES metier."user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE metier.nationalite_fugitif DROP CONSTRAINT FK_C5E868B11B063272');
        $this->addSql('ALTER TABLE metier.piece_identification DROP CONSTRAINT FK_2915CBED9B236E7C');
        $this->addSql('ALTER TABLE metier.mandat DROP CONSTRAINT FK_5DC1B7C072419C88');
        $this->addSql('ALTER TABLE metier.piece_identification DROP CONSTRAINT FK_2915CBED3BCB2E4B');
        $this->addSql('ALTER TABLE metier.piece_identification DROP CONSTRAINT FK_2915CBEDB03A8386');
        $this->addSql('ALTER TABLE metier.piece_identification DROP CONSTRAINT FK_2915CBED896DBBDE');
        $this->addSql('ALTER TABLE metier.nationalite DROP CONSTRAINT FK_1DBE98D8B03A8386');
        $this->addSql('ALTER TABLE metier.nationalite DROP CONSTRAINT FK_1DBE98D8896DBBDE');
        $this->addSql('ALTER TABLE metier.authorite_delivrance DROP CONSTRAINT FK_8B317D5AB03A8386');
        $this->addSql('ALTER TABLE metier.authorite_delivrance DROP CONSTRAINT FK_8B317D5A896DBBDE');
        $this->addSql('ALTER TABLE metier.mandat DROP CONSTRAINT FK_5DC1B7C0B03A8386');
        $this->addSql('ALTER TABLE metier.mandat DROP CONSTRAINT FK_5DC1B7C0896DBBDE');
        $this->addSql('ALTER TABLE metier.type_mandat DROP CONSTRAINT FK_BEFECB0AB03A8386');
        $this->addSql('ALTER TABLE metier.type_mandat DROP CONSTRAINT FK_BEFECB0A896DBBDE');
        $this->addSql('ALTER TABLE metier.nationalite_fugitif DROP CONSTRAINT FK_C5E868B1B03A8386');
        $this->addSql('ALTER TABLE metier.nationalite_fugitif DROP CONSTRAINT FK_C5E868B1896DBBDE');
        $this->addSql('ALTER TABLE metier.nature_piece DROP CONSTRAINT FK_185C2DDEB03A8386');
        $this->addSql('ALTER TABLE metier.nature_piece DROP CONSTRAINT FK_185C2DDE896DBBDE');
        $this->addSql('ALTER TABLE metier.fugitif DROP CONSTRAINT FK_6D518BBBB03A8386');
        $this->addSql('ALTER TABLE metier.fugitif DROP CONSTRAINT FK_6D518BBB896DBBDE');
        $this->addSql('ALTER TABLE metier.piece_identification DROP CONSTRAINT FK_2915CBEDC29BD459');
        $this->addSql('ALTER TABLE metier.mandat DROP CONSTRAINT FK_5DC1B7C0C29BD459');
        $this->addSql('ALTER TABLE metier.nationalite_fugitif DROP CONSTRAINT FK_C5E868B1C29BD459');
        $this->addSql('DROP SEQUENCE metier.piece_identification_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE metier.nationalite_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE metier.authorite_delivrance_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE metier.mandat_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE metier.type_mandat_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE metier.nationalite_fugitif_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE metier.nature_piece_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE metier.user_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE metier.fugitif_id_seq CASCADE');
        $this->addSql('DROP TABLE metier.piece_identification');
        $this->addSql('DROP TABLE metier.nationalite');
        $this->addSql('DROP TABLE metier.authorite_delivrance');
        $this->addSql('DROP TABLE metier.mandat');
        $this->addSql('DROP TABLE metier.type_mandat');
        $this->addSql('DROP TABLE metier.nationalite_fugitif');
        $this->addSql('DROP TABLE metier.nature_piece');
        $this->addSql('DROP TABLE metier."user"');
        $this->addSql('DROP TABLE metier.fugitif');
    }
}
