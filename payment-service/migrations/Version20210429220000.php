<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Carbon\Carbon;
use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;
use Ramsey\Uuid\Uuid;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210429220000 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $orders = json_decode(file_get_contents(__DIR__ . '/_data/orders.json'), true);

        foreach ($orders as $order) {
            $this->insertTransactions($order);
        }
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('TRUNCATE TABLE "payment"');
    }

    private function insertTransactions(array $order): void
    {
        $totalPayments = rand(1, 4);
        $openAmount = $order['gross_total'];
        $transferDate = Carbon::parse($order['ordered_at']);

        for ($i = 0; $i < $totalPayments; $i++) {
            $amount = $this->randomNumber(20, $openAmount);
            if (($i+1) === $totalPayments) {
                $amount = rand(0, 50) % 3 === 0 ? $openAmount : $amount;
            }

            $this->connection->executeQuery(
                'INSERT INTO "payment" (id, order_id, amount, transferred_at, description) VALUES (?, ?, ?, ?, ?)',
                [
                    Uuid::uuid4()->toString(),
                    $order['id'],
                    $amount,
                    $transferDate->addDays(rand(7, 15))->toIso8601String(),
                    'Payment ' . ($i+1) . ' to order: ' . substr($order['id'], 0, 6),
                ]
            );
        }


    }

    private function randomNumber($min = 0, $max = 1, $decimals = 2): float
    {
        $scale = 10 ** $decimals;

        return random_int($min * $scale, $max * $scale) / $scale;
    }
}
