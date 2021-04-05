<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Throwable;

/**
 * App\Models\Users
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @method static Builder|BaseAuthModel filter(\App\Models\QueryFilter $filters)
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property string|null $third_name
 * @property string|null $phone
 * @property int|null $country_id
 * @property int|null $city_id
 * @property string|null $street
 * @property string|null $second_name
 * @property string|null $address
 * @property int|null $assigned_user
 * @property int|null $team_id
 * @property string|null $card_number
 * @property float $balance
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property int|null $space_id
 * @method static Builder|User whereAddress($value)
 * @method static Builder|User whereAssignedUser($value)
 * @method static Builder|User whereBalance($value)
 * @method static Builder|User whereCardNumber($value)
 * @method static Builder|User whereCityId($value)
 * @method static Builder|User whereCountryId($value)
 * @method static Builder|User whereDeletedAt($value)
 * @method static Builder|User wherePhone($value)
 * @method static Builder|User whereSecondName($value)
 * @method static Builder|User whereSpaceId($value)
 * @method static Builder|User whereStreet($value)
 * @method static Builder|User whereTeamId($value)
 * @method static Builder|User whereThirdName($value)
 * @property-read User|null $assignedUser
 * @property-read \App\Models\City|null $cityRelation
 * @property-read \App\Models\Country|null $countryRelation
 * @property-read \App\Models\Spaces|null $spaceRelation
 * @property-read \App\Models\Teams|null $teamIdRelation
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Task[] $tasks
 * @property-read int|null $tasks_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Roles[] $roles
 * @property-read int|null $roles_count
 */
class User extends BaseAuthModel
{

    protected $casts = ['email_verified_at' => 'datetime',];
    protected $table = 'users';
    public const CREATED_AT = 'created_at';
    public const UPDATED_AT = 'updated_at';
    protected $hidden = ['password', 'remember_token', 'deleted_at'];
    protected $dates  = ['deleted_at'];

    protected $appends = [];

    public const INBOX  = 'in';
    public const OUTBOX = 'out';

    public static function onCreateOrUpdateEvent($model): void
    {
    }

    public static function boot()
    {
        parent::boot();
        static::created(function ($model) {
            /* if ($model->getOriginal('account_status_id') !== $model->attributes['account_status_id']) {
            } */
        });
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function teamIdRelation()
    {
        return $this->belongsTo(Teams::class,
            'team_id',
            'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function assignedUser(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class,
            'assigned_user',
            'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function countryRelation(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Country::class,
            'country_id',
            'id');
    }
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function roles() : BelongsToMany
    {
        return $this->belongsToMany(
            Roles::class,
            RoleHasUser::class,
            'user_id',
            'role_id'
        );
    }
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function cityRelation(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(City::class,
            'city_id',
            'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function spaceRelation(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Spaces::class,
            'space_id',
            'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function tasks(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Task::class,
            'assigned_user',
            'id');
    }


    /**
     * Restore a soft-deleted model instance.
     *
     * @return bool|null
     */
    public function restore()
    {
        // If the restoring event does not return false, we will proceed with this
        // restore operation. Otherwise, we bail out so the developer will stop
        // the restore totally. We will clear the deleted timestamp and save.
        if ($this->fireModelEvent('restoring') === false) {
            return false;
        }

        $this->{$this->getDeletedAtColumn()} = null;

        // Once we have saved the model, we will fire the "restored" event so this
        // developer will do anything they need to after a restore operation is
        // totally finished. Then we will return the result of the save call.
        $this->exists = true;

        $result = $this->save();

        $this->fireModelEvent('restored', false);

        return $result;
    }

    /**
     * @param $userId
     * @param $amount
     * @param $type
     * @throws Throwable
     */

    public static function transferMoney(int $userId, float $amount, string $type): void
    {
        $amount = (float) abs($amount);
        DB::transaction(static function () use ($userId, $amount, $type) {
            $user = self::find($userId);
            if (!$user) {
                throw new \RuntimeException('Пользователь не найден');
            }
            if ($type !== self::OUTBOX && $type !== self::INBOX) {
                throw new \RuntimeException('Тип указан неверно');
            }
            $operation           = new Operations();
            $operation->user_id  = $userId;
            $operation->space_id = $user->space_id;
            if ($type === self::INBOX) {
                $user->balance            += $amount;
                $operation->inbox_finance = $amount;
            } elseif ($type === self::OUTBOX) {
                $user->balance             -= $amount;
                $operation->outbox_finance = $amount;
            }
            $user->save();
            $operation->total_amount = $user->balance;
            $operation->save();
        }, 10);
    }

    public function fullName(): string
    {
        return $this->second_name.' '.$this->name.' '.$this->third_name;
    }


}
