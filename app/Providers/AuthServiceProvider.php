<?php

namespace App\Providers;

use App\Models\Cases\CaseEntity;
use App\Models\Client;
use App\Models\User;
use App\Models\UserWithdrawal;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected           $policies        = [

    ];
    public static array $userPermissions = [];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('policy', function (User $user, $permission) {
            if ($user) {
                $exp = explode('|', $permission);
                if (count($exp) > 1) {
                    $isAccess = false;
                    foreach ($exp as $value) {
                        if (Gate::allows('policy', trim($value))) {
                            $isAccess = true;
                        }
                    }
                    return $isAccess;
                }
                $args       = explode(',', $permission);
                $permission = $args[0];
                $uid        = $args[1] ?? null;
                $perms      = self::$userPermissions[$user->id] ?? null;
                if ($perms === null || count($perms) === 0) {
                    self::$userPermissions[$user->id] = [];
                    foreach ($user->roles()->with('permissions')->get() as $item) {
                        foreach ($item->permissions as $value) {
                            if (!in_array($value->guard_name,
                                self::$userPermissions[$user->id], true)) {
                                self::$userPermissions[$user->id][] = $value->guard_name;
                            }
                        }
                    }
                }
                return isset(self::$userPermissions[$user->id]) && in_array($permission,
                        self::$userPermissions[$user->id],
                        true) && ($uid === null || (int) $user->id === (int) $uid);
            }

            return false;
        });
    }
}
