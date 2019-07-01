<?php

declare(strict_types=1);

namespace App\Filter;

/**
 * Class StatisticFilter.
 */
class StatisticFilter
{
    /**
     * @var \DateTime|null
     */
    private $timeFrom;

    /**
     * @var \DateTime|null
     */
    private $timeTo;

    /**
     * @var string|null
     */
    private $currencyCode;

    /**
     * @return \DateTime|null
     */
    public function getTimeFrom(): ?\DateTime
    {
        return $this->timeFrom;
    }

    /**
     * @param \DateTime|null $timeFrom
     *
     * @return StatisticFilter
     */
    public function setTimeFrom(?\DateTime $timeFrom): self
    {
        $this->timeFrom = $timeFrom;

        return $this;
    }

    /**
     * @return \DateTime|null
     */
    public function getTimeTo(): ?\DateTime
    {
        return $this->timeTo;
    }

    /**
     * @param \DateTime|null $timeTo
     *
     * @return StatisticFilter
     */
    public function setTimeTo(?\DateTime $timeTo): self
    {
        $this->timeTo = $timeTo;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getCurrencyCode(): ?string
    {
        return $this->currencyCode;
    }

    /**
     * @param string|null $currencyCode
     *
     * @return StatisticFilter
     */
    public function setCurrencyCode(?string $currencyCode): self
    {
        $this->currencyCode = $currencyCode;

        return $this;
    }
}
