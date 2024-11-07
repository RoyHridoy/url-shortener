<?php

namespace App\Http\Controllers\Api\V2;

use App\Http\Controllers\Api\V1\ApiController;
use App\Http\Requests\Api\V1\StoreUrlRequest;
use App\Http\Requests\Api\V2\UpdateUrlRequest;
use App\Http\Resources\V2\UrlResource;
use App\Models\Url;
use App\Services\V1\UrlService;
use App\Services\V2\UrlService as UrlServiceV2;
use App\Traits\ApiResponses;

class UrlController extends ApiController
{
    use ApiResponses;

    protected $policy = UrlPolicy::class;

    /**
     * Display a paginated list of URLs associated with the authenticated user.
     *
     * Retrieves URLs in descending order by creation date and returns them as a
     * paginated collection of `UrlResource` instances.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection Collection of URL resources.
     */
    public function index()
    {
        return UrlResource::collection(
            auth()->user()->urls()->latest()->paginate()
        );
    }

    /**
     * Store a new shortened URL resource.
     *
     * Creates a new URL if the user is authorized and has not exceeded the creation limit.
     * If unauthorized or limit exceeded, a JSON response with an error message is returned.
     *
     * @param StoreUrlRequest $request The validated request containing URL data to store.
     * @return \Illuminate\Http\JsonResponse|UrlResource JSON response for unauthorized access,
     * or the newly created URL resource.
     */
    public function store(StoreUrlRequest $request)
    {
        if ($this->isAble('createV2', new Url())) {
            return new UrlResource((new UrlService())->firstOrCreate($request));
        }
        return $this->unAuthorize('Limit exceed! You can create maximum ' . config('app.url_creation_max_limit') . ' shorten url.');
    }

    /**
     * Display the specified shortened URL resource.
     *
     * Returns the URL resource if the user is authorized to view it. Otherwise,
     * returns a JSON response with an unauthorized message.
     *
     * @param Url $url The URL model instance to display.
     * @return \Illuminate\Http\JsonResponse|UrlResource JSON response for unauthorized access,
     * or the requested URL resource.
     */
    public function show(Url $url)
    {
        if ($this->isAble('view', $url)) {
            return new UrlResource($url);
        }
        return $this->unAuthorize('You are not authorized to see this resource.');
    }

    /**
     * Updates the specified shortened URL resource.
     *
     * Update the URL with the provided request data.
     * Returns an updated URL resource upon success. If the user is not authorized
     * to update the URL, a JSON response with an unauthorized message is returned.
     *
     * @param UpdateUrlRequest $request The validated request containing updated URL data.
     * @param Url $url The URL model instance to be updated.
     * @return \Illuminate\Http\JsonResponse|UrlResource JSON response for unauthorized access,
     * or the updated URL resource.
     */
    public function update(UpdateUrlRequest $request, Url $url)
    {
        if ($this->isAble('update', $url)) {
            return new UrlResource((new UrlServiceV2())->updateOrCreate($request, $url));
        }
        return $this->unAuthorize('You are not authorized to update the url resource.');
    }

    /**
     * Deletes the specified shortened URL resource.
     *
     * If the URL is associated with more than one user, it will detach the
     * authenticated user from the URL instead of deleting the resource entirely.
     * Otherwise, it deletes the URL from the database.
     *
     * @param \App\Models\Url $url The URL model instance to delete.
     * @return mixed|\Illuminate\Http\JsonResponse JSON response indicating success or failure.
     */
    public function destroy(Url $url)
    {
        if ($this->isAble('delete', $url)) {
            if ($url->users->pluck('id')->count() > 1) {
                $url->users()->detach(auth()->id());
            } else {
                $url->delete();
            }
            return $this->ok('Successfully Deleted the shorten url');
        }
        return $this->unAuthorize('You are not authorized to delete the url resource.');
    }
}
