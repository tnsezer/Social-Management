<?php

declare(strict_types=1);

namespace App\DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;
use Faker\Factory;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190422220712 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        $faker = Factory::create();

        $this->connection->exec('INSERT INTO users
        SET
        name = "Tan",
        email = "test@vonq.com",
        password = "123456"');

        $users = [];
        for ($i=2;$i<=15;$i++) {
            try {
                $this->connection->exec('INSERT INTO users
            SET
            name = "' . $faker->name . '",
            email = "' . $faker->email . '",
            password = "123456"');
                $users[] = $i;
            } catch (\Exception $e) {

            }
        }

        $groups = [];
        for ($i=1;$i<=15;$i++) {
            try {
                $this->connection->exec('INSERT INTO groups
            SET
            name = "' . $faker->text(15) . '"');
                $groups[] = $i;
            } catch (\Exception $e) {

            }
        }

        $meetings = [];
        for ($i=1;$i<=15;$i++) {
            $group = $groups[rand(0, count($groups))];
            try {
                $this->connection->exec('INSERT INTO meetings
            SET
            name = "' . $faker->text(15) . '",
            group_id = "' . $group . '"');
                $meetings[] = $i;
            } catch (\Exception $e) {

            }
        }

        for ($i=1;$i<=15;$i++) {
            $user = $users[rand(0, count($users))];
            $group = $groups[rand(0, count($groups))];
            try {
                $this->connection->exec('INSERT INTO user_groups
            SET
            user_id = "' . $user . '",
            group_id = "' . $group . '"');
            } catch (\Exception $e) {

            }
        }

        for ($i=0;$i<15;$i++) {
            $user = $users[rand(0, count($users)-1)];
            $meeting = $meetings[rand(0, count($meetings))];
            $participation = rand(0,1);
            try {
                $this->connection->exec('INSERT INTO user_meetings
            SET
            participation = "' . $participation . '",
            user_id = "' . $user . '",
            meeting_id = "' . $meeting . '"');
            } catch (\Exception $e) {

            }
        }
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs

    }
}
