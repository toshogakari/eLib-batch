<?php

namespace App;

use App\Commands\AbstractCommand;
use App\Commands\RakutenCommand;
use Silly\Application;

class Kernel
{

    protected $app;

    protected $commands = [
        RakutenCommand::class,
    ];

    public function run(Application $app)
    {
        foreach ($this->commands as $expression => $commandClass) {

            if (!class_exists($commandClass)) {
                throw new \RuntimeException('undefined class ' . $commandClass);
            }

            $instance = new $commandClass($app->getHelperSet());

            if (!$instance instanceof AbstractCommand) {
                throw new \RuntimeException();
            }

            $argsComment = [];
            if (preg_match('/--[a-zA-Z]{1,}/', $instance->getOption(), $match)) {
                $argsComment[$match[0]] = $instance->getMessageOption();
            }
            $app->command($instance->getExpression(), [$instance, 'execute'])
                ->descriptions($instance->getMessageTitle(), $argsComment);
        }

        $app->run();
    }

}