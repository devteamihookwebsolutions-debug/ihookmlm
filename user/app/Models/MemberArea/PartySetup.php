<?php

namespace User\App\Models\MemberArea;

use Illuminate\Database\Eloquent\Model;

class PartySetup extends Model
{
    protected $table = 'ihook_party_setup';   // your table name
    public $timestamps = false;               // no created_at/updated_at
    protected $primaryKey = 'id';
    public $incrementing = true;

    protected $fillable = [
        'setup_party_id', 'setup_name', 'setup_value', 'status'
    ];
}