<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Role;

class Module extends Model
{
    protected $fillable = ['name', 'role_id'];

    public $timestamps = false;
    /**
     * Relación con el modelo Role.
     */
    public function role()
    {
        return $this->belongsTo(Role::class);
    }
}
