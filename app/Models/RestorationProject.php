<?php

namespace App\Models;

use App\Models\Concerns\HasTranslations;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class RestorationProject extends Model
{
    use HasTranslations;

    public const TYPES = ['coral', 'mangrove', 'forest'];

    protected array $translatable = ['title', 'summary', 'description', 'unit_label'];

    protected $guarded = ['id'];

    protected function casts(): array
    {
        return [
            'is_published' => 'boolean',
            'unit_price_idr' => 'integer',
            'target_units' => 'integer',
            'funded_units' => 'integer',
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

    public function progressPercent(): int
    {
        if ($this->target_units <= 0) {
            return 0;
        }

        return (int) min(100, round($this->funded_units / $this->target_units * 100));
    }

    public function purpose(): string
    {
        return 'restoration';
    }
}
