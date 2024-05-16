<?php

namespace Elnooronline\Notifications\Services\Providers;

use Elnooronline\Notifications\Services\ProviderConfig;
use Elnooronline\Notifications\Services\Providers\Notifications\FirebaseNotification;
use Elnooronline\Notifications\Services\Providers\Traits\HasMagicCall;
use Illuminate\Support\Arr;
use NotificationChannels\Fcm\FcmMessage;

class FirebaseProvider extends Provider
{
    use HasMagicCall;

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
     * @var FcmMessage
     */
    private FcmMessage $fcmMessage;

    protected $notification = FirebaseNotification::class;

    /**
     * @param ProviderConfig|null $config
     */
    public function __construct(ProviderConfig $config = null)
    {
        parent::__construct($config);

        $this->fcmMessage = new FcmMessage();
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
    public function toArray(): array
    {
        $data = Arr::except($this->data, ['config']);

        return array_merge([
            'title' => $this->title,
            'body' => $this->body,
            'image' => $this->image,
            'fcmMessage' => $this->fcmMessage,
        ], $data);
    }
}
