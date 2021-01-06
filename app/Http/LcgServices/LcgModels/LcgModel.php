<?php
/**
 * Created by PhpStorm.
 * User: dell
 * Date: 9/24/2020
 * Time: 4:33 PM
 */

namespace App\Http\LcgServices\LcgModels;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;


class LcgModel extends Model
{
    use Notifiable;

    /**
     * @author : Phi .
     * @param $query
     * @return mixed
     */
    public function scopeOrderByCreatedAtDesc($query)
    {
        return $query->orderBy($this->table . '.created_at', 'DESC');
    }
}
