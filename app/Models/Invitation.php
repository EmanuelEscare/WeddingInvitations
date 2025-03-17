<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Invitation extends Model
{
    use HasUuids;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'age_group'
    ];

    protected $appends = [
        'invitation_url'
    ];

    public function guests()
    {
        return $this->hasMany(Guest::class, 'invitation_id', 'id');
    }

    public function getInvitationUrlAttribute()
    {
        return url($this->id);
    }
}
