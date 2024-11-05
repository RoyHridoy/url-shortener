<?php

namespace App\Http\Controllers\Api\V2;

use App\Http\Controllers\Api\V1\ApiController;
use App\Http\Requests\Api\V2\UpdateUrlRequest;
use App\Http\Resources\V1\UrlResource;
use App\Models\Url;
use App\Traits\ApiResponses;

class UrlController extends ApiController
{
    use ApiResponses;
    public function update(UpdateUrlRequest $request, Url $url)
    {
        if ($this->isAble('update', $url)) {
            $url->update([
                'shortUrl' => $request->mappedAttributes()['shortUrl'],
                'isCustomized' => 1
            ]);
            return new UrlResource($url);
        }
        return $this->unAuthorize('You are not authorized to update the url resource.');
    }
}
