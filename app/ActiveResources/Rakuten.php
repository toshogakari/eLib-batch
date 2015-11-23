<?php

namespace App\ActiveResources;

use App\ActiveResources\Results\RakutenResult;

class Rakuten extends AbstractActiveResource
{
    /**
     * Set Initialize Properties.
     * @return void
     */
    protected function initialize()
    {
        $this->site = 'https://app.rakuten.co.jp/services/api/BooksBook/Search/20130522';
        $this->token = getenv('RAKUTEN_TOKEN');
        $this->providers['Result'] = RakutenResult::class;
    }

    /**
     * join url to site and token .
     * @return string
     */
    public function joinTokenUrl()
    {
        return sprintf('%s?applicationId=%s', $this->site, $this->token);
    }

}