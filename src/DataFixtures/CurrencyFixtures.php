<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Currency;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class CurrencyFixtures extends Fixture
{
    private const CURRENCIES = [
        'BTC' => 'Bitcoin',
        'EUR' => 'Euro',
        'USD' => 'US Dollar',
    ];

    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager): void
    {
        foreach (self::CURRENCIES as $code => $name) {
            $currency = new Currency();
            $currency
                ->setName($name)
                ->setCode($code);
            $manager->persist($currency);
            $this->addReference($code, $currency);
        }

        $manager->flush();
    }
}
