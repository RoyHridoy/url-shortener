<?php

namespace App\Services\V2;

use App\Http\Requests\Api\V2\UpdateUrlRequest;
use App\Models\Url;

class UrlService
{
    public function updateOrCreate(UpdateUrlRequest $request, Url $url)
    {
        if ($url->users->pluck('id')->count() > 1) {
            $url->users()->detach(auth()->id());
            $newUrl = $url->create([
                'longUrl' => $url->longUrl,
                'shortUrl' => $request->mappedAttributes()['shortUrl'],
                'visitorCount' => $url->visitorCount,
                'isCustomized' => 1
            ]);
            $newUrl->users()->attach(auth()->id());

            return $newUrl;

        } else {
            $url->update([
                'shortUrl' => $request->mappedAttributes()['shortUrl'],
                'isCustomized' => 1
            ]);
        }
        return $url;
    }
}
