<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\StatisticRepository")
 *
 * @UniqueEntity(fields={"currencyFrom", "currencyTo", "time"})
 */
class Statistic implements \JsonSerializable
{
    /**
     * @var int|null
     *
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var Currency
     *
     * @ORM\ManyToOne(targetEntity="Currency")
     * @ORM\JoinColumn(onDelete="CASCADE")
     */
    private $currencyFrom;

    /**
     * @var Currency
     *
     * @ORM\ManyToOne(targetEntity="Currency")
     * @ORM\JoinColumn(onDelete="CASCADE")
     */
    private $currencyTo;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime")
     */
    private $time;

    /**
     * @var string|null
     *
     * @ORM\Column(type="decimal", scale=2)
     */
    private $average;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Currency|null
     */
    public function getCurrencyFrom(): ?Currency
    {
        return $this->currencyFrom;
    }

    /**
     * @param Currency $currencyFrom
     *
     * @return self
     */
    public function setCurrencyFrom(Currency $currencyFrom): self
    {
        $this->currencyFrom = $currencyFrom;

        return $this;
    }

    /**
     * @return Currency|null
     */
    public function getCurrencyTo(): ?Currency
    {
        return $this->currencyTo;
    }

    /**
     * @param Currency $currencyTo
     *
     * @return self
     */
    public function setCurrencyTo(Currency $currencyTo): self
    {
        $this->currencyTo = $currencyTo;

        return $this;
    }

    /**
     * @return \DateTime|null
     */
    public function getTime(): ?\DateTime
    {
        return $this->time;
    }

    /**
     * @param \DateTime $time
     *
     * @return self
     */
    public function setTime(\DateTime $time): self
    {
        $this->time = $time;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getAverage(): ?string
    {
        return $this->average;
    }

    /**
     * @param string|null $average
     *
     * @return self
     */
    public function setAverage(?string $average): self
    {
        $this->average = $average;

        return $this;
    }

    /**
     * @see \JsonSerializable
     */
    public function jsonSerialize()
    {
        return [
            'time' => $this->getTime()->getTimestamp(),
            'average' => (float) $this->getAverage(),
            'code' => $this->getCurrencyTo()->getCode(),
        ];
    }
}
