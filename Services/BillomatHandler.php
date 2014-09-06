<?php

namespace PhobetorBillomatBundle\Services;

use Guzzle\Plugin\Async\AsyncPlugin;
use Phobetor\Billomat\Client\BillomatClient;

/**
 * @license MIT
 */
class BillomatHandler
{
    /**
     * @var string
     */
    private $id;

    /**
     * @var string
     */
    private $apiKey;

    /**
     * @var bool
     */
    private $waitForRateLimitReset;

    /**
     * @var bool
     */
    private $async;

    /**
     * Initialize Handler
     *
     * @param string  $id billomat id
     * @param string  $apiKey billomat API key
     * @param boolean $waitForRateLimitReset optional wait for rate limit reset if rate limit is reached during a request
     * @param boolean $async optional use of Guzzle Async plugin
     *
     * @return BillomatHandler
     */
    public function __construct($id, $apiKey, $waitForRateLimitReset, $async = false)
    {
        $this->id = (string) $id;
        $this->apiKey = (string) $apiKey;
        $this->waitForRateLimitReset = (bool) $waitForRateLimitReset;
        $this->async = (bool) $async;
    }

    /**
     * Create Billomat Client
     *
     * @return \Phobetor\Billomat\Client\BillomatClient $client
     */
    public function getClient()
    {
        $client = new BillomatClient($this->id, $this->apiKey, BillomatClient::LATEST_API_VERSION, $this->waitForRateLimitReset);

        if($this->async) {
            $client->addSubscriber(new AsyncPlugin());
        }

        return $client;
    }
}
