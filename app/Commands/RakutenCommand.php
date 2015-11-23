<?php

namespace App\Commands;

use App\Components\ActiveResources\Rakuten;
use Symfony\Component\Console\Helper\HelperSet;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class RakutenCommand extends AbstractCommand
{
    /**
     * @var string
     */
    protected $name = 'rakuten';

    /**
     * @param HelperSet $helperSet
     */
    public function __construct(HelperSet $helperSet)
    {
        parent::__construct($helperSet);
        $this->setMessageTitle('楽天APIから情報を取得します。');
    }

    /**
     * 実行
     * @param InputInterface $input
     * @param OutputInterface $output
     */
    public function execute(InputInterface $input, OutputInterface $output)
    {
        throw new \Exception;
    }

}