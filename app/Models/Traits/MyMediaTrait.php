<?php

namespace App\Models\Traits;

use App\Models\Event;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\FileAdder;
use Spatie\MediaLibrary\MediaCollections\MediaCollection;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

/**
 * Trait RequestMediaTrait
 *
 * @mixin Model
 */
trait MyMediaTrait
{
    use InteractsWithMedia;

    /**
     * Auto attach media via request
     */
    public function getRequestMediaTrait(Event $model)
    {

            $model->registerMediaCollections();

            collect($model->mediaCollections)->each(function (MediaCollection $collection) use ($model) {
                /**
                 * Media to delete
                 */
                $ids = request()->input("{$collection->name}_delete");
                $model->getMedia($collection->name)->filter(function (Media $media) use ($ids) {
                    return in_array($media->id, is_array($ids) ? $ids : [$ids], false);
                })->each->delete();

                /**
                 * Media to add
                 */
                if (request()->hasFile($collection->name)) {
                    $model->addMultipleMediaFromRequest([$collection->name])
                        ->each(function (FileAdder $file) use ($collection) {
                            $file->toMediaCollection($collection->name);
                        });
                }
            });
    }

}
