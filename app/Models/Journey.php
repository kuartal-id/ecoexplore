<?php

namespace App\Models;

use App\Models\Concerns\HasTranslations;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Journey extends Model
{
    use HasTranslations;

    public const CATEGORIES = ['dive', 'trek', 'highland', 'geotour', 'food', 'culture'];

    protected array $translatable = ['title', 'tagline', 'summary', 'description', 'itinerary', 'includes', 'excludes', 'impact'];

    protected $guarded = ['id'];

    protected function casts(): array
    {
        return [
            'is_published' => 'boolean',
            'is_featured' => 'boolean',
            'price_idr' => 'integer',
            'duration_days' => 'integer',
            'duration_nights' => 'integer',
        ];
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query->where('is_published', true);
    }

    /** "2D/1N" style label, or "1 day". */
    public function durationLabel(): string
    {
        if ($this->duration_days <= 1 && $this->duration_nights === 0) {
            return __('ui.duration.one_day');
        }

        return __('ui.duration.days_nights', ['d' => $this->duration_days, 'n' => $this->duration_nights]);
    }

    public function purpose(): string
    {
        return 'tour';
    }
}
