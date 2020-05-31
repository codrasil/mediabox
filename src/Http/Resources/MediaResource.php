<?php

namespace Codrasil\Mediabox\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MediaResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        $attributes = array_merge(parent::toArray($request), [
            'url' => $this->isDir() ? false : route(
                config('mediabox.routes.storage.name').'.show',
                $this->filename()
            ),
        ]);

        if ($request->has('columns')) {
            $columns = explode(',', $request->get('columns') ?? '');
            $attributes = collect($attributes)->filter(function ($column, $key) use ($columns) {
                return in_array($key, $columns);
            })->toArray();
        }

        return $attributes;
    }
}
