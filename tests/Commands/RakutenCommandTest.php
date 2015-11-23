<?php

use Symfony\Component\Console\Input\ArgvInput;
use Symfony\Component\Console\Output\ConsoleOutput;

class RakutenCommandTest extends PHPUnit_Framework_TestCase
{
    public function testExecute()
    {
        $app = new \Silly\Application();
        $command = new \App\Commands\RakutenCommand($app->getHelperSet());

        $app->command($command->getExpression(), [$command, 'execute']);
        $code = $app->doRun(new ArgvInput([
            null,
            'rakuten',
        ]), new ConsoleOutput());
        $this->assertEquals($code, 0);
    }
}