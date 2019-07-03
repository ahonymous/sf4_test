<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Currency;
use App\Entity\Statistic;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class StatisticFixtures extends Fixture implements DependentFixtureInterface
{
    /**
     * @see DependentFixtureInterface
     */
    public function getDependencies(): array
    {
        return [
            CurrencyFixtures::class,
        ];
    }

    /**
     * @param ObjectManager $manager
     *
     * @throws \Exception
     */
    public function load(ObjectManager $manager): void
    {
        $usdData = json_decode(file_get_contents(__DIR__.'/Data/usd.json'), true);
        /** @var Currency $btc */
        $btc = $this->getReference('BTC');
        /** @var Currency $usd */
        $usd = $this->getReference('USD');
        /** @var Currency $eur */
        $eur = $this->getReference('EUR');
        $this->loadData($manager, $usdData, $btc, $usd);
        $eurData = json_decode(file_get_contents(__DIR__.'/Data/eur.json'), true);
        $this->loadData($manager, $eurData, $btc, $eur);

        $manager->flush();
        $manager->clear();
    }

    /**
     * @param ObjectManager $manager
     * @param array         $data
     * @param Currency      $from
     * @param Currency      $to
     *
     * @throws \Exception
     */
    private function loadData(ObjectManager $manager, array $data, Currency $from, Currency $to): void
    {
        foreach ($data as $datum) {
            $exchange = new Statistic();
            $exchange
                ->setCurrencyFrom($from)
                ->setCurrencyTo($to)
                ->setTime((new \DateTime())->setTimestamp($datum['time']))
                ->setAverage((string) $datum['close']);
            $manager->persist($exchange);
        }
    }
}
