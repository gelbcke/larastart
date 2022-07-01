<?php

namespace App\Models;

use Spatie\Permission\Models\Permission as SpatiePermission;
use App\Traits\Uuids;

class Permission extends SpatiePermission
{
    use Uuids;

    protected $primaryKey = 'id';

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * The "type" of the primary key ID.
     *
     * @var string
     */
    protected $keyType = 'string';

    /**
     * Default Permissions of the Application.
     */
    public static function defaultPermissions()
    {
        return [
            'users-list',
            'users-create',
            'users-edit',
            'users-activate',
            'users-deactivate',

            'roles-list',
            'roles-create',
            'roles-edit',
            'roles-delete',

            'permissions-list',
            'permissions-create',
            'permissions-edit',
            'permissions-delete',

            'logs-list',
            'logs-clear',

            'settings-list',
            'settings-update',
        ];
    }

    /**
     * Name should be lowercase.
     *
     * @param  string  $value  Name value
     */
    public function setNameAttribute($value)
    {
        $this->attributes['name'] = strtolower($value);
    }
}
