<?php

namespace Elnooronline\Notifications\Entities\Concerns;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

interface HasFcmTokens
{
    public function tokens(): MorphMany;

    public function addFcmToken(array $data): Model;
}
