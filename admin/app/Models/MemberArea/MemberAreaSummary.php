<?php

namespace Admin\App\Models\MemberArea;

use Admin\App\Models\Masters\CountryMaster;
use Admin\App\Models\Masters\State;
use Admin\App\Models\MemberArea\MemberActivity;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class MemberAreaSummary extends Model
{
    protected $table = 'ihook_members_table';
    protected $primaryKey = 'members_id';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

protected $fillable = [
    'members_id', 'members_username', 'members_firstname', 'members_lastname',
    'members_email', 'members_phone', 'members_dob', 'members_doj',
    'members_address', 'members_address2', 'members_address3',
    'members_city', 'members_state', 'members_country', 'members_zip',
    'members_ip_address', 'members_status', 'members_subdomain',
    'members_ssn_number', 'members_company_name',
    'members_password',
];
    protected $casts = [
        'members_doj' => 'date:Y-m-d',    
        'members_dob' => 'date:Y-m-d',
    ];
    public function country()
    {
        return $this->belongsTo(
            CountryMaster::class,
            'members_country',        // foreign key on members table
            'country_master_id'       // primary key on country table
        );
    }

    // FIX 2: Same for state
    public function state()
    {
        return $this->belongsTo(
            State::class,
            'members_state',
            'state_id'
        );
    }

    public function activities()
    {
        return $this->hasMany(
            MemberActivity::class,
            'members_log_members_id',
            'members_id'
        );
    }
    public function personalPurchases()
    {
        return $this->hasMany(MemberPersonalPurchase::class, 'members_id', 'members_id'); // adjust table/columns
    }
        public function member()
    {
        return $this->belongsTo(MemberAreaSummary::class, 'history_member_id', 'members_id');
    }
     // Accessors for Blade
    public function getFormattedDateAttribute()
    {
        return Carbon::parse($this->history_datetime)->format('d M Y');
    }

    public function getFormattedAmountAttribute()
    {
        return number_format($this->history_amount, 2);
    }
}