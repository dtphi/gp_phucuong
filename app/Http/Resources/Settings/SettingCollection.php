<?php

namespace App\Http\Resources\Settings;

use Illuminate\Http\Resources\Json\ResourceCollection;

class SettingCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $results = [];
        foreach($this->collection as $setting) {
            $value = ($setting->serialized) ? unserialize($setting->value): $setting->value;

            $results[$setting->key_data] = [
                'key' => $setting->key_data,
                'serialize' => $setting->serialized,
                'value' => $value
            ];
        }

        $code = 'module_category_icon_side_bar';

        return [
            'code' => $code,
            'results' => $results,
            'errors'  => [],
            'status'  => 1000
        ];
    }
}
