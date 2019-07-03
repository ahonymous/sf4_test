<?php

declare(strict_types=1);

namespace App\Service\Statistic;

use App\Exception\HistoryFetchException;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpClient\NativeHttpClient;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Encoder\DecoderInterface;

/**
 * Class HistoryFetcher.
 */
class HistoryFetcher
{
    /**
     * @const string Token key from request header to https://apiv2.bitcoinaverage.com
     */
    private const HEADER_PREFIX = 'X-ba-key';

    /**
     * @const string Base URL to https://apiv2.bitcoinaverage.com
     */
    private const BASE_API2_URL = 'https://apiv2.bitcoinaverage.com';

    /**
     * @const string Base URL to https://apiv2.bitcoinaverage.com
     */
    private const DEFAULT_FORMAT_DATA = 'json';

    /**
     * @const string[] s
     */
    public const SYMBOLS = [
        'USD' => 'BTCUSD',
        'EUR' => 'BTCEUR',
    ];

    /**
     * @var string
     */
    private $token;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @var DecoderInterface
     */
    private $decoder;

    /**
     * HistoryFetcher constructor.
     *
     * @param string           $token
     * @param LoggerInterface  $logger
     * @param DecoderInterface $serializer
     */
    public function __construct(string $token, LoggerInterface $logger, DecoderInterface $decoder)
    {
        $this->token = $token;
        $this->logger = $logger;
        $this->decoder = $decoder;
    }

    /**
     * @param string $symbol
     *
     * @return array
     *
     * @throws HistoryFetchException
     */
    public function fetchDailyStatisticData(string $symbol): array
    {
        $httpClient = new NativeHttpClient();
        $url = $this->buildURL(sprintf('indices/global/history/%s', $symbol));
        $this->logger->info('Start fetching data.', ['url' => $url, 'symbol' => $symbol]);

        try {
            $response = $httpClient->request(Request::METHOD_GET, $url, [
                'headers' => [
                    self::HEADER_PREFIX => $this->token,
                ],
                'query' => [
                    'period' => 'daily',
                    'format' => self::DEFAULT_FORMAT_DATA,
                ],
            ]);

            if (Response::HTTP_OK === $response->getStatusCode()) {
                $this->logger->info(sprintf('Getting %s statistic is a ready success.', $symbol), [
                    'url' => $url,
                ]);

                return $this->decoder->decode(
                    $response->getContent(),
                    self::DEFAULT_FORMAT_DATA
                );
            }
        } catch (\Throwable $e) {
            $this->logger->error($e->getMessage(), ['url' => $url, 'symbol' => $symbol]);
        }

        throw new HistoryFetchException();
    }

    /**
     * @param string $path
     *
     * @return string
     */
    private function buildURL(string $path = ''): string
    {
        return sprintf('%s/%s', self::BASE_API2_URL, $path);
    }
}
