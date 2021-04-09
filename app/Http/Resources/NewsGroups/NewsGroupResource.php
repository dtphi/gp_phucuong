<?php

namespace App\Http\Resources\NewsGroups;

use Illuminate\Http\Resources\Json\JsonResource;

class NewsGroupResource extends JsonResource
{
    /**
     * @var string
     */
    public static $wrap = 'newsgroup';

    /**
     * @author : dtphi .
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return $this->__getJsonResource();
    }

    /**
     * @author : dtphi .
     * @return array
     */
    private function __getJsonResource()
    {
        return array(
            'category_id'   => $this->resource->category_id,
            'parent_id'     => $this->resource->parent_id,
            'sort_order'    => $this->resource->sort_order,
            'status'        => $this->resource->status,
            'created_at'    => $this->resource->created_at,
            'category_name' => $this->resource->name,
            'description'   => $this->resource->description,
            'meta_title'    => $this->resource->meta_title,
            'layout_id'     => $this->resource->layout_id,
            'path'          => $this->resource->path
        );
    }
}
