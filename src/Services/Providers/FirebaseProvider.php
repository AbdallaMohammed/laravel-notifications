<?php

namespace Elnooronline\Notifications\Services\Providers;

use Elnooronline\Notifications\Services\Interfaces\NotificationProvider;
use Elnooronline\Notifications\Services\ProviderConfig;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Arr;
use NotificationChannels\Fcm\FcmChannel;
use NotificationChannels\Fcm\FcmMessage;
use NotificationChannels\Fcm\Resources\Notification as FcmNotification;

class FirebaseProvider extends Provider implements NotificationProvider, ShouldQueue
{
    /**
     * @var string
     */
    private string $title = '';

    /**
     * @var string
     */
    private string $body = '';

    /**
     * @var string
     */
    private string $image = '';

    /**
     * @var array
     */
    private array $fcmData = [];

    /**
     * @var array
     */
    private array $fcmCustom = [];

    private FcmMessage $fcmMessage;

    /**
     * @param ProviderConfig|null $config
     */
    public function __construct(ProviderConfig $config = null)
    {
        parent::__construct($config);

        $this->fcmMessage = new FcmMessage();
    }

    /**
     * @return string
     */
    public function channel()
    {
        return FcmChannel::class;
    }

    /**
     * Set notification title.
     *
     * @param string|\Closure $title
     * @return $this
     */
    public function title($title)
    {
        $this->title = value($title, $this);

        return $this;
    }

    /**
     * Set notification body.
     *
     * @param string|\Closure $title
     * @return $this
     */
    public function body($body)
    {
        $this->body = value($body, $this);

        return $this;
    }

    /**
     * Set notification image.
     *
     * @param string|\Closure $title
     * @return $this
     */
    public function image($image)
    {
        $this->image = value($image, $this);

        return $this;
    }

    /**
     * Retrieve stored data.
     *
     * @return array
     */
    public function getData(): array
    {
        $data = Arr::except($this->data, ['config']);

        return array_merge([
            'title' => $this->title,
            'body' => $this->body,
            'image' => $this->image,
            'data' => $this->fcmData,
            'custom' => $this->fcmCustom,
        ], $data);
    }

    /**
     * @return FcmMessage
     * @throws \NotificationChannels\Fcm\Exceptions\CouldNotSendNotification
     */
    public function toFcm()
    {
        return $this->fcmMessage->setNotification(
            (new FcmNotification())
                ->setTitle($this->title)
                ->setImage($this->image)
                ->setBody($this->body)
        );
    }

    /**
     * @param string $method
     * @param array $args
     * @return mixed
     * @throws \Elnooronline\Notifications\Services\Exceptions\InvalidMethodException
     */
    public function __call(string $method, array $args)
    {
        if (method_exists($this, $method)) {
            return $this->{$method}(...$args);
        }

        if (method_exists($this->fcmMessage, $method)) {
            return $this->fcmMessage->{$method}(...$args);
        }

        return parent::__call($method, $args);
    }
}
