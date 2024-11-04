<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Resources\V1\UrlResource;
use App\Models\Url;
use App\Policies\V1\UrlPolicy;
use App\Traits\ApiResponses;
use Illuminate\Http\Request;

class UrlController extends ApiController
{
    use ApiResponses;

    protected $policy = UrlPolicy::class;

    public function index()
    {
        return UrlResource::collection(
            Url::where('user_id', auth()->id())->paginate()
        );
    }

    public function show(Url $url)
    {
        if ($this->isAble('view', $url)) {
            return new UrlResource($url);
        }
        return $this->unAuthorize('You are not authorize to see this resource.');
    }
}
