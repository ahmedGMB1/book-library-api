<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BookResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'isbn' => $this->isbn,
            'publisher' => $this->publisher,
            'year' => $this->year,
            'coverImage' => $this->cover_image,
            'summary' => $this->summary,
            'authorId' => $this->author_id,
            'createdAt' => $this->created_at->toDateTimeString(),
            'updatedAt' => $this->updated_at->toDateTimeString(),
            'author' => new AuthorResource($this->whenLoaded('author')),
        ];
    }
}

