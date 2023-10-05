<?php

namespace Devamirul\PhpMicro\core\Foundation\Application\Facade\Facades;

use Devamirul\PhpMicro\core\Foundation\Application\Facade\BaseFacade;

class Router extends BaseFacade {

    protected static function getFacadeAccessor(): string {
        return 'Router';
    }
}
