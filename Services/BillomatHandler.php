<?php

namespace PhobetorBillomatBundle\Services;

use Guzzle\Plugin\Async\AsyncPlugin;
use Phobetor\Billomat\Client\BillomatClient;

/**
 * @license MIT
 */
class BillomatHandler
{
    const DEFAULT_CLIENT_NAME = 'default';

    /**
     * @var array
     */
    private $clients;

    /**
     * Initialize Handler
     *
     * @param array $clients client configuration list
     *
     * @return BillomatHandler
     */
    public function __construct(array $clients)
    {
        $this->clients = $clients;
    }

    /**
     * Create Billomat Client
     *
     * @param string $name
     * @return \Phobetor\Billomat\Client\BillomatClient $client
     * @throws \InvalidArgumentException
     */
    public function getClient($name = self::DEFAULT_CLIENT_NAME)
    {
        if (empty($this->clients[$name])) {
            throw new \InvalidArgumentException(sprintf('client with name "%s" not found'. $name));
        }

        $config = $this->clients[$name];

        $client = new BillomatClient(
            $config['id'],
            $config['api_key'],
            $config['application']['id'],
            $config['application']['secret'],
            $config['wait_for_rate_limit_reset']
        );

        if ($config['async']) {
            $client->addSubscriber(new AsyncPlugin());
        }

        return $client;
    }
}
