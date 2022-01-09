<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Okami101\LaravelAdmin\Traits\RequestMediaTrait;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\Translatable\HasTranslations;

class Monster extends Model implements HasMedia
{
    use HasTranslations , HasFactory ,RequestMediaTrait;

    protected $fillable = ['name', 'email', 'label', 'active', 'level', 'rating', 'price', 'description', 'body', 'category', 'tags', 'publication_date'];

    protected $casts = ['active' => 'boolean', 'level' => 'integer', 'rating' => 'integer', 'price' => 'float', 'tags' => 'array'];

    public $translatable = ['label', 'description', 'body'];

    protected function getLocale(): string
    {
        return request()->header('locale') ?: app()->getLocale();
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('avatar')->singleFile();
        $this->addMediaCollection('images');
        $this->addMediaCollection('files');
    }

    public function registerMediaConversions(Media $media = null): void
    {
        //
    }

    public function children()
    {
        return $this->hasMany(MonsterChild::class);
    }
}
