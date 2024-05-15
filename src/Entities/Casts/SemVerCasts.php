<?php

namespace Elnooronline\Notifications\Entities\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use PHLAK\SemVer\Version;

class SemVerCasts implements CastsAttributes
{
    /**
     * @param $model
     * @param string $key
     * @param $value
     * @param array $attributes
     * @return mixed|Version|null
     * @throws \PHLAK\SemVer\Exceptions\InvalidVersionException
     */
    public function get($model, string $key, $value, array $attributes)
    {
        if ($value) {
            return Version::parse($value);
        }

        return $value;
    }

    /**
     * @param $model
     * @param string $key
     * @param $value
     * @param array $attributes
     * @return mixed|null
     */
    public function set($model, string $key, $value, array $attributes)
    {
        return $value;
    }
}
