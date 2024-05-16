<?php

namespace Elnooronline\Notifications\Services\Providers\Notifications;

use NotificationChannels\Fcm\FcmChannel;
use NotificationChannels\Fcm\Resources\Notification as FcmNotification;

final class FirebaseNotification extends BaseNotification
{
    /**
     * @return array
     */
    public function via(): array
    {
        return [FcmChannel::class];
    }

    /**
     * @return FcmMessage
     * @throws \NotificationChannels\Fcm\Exceptions\CouldNotSendNotification
     */
    public function toFcm()
    {
        return $this->provider->get('fcmMessage')->setNotification(
            (new FcmNotification())
                ->setTitle($this->provider->get('title'))
                ->setImage($this->provider->get('image'))
                ->setBody($this->provider->get('body'))
        );
    }
}
