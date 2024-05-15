<?php

namespace Elnooronline\Notifications\Entities;

use Elnooronline\Notifications\Entities\Casts\SemVerCasts;
use Elnooronline\Notifications\Entities\Helpers\FcmTokenHelpers;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class FcmToken extends Model
{
    use FcmTokenHelpers;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'model_id',
        'model_type',
        'token',
        'device_name',
        'version',
        'expire_at',
    ];

    /**
     * @var string[]
     */
    protected $casts = [
        'expire_at' => 'datetime',
        'version' => SemVerCasts::class,
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function model()
    {
        return $this->morphTo('model');
    }

    /**
     * Query only expired entities.
     *
     * @param Builder $builder
     * @return void
     */
    public function scopeExpiredOnly(Builder $builder)
    {
        $builder->whereDate('expire_at', '<', now());
    }

    /**
     * Query only active entities.
     *
     * @param Builder $builder
     * @return void
     */
    public function scopeNotExpiresOnly(Builder $builder)
    {
        $builder->whereDate('expire_at', '>=', now());
    }
}
