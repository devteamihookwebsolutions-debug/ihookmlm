<?php

namespace Admin\App\Models\MemberArea;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class MemberAreaWebsite extends Model
{
    protected $table = 'ihook_members_meta_table';
    protected $primaryKey = 'members_meta_id';
    public $timestamps = false;

    protected $fillable = [
        'members_id', 'members_email', 'sec_code', 'meta_key', 'meta_data',
        'created_on', 'created_by', 'updated_on', 'updated_by'
    ];

    public static function getWebsiteDetails($user_id)
    {
        $record = self::where('meta_key', 'website')
            ->where('members_id', $user_id)
            ->first();

        return $record ? json_decode($record->meta_data, true) : [];
    }

    public static function hasWebsiteDetails($user_id)
    {
        return self::where('meta_key', 'website')
            ->where('members_id', $user_id)
            ->exists();
    }

    public static function updateWebsiteDetails($user_id, $data)
    {
        try {
            $meta_data = json_encode([
                'mobile' => $data['mobile'] ?? '',
                'message' => $data['message'] ?? ''
            ], JSON_THROW_ON_ERROR);

            $exists = self::hasWebsiteDetails($user_id);

            if ($exists) {
                $result = self::where('meta_key', 'website')
                    ->where('members_id', $user_id)
                    ->update([
                        'meta_data' => $meta_data,
                        'updated_on' => now(),
                        'updated_by' => auth()->id() ?? $user_id
                    ]);

                Log::info('Website details update attempted', [
                    'user_id' => $user_id,
                    'meta_data' => $meta_data,
                    'result' => $result
                ]);

                return $result > 0;
            } else {
                $result = self::create([
                    'members_id' => $user_id,
                    'members_email' => '',
                    'sec_code' => '',
                    'meta_key' => 'website',
                    'meta_data' => $meta_data,
                    'created_on' => now(),
                    'created_by' => auth()->id() ?? $user_id,
                    'updated_on' => now(),
                    'updated_by' => auth()->id() ?? $user_id
                ]);

                Log::info('Website details create attempted', [
                    'user_id' => $user_id,
                    'meta_data' => $meta_data,
                    'result' => $result ? 'success' : 'failed'
                ]);

                return $result !== null;
            }
        } catch (\Exception $e) {
            Log::error('Error updating website details in database', [
                'user_id' => $user_id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return false;
        }
    }
}