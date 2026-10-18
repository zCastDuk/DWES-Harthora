<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['client_id', 'property_id', 'agent_id', 'date', 'time_slot', 'status'])]
class Visit extends Model{
    use HasFactory;

    protected function casts(): array{
        return [
            'date' => 'date',
        ];
    }

    public function client(): BelongsTo{
        return $this->belongsTo(Client::class);
    }

    public function property(): BelongsTo{
        return $this->belongsTo(Property::class);
    }

    public function agent(): BelongsTo{
        return $this->belongsTo(Agent::class);
    }
}
