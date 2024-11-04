<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UrlResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'type' => 'url',
            'id' => $this->id,
            'attributes' => [
                'longUrl' => $this->longUrl,
                'shortUrl' => $this->shortUrl,
                'createdAt' => $this->created_at,
                'updatedAt' => $this->updated_at,
            ],
            'relationships' => [
                'user' => [
                    'data' => [
                        'type' => 'user',
                        'id' => $this->user_id
                    ]
                ]
            ],
            'links' => [
                'self' => [
                    route('urls.show', ['url' => $this->id])
                ]
            ]
        ];
    }
}
