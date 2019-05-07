<?php

namespace Tests\Order\Support;


use Illuminate\Support\Collection;
use PhpPact\Standalone\MockService\MockServerConfig;
use PhpPact\Standalone\MockService\MockServerConfigInterface;

class MockServerConfigFactory
{
    /**
     * @var MockServerConfigFactory
     */
    private static $factory;

    /**
     * @var Collection
     */
    private $defaults;

    /**
     * @var \Illuminate\Support\Collection
     */
    private $configs;

    private function __construct()
    {
        $this->configs = collect([]);
        $this->defaults = collect([
            'consumer-name' => 'order-service',
            'pact-dir' => '/tmp/pact-dist',
            'healthcheck-timeout' => 150,
            'log' => 'debug',
        ]);
    }

    /**
     * @param string $service
     */
    private function make(string $service): void
    {
        $port = rand(49152, 65535);

        $config = (new MockServerConfig)
            ->setConsumer($this->defaults->get('consumer-name'))
            ->setPactDir($this->defaults->get('pact-dir'))
            ->setProvider($service)
            ->setHealthCheckTimeout($this->defaults->get('healthcheck-timeout'))
            ->setLog($this->defaults->get('log'))
            ->setPort($port);

        $this->configs->put($service, $config);
    }

    /**
     * @return MockServerConfigFactory
     */
    public static function instance(): MockServerConfigFactory
    {
        if (empty(self::$factory)) {
            self::$factory = new static();
        }

        return self::$factory;
    }

    /**
     * @param string $service
     * @return MockServerConfigInterface
     */
    public static function get(string $service): MockServerConfigInterface
    {
        if (!self::instance()->configs->has($service)) {
            self::instance()->make($service);
        }

        return self::instance()->configs->get($service);
    }
}
