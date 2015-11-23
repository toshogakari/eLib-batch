<?php

namespace App\Commands;

use Symfony\Component\Console\Helper\HelperSet;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

abstract class AbstractCommand
{
    /**
     * call name
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $option = '[-f|--force]';

    /**
     * @var array
     */
    private $messages = [
        'title'  => 'APIから情報を取得します。',
        'option' => 'データがあった場合上書きします。'
    ];

    /**
     * @var HelperSet
     */
    protected $helper;

    /**
     * @var OutputInterface
     */
    protected $output;

    /**
     * constructor
     * @param HelperSet $helper
     */
    public function __construct(HelperSet $helper)
    {
        if (empty($this->name)) {
            throw new \UnexpectedValueException('empty call name.');
        }
        $this->helper = $helper;
    }

    /**
     * 実行
     * @param InputInterface $input
     * @param OutputInterface $output
     */
    abstract public function execute(InputInterface $input, OutputInterface $output);

    /**
     * Get call name.
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getOption()
    {
        return $this->option;
    }

    /**
     * @return string
     */
    public function getExpression()
    {
        return sprintf('%s %s', $this->name, $this->option);
    }

    /**
     * @return string
     */
    public function getMessageTitle()
    {
        return $this->messages['title'];
    }

    /**
     * @return string
     */
    public function getMessageOption()
    {
        return $this->messages['option'];
    }

    /**
     * @param $message
     * @return $this
     */
    public function setMessageTitle($message)
    {
        $this->messages['title'] = $message;
        return $this;
    }

    /**
     * @param $message
     * @return $this
     */
    public function setMessageOption($message)
    {
        $this->messages['option'] = $message;
        return $this;
    }

    /**
     * @param OutputInterface $output
     */
    protected function setOutput(OutputInterface $output)
    {
        $this->output = $output;
    }

}