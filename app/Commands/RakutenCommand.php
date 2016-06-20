<?php

namespace App\Commands;

use App\Components\ActiveResources\Rakuten;
use App\Services\RakutenService;
use Symfony\Component\Console\Helper\HelperSet;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class RakutenCommand extends AbstractCommand
{
    /**
     * @var string
     */
    protected $name = 'rakuten';

    private $searchGenreId = '001005005';

    private $service;

    /**
     * @param HelperSet $helperSet
     */
    public function __construct(HelperSet $helperSet)
    {
        parent::__construct($helperSet);
        $this->setMessageTitle('楽天APIから情報を取得します。');
        $this->service = new RakutenService();
    }

    /**
     * 実行
     * @param InputInterface $input
     * @param OutputInterface $output
     */
    public function execute(InputInterface $input, OutputInterface $output)
    {
        $this->setOutput($output);
        $condition = ['booksGenreId' => $this->searchGenreId];
        $item    = $this->service->find($condition);
        if (empty($item)) {
            $output->writeln('該当する本が見つかりませんでした.');
            return;
        }
        $current = intval($item['currentPage']);
        $end     = intval($item['maxPage']);
        $output->writeln("$end 件見つかりました。実行します");
        $this->entry($item['result'], $output);
        if ($current === $end) {
            return;
        }
        $current++;
        $pages = range($current, $end);
        foreach ($pages as $page) {
            $item = $this->service->page($page, $condition);
            $this->entry($item['result'], $output);
        }
    }

    /**
     * @param array $books
     */
    private function entry(array $books)
    {
        foreach ($books as $book) {
            $this->output->writeln('Book: [' . $book['title'] . ']を読み込みます');
        }
        $this->output->writeln(count($books) . '件読み込み完了しました');
    }

}