<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use Notifiable, HasRoles;


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'lastname',
        'email',
        'password',
        'plane_hours',
        'week_hours',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    protected $hidden = [
        'password', 'remember_token',
    ];

    public function report()
    {
        return $this->hasMany(Report::class)->orderByDesc('created_at');
    }

    /**
     * @param $notification
     * @return string
     */
    public function routeNotificationForSlack($notification)
    {
        return 'https://hooks.slack.com/services/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';
    }
}
