<?php

namespace Devamirul\PhpMicro\core\Foundation\Application\Supports;

class url {

    public static function makeResetLink(string $email, string $path): string {
        return config('app', 'app_url') . $path . '?reset=' . bin2hex(random_bytes(40)) . '&email=' . $email;
    }

    public static function basePath(string $path = null): string {
        return APP_ROOT . $path;
    }

    public static function url(string $path = null): string {
        return config('app', 'app_url');
    }

}
