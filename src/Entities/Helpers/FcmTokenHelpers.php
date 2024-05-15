<?php

namespace Elnooronline\Notifications\Entities\Helpers;

use PHLAK\SemVer\Version;

trait FcmTokenHelpers
{
    /**
     * Determine whether the token is expired.
     *
     * @return boolean
     */
    public function isExpired(): bool
    {
        return $this->expires_at->lt(now());
    }

    /**
     * Determine whether token created in outdated version.
     *
     * @param string $version
     * @return bool
     */
    public function isOutdated(string $version): bool
    {
        return $this->version && $this->version->lt(Version::parse($version));
    }

    /**
     * Extend expiry date of a token.
     *
     * @return void
     */
    public function extendExpireAt(): void
    {
        $interval = \DateInterval::createFromDateString(config('elnooronline-notifications.extend_interval'));

        $this->forceFill([
            'expire_at' => $this->expire_at->add($interval),
        ]);
    }
}
