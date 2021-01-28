<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NewsGroup extends Model
{
	protected $table = 'news_groups';

	/**
	 * [getNewsGroups description]
	 * @param  array  $data [description]
	 * @return [type]       [description]
	 */
	public static function getNewsGroups(array $data)
    {
    	$query = self::select('id', 'father_id', 'newsgroupname');

        return [
            'total' => $query->count(),
            'data'  => $query->get()
                             ->toArray()
        ];
    }
}
