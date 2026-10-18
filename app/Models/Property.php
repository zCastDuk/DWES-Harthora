<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['owner_id','agent_id','zone_id',
            'title','description', 'type',
            'price','bedrooms', 'bathrooms',
            'usable_area', 'built_area', 'address',
            'postal_code', 'status', 'is_exclusive',
            'portfolio_entry_date', 'published_at',])]
class Property extends Model{
    use HasFactory;

    protected function casts(): array{
        return [
            'price' => 'decimal:2',
            'usable_area' => 'decimal:2',
            'built_area' => 'decimal:2',
            'is_exclusive' => 'boolean',
            'portfolio_entry_date' => 'date',
            'published_at' => 'datetime',
        ];
    }

    public function owner(): BelongsTo{
        return $this->belongsTo(Owner::class);
    }

    public function agent(): BelongsTo{
        return $this->belongsTo(Agent::class);
    }

    public function zone(): BelongsTo{
        return $this->belongsTo(Zone::class);
    }

    public function features(): BelongsToMany{
        return $this->belongsToMany(Feature::class)
            ->withPivot('detail', 'estimated_value')
            ->withTimestamps();
    }

    public function favoritedBy(): BelongsToMany{
        return $this->belongsToMany(Client::class, 'favorites')
            ->withPivot('note', 'price_drop_alert')
            ->withTimestamps();
    }

    public function visits(): HasMany{
        return $this->hasMany(Visit::class);
    }

    public function sales(): HasMany{
        return $this->hasMany(Sale::class);
    }
}
