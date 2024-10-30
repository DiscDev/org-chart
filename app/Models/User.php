<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    protected $fillable = [
        'username',
        'email_work',
        'email_personal',
        'password',
        'first_name',
        'last_name',
        'start_date',
        'end_date',
        'phone_number',
        'profile',
        'activities',
        'job_title',
        'job_description',
        'timezone_id',
        'location',
        'manager_id',
        'photo_url',
        'agency_id',
        'salary',
        'salary_including_agency_fees',
        'bonus_structure',
        'slack',
        'skype',
        'telegram',
        'whatsapp',
        'user_type_id',
        'created_by',
        'updated_by',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'salary' => 'decimal:2',
        'salary_including_agency_fees' => 'decimal:2',
    ];

    public function timezone(): BelongsTo
    {
        return $this->belongsTo(Timezone::class);
    }

    public function manager(): BelongsTo
    {
        return $this->belongsTo(User::class, 'manager_id');
    }

    public function subordinates(): HasMany
    {
        return $this->hasMany(User::class, 'manager_id');
    }

    public function agency(): BelongsTo
    {
        return $this->belongsTo(Agency::class);
    }

    public function userType(): BelongsTo
    {
        return $this->belongsTo(UserType::class);
    }

    public function offices(): BelongsToMany
    {
        return $this->belongsToMany(Office::class, 'users_offices');
    }

    public function departments(): BelongsToMany
    {
        return $this->belongsToMany(Department::class, 'users_departments');
    }

    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'users_roles');
    }

    public function teams(): BelongsToMany
    {
        return $this->belongsToMany(Team::class, 'users_teams');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function editor()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function getFullNameAttribute(): string
    {
        return "{$this->first_name} {$this->last_name}";
    }

    public function hasPermission(string $permission): bool
    {
        return $this->userType->permissions->contains('name', $permission);
    }
}