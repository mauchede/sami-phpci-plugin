<?php

namespace Mauchede\PHPCI\Plugin;

use PHPCI\Builder;
use PHPCI\Model\Build;
use PHPCI\Plugin;

class Sami implements Plugin
{
    /**
     * @var string
     */
    private $configFile;

    /**
     * @var string
     */
    private $force;

    /**
     * @param Builder $phpci
     * @param Build   $build
     * @param array   $options
     */
    public function __construct(Builder $phpci, Build $build, array $options = array())
    {
        $this->phpci = $phpci;
        $this->executable = $this->phpci->findBinary('sami');

        $this->configFile = 'sami.php';
        if (isset($options['config'])) {
            $this->configFile = $options['config'];
        }

        $this->force = '--force';
        if (isset($options['force']) && !$options['force']) {
            $this->force = '';
        }
    }

    /**
     * {@inheritdoc}
     */
    public function execute()
    {
        chdir($this->phpci->buildPath);

        if (!is_file($this->configFile)) {
            $this->phpci->logFailure(sprintf('The sami config file "%s" is missing.', $this->configFile));

            return false;
        }

        return $this->phpci->executeCommand(
            '%s update %s %s --quiet --no-ansi --no-interaction',
            $this->executable,
            $this->configFile,
            $this->force
        );
    }
}
