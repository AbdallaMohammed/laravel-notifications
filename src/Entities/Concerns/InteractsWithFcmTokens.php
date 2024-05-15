<?php

namespace Elnooronline\Notifications\Entities\Concerns;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Arr;

trait InteractsWithFcmTokens
{
    /**
     * @return MorphMany
     */
    public function tokens(): MorphMany
    {
        return $this->morphMany($this->getFcmTokensClass(), 'model');
    }

    /**
     * @return MorphMany
     */
    public function activeTokens(): MorphMany
    {
        return $this->tokens()->notExpiredOnly();
    }

    /**
     * @return MorphMany
     */
    public function expiredTokens(): MorphMany
    {
        return $this->tokens()->expiredOnly();
    }

    /**
     * Store a newly created token.
     *
     * @param array $data
     * @return Model
     */
    public function addFcmToken(array $data): Model
    {
        $data = Arr::only($data, ['token', 'version', 'device_name']);

        $interval = \DateInterval::createFromDateString(config('elnooronline-notifications.expire_interval', '1 day'));

        $token = $this->tokens()->create(array_merge($data, [
            'expire_at' => now()->add($interval)
        ]));

        return $token;
    }

    /**
     * Get active token based on criteria.
     *
     * @param string $token
     * @param string|null $device_name
     * @return Model|MorphMany|\Illuminate\Support\HigherOrderWhenProxy|object|null
     */
    public function getFcmToken(string $token, string $device_name = null)
    {
        return $this->activeTokens()
            ->where('token', $token)
            ->when($device_name, fn ($query) => $query->where('device_name', $device_name))
            ->first();
    }

    /**
     * @return mixed[]
     */
    public function getRegisteredTokens()
    {
        return $this->activeTokens()->pluck('token')->toArray();
    }
}
