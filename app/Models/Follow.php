<?php

namespace App\Models;

use App\Support\HasAdvancedFilter;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use \DateTimeInterface;

class Follow extends Model
{
    use HasAdvancedFilter, SoftDeletes, HasFactory;

    public $table = 'follows';

    protected $appends = [
        'is_following_label',
    ];

    protected $orderable = [
        'id',
        'follewer',
        'is_following',
    ];

    protected $filterable = [
        'id',
        'follewer',
        'is_following',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'follewer',
        'is_following',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    const IS_FOLLOWING_RADIO = [
        [
            'label' => 'true',
            'value' => 'true',
        ],
        [
            'label' => 'false',
            'value' => 'false',
        ],
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function getIsFollowingLabelAttribute()
    {
        return collect(static::IS_FOLLOWING_RADIO)->firstWhere('value', $this->is_following)['label'] ?? '';
    }
}
