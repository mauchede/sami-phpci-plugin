<?php

namespace Mauchede\PHPCI\Plugin\Tests;

use Mauchede\PHPCI\Plugin\Sami;
use PHPCI\Builder;
use PHPCI\Model\Build;
use Psr\Log\LoggerInterface;

class SamiTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    private $build;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    private $logger;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    private $phpci;

    /**
     * Tests the plugin with the parameter "config".
     */
    public function testExecuteWithConfigParameter()
    {
        $this->phpci
            ->expects($this->any())
            ->method('findBinary')
            ->with('sami')
            ->willReturn('/usr/local/bin/sami');

        $this->phpci
            ->expects($this->once())
            ->method('executeCommand')
            ->with(
                '%s update %s %s --quiet --no-ansi --no-interaction',
                '/usr/local/bin/sami',
                __DIR__.'/Fixtures/sami.php',
                '--force'
            )
            ->willReturn(true);

        $plugin = new Sami(
            $this->phpci,
            $this->build,
            [
                'config' => __DIR__.'/Fixtures/sami.php',
            ]
        );

        $this->assertTrue($plugin->execute());
    }

    /**
     * Tests the plugin with the parameter "force".
     */
    public function testExecuteWithForceParameter()
    {
        $this->phpci
            ->expects($this->any())
            ->method('findBinary')
            ->with('sami')
            ->willReturn('/usr/local/bin/sami');

        $this->phpci
            ->expects($this->once())
            ->method('executeCommand')
            ->with(
                '%s update %s %s --quiet --no-ansi --no-interaction',
                '/usr/local/bin/sami',
                __DIR__.'/Fixtures/sami.php',
                ''
            )
            ->willReturn(true);

        $plugin = new Sami(
            $this->phpci,
            $this->build,
            [
                'config' => __DIR__.'/Fixtures/sami.php',
                'force' => false,
            ]
        );

        $this->assertTrue($plugin->execute());
    }

    /**
     * Tests the plugin with a missing configuration file.
     */
    public function testExecuteWithMissingConfigurationFile()
    {
        $plugin = new Sami(
            $this->phpci,
            $this->build
        );

        $this->phpci
            ->expects($this->once())
            ->method('logFailure')
            ->with(
                sprintf(
                    'The sami config file "%s" is missing.',
                    __DIR__.'/sami.php'
                )
            );

        $this->assertFalse($plugin->execute());
    }

    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        $this->build = $this->getMock(Build::class);
        $this->logger = $this->getMock(LoggerInterface::class);

        $this->phpci = $this
            ->getMockBuilder(Builder::class)
            ->disableOriginalConstructor()
            ->getMock();
        $this->phpci->buildPath = __DIR__;
    }
}
