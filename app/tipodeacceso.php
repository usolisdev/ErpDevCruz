<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $tipoacceso
 * @property string $created_at
 * @property string $updated_at
 * @property User[] $users
 */
class tipodeacceso extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'tipodeacceso';

    /**
     * @var array
     */
    protected $fillable = ['tipoacceso', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function users()
    {
        return $this->hasMany('App\User', 'tipoacceso');
    }
}
