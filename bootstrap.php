<?php

date_default_timezone_set('Asia/Tokyo');

require __DIR__ . '/vendor/autoload.php';

// load to .env
(new \Dotenv\Dotenv(__DIR__))->load();