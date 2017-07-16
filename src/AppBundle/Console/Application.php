<?php

namespace AppBundle\Console;

use Symfony\Component\Console\Input\InputOption;

class Application extends \Symfony\Component\Console\Application
{
    protected function getDefaultInputDefinition()
    {
        $definition = parent::getDefaultInputDefinition();
        $definition->addOption(new InputOption('--child', null, InputOption::VALUE_NONE, 'Run as child process'));

        return $definition;
    }
}
