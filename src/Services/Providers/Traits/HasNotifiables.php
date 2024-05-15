<?php

namespace Elnooronline\Notifications\Services\Providers\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Collection;

trait HasNotifiables
{
    /**
     * @param $notifiable
     * @return $this
     */
    public function notifiable($notifiable)
    {
        if (is_array($notifiable)) {
            $this->mergeArray($notifiable);
        } elseif ($notifiable instanceof Collection) {
            $this->mergeIfCollection($notifiable);
        } else {
            $this->mergeSingle($notifiable);
        }

        return $this;
    }

    /**
     * @return array
     */
    public function getNotifiables()
    {
        return $this->notifiables;
    }

    /**
     * @param $notifiable
     * @return void
     */
    private function mergeArray(array $notifiable)
    {
        $this->notifiables = array_merge(
            array_filter(
                $notifiable,
                fn ($model) => $this->isNotifiable($model)
            ),
            $this->notifiables
        );
    }

    /**
     * @param Collection $notifiable
     * @return void
     */
    private function mergeIfCollection(Collection $notifiable)
    {
        $this->mergeIfArray($notifiable->toArray());
    }

    /**
     * @param Model $notifiable
     * @return void
     */
    private function mergeSingle(Model $notifiable)
    {
        if (! $this->isNotifiable($notifiable)) {
            return;
        }

        $this->notifiables[] = $notifiable;
    }

    /**
     * @param Model $model
     * @return bool
     */
    private function isNotifiable(Model $model)
    {
        return in_array(
            Notifiable::class,
            array_keys((new \ReflectionClass($model))->getTraits())
        );
    }
}
