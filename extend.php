<?php

namespace ClarkWinkelmann\JWTCookie;

use Flarum\Extend;

return [
    (new Extend\Frontend('forum'))
        ->content(Content::class),

    (new Extend\Frontend('admin'))
        ->js(__DIR__ . '/js/dist/admin.js'),
];
