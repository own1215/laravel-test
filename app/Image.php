<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Image
 */
class Image extends Model
{
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users()
    {
        return $this->belongsToMany(User::class, 'user_image');
    }

    /**
     * @param $value
     *
     * @return \Illuminate\Contracts\Routing\UrlGenerator|string
     */
    public function getPathAttribute($value)
    {
        return url('storage/' . $value);
    }
}
