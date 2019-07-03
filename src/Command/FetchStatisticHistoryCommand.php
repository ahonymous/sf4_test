<?php

declare(strict_types=1);

namespace App\Command;

use App\Entity\Currency;
use App\Entity\Statistic;
use App\Exception\HistoryFetchException;
use App\Service\Traits\DoctrineTrait;
use App\Service\Traits\HistoryFetcherTrait;
use RuntimeException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Serializer\Exception\BadMethodCallException;
use Symfony\Component\Serializer\Exception\ExceptionInterface;

/**
 * Class FetchStatisticHistory.
 */
class FetchStatisticHistoryCommand extends Command
{
    use HistoryFetcherTrait;
    use DoctrineTrait;

    /**
     * @see Command
     */
    protected function configure()
    {
        $this
            ->setDescription('Fetch statistic data.')
            ->setHelp('This command allows you to fetch BTC statistic with USD and EUR')
            ->setName('statistic:history:fetch')
        ;
    }

    /**
     * @param InputInterface  $input
     * @param OutputInterface $output
     *
     * @return int|void|null
     *
     * @throws HistoryFetchException
     * @throws ExceptionInterface
     *
     * @see Command
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);
        $io->title('Fetch Statistic data from bitcoinaverage.com');
        $manager = $this->doctrine->getManager();

        $batch = 0;
        $mainCurrency = $this->getCurrency('BTC');
        $statisticRepository = $this->doctrine->getRepository(Statistic::class);

        foreach ($this->historyFetcher::SYMBOLS as $symbol => $path) {
            $currency = $this->getCurrency($symbol);

            foreach ($this->historyFetcher->fetchDailyStatisticData($path) as $data) {
                if (!isset($data['time']) || !$data['time'] || !isset($data['average']) || !$data['average']) {
                    throw new RuntimeException('Need check source api response.');
                }
                $time = new \DateTime($data['time']);
                $existStatistic = $statisticRepository->findOneBy([
                    'currencyFrom' => $mainCurrency,
                    'currencyTo' => $currency,
                    'time' => $time,
                ]);

                if ($existStatistic || '00' !== $time->format('i')) {
                    continue;
                }

                $statistic = (new Statistic())
                    ->setCurrencyFrom($mainCurrency)
                    ->setCurrencyTo($currency)
                    ->setTime($time)
                    ->setAverage((string) $data['average'])
                ;

                $manager->persist($statistic);

                if (0 === ($batch % 100)) {
                    $manager->flush();
                    $manager->clear();
                    gc_collect_cycles();
                    $mainCurrency = $this->getCurrency('BTC');
                    $currency = $this->getCurrency($symbol);
                }
            }
        }

        $manager->flush();
        $io->writeln('Finished import.');
    }

    /**
     * @param string $code
     *
     * @return Currency
     */
    private function getCurrency(string $code): Currency
    {
        $currency = $this->doctrine->getRepository(Currency::class)->findOneBy(['code' => $code]);

        if (!$currency) {
            throw new BadMethodCallException(sprintf('Currency was not found with value %s.', $code));
        }

        return $currency;
    }
}
