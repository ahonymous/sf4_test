<?php

declare(strict_types=1);

namespace App\Service\Traits;

use App\Service\Statistic\HistoryFetcher;

/**
 * Trait HistoryFetcherTrait.
 */
trait HistoryFetcherTrait
{
    /**
     * @var HistoryFetcher
     */
    private $historyFetcher;

    /**
     * @param HistoryFetcher $historyFetcher
     *
     * @required
     */
    public function setHistoryFetcher(HistoryFetcher $historyFetcher): void
    {
        $this->historyFetcher = $historyFetcher;
    }
}
