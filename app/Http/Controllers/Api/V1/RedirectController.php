<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Url;

class RedirectController extends Controller
{
    public function __invoke(Url $url)
    {
        $url->update([
            'visitorCount' => ++$url->visitorCount
        ]);
        return redirect($url->longUrl);
    }
}
