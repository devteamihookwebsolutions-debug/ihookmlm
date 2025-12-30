<?php

namespace Admin\App\Models\CustomerBonus;

use Illuminate\Database\Eloquent\Model;

class CustomerBonus extends Model
{
    protected $table = 'ihook_customerbonus_meta';
    protected $primaryKey = 'meta_id';
    public $timestamps = true;

    protected $fillable = [
        'meta_key',
        'meta_value',
        'created_on',
        'updated_on',
    ];

    // Define timestamps fields explicitly
    const CREATED_AT = 'created_on';
    const UPDATED_AT = 'updated_on';

    /**
     * Get bonus details as an associative array
     */
    public static function getBonusDetails()
    {
        $records = self::all()->pluck('meta_value', 'meta_key')->toArray();
        return $records;
    }

    /**
     * Update or create bonus details
     */
    public static function updateBonusDetails(array $data)
    {
        foreach ($data as $key => $value) {
            self::updateOrCreate(
                ['meta_key' => $key],
                [
                    'meta_value' => $value,
                    'updated_on' => now(),
                ]
            );
        }
    }
}