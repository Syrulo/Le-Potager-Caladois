<?php

use App\Kernel;
use Symfony\Component\Dotenv\Dotenv;

require_once dirname(__DIR__).'/vendor/autoload_runtime.php';

if ($_SERVER['APP_ENV'] ?? $_ENV['APP_ENV'] ?? null !== 'prod') {
    (new Dotenv())->bootEnv(dirname(__DIR__).'/.env');
}

return function (array $context) {
    return new Kernel($context['APP_ENV'], (bool) $context['APP_DEBUG']);
};
