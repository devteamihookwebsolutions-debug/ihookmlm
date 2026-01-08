<?php
namespace Admin\App\Models\Member;

use Illuminate\Database\Eloquent\Model;

class NewsletterTemplate extends Model
{
    // Dynamically set table name using prefix from config
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $prefix = config('services.ihook.prefix'); 
        $this->table = $prefix . '_newsletter_buildertemplate_table';
    }

    protected $primaryKey = 'category_templates_id'; 
    public $timestamps = false; 
    protected $fillable = [
        'created_by',
        'user_type',
        'category_templates_name', 
    ];
}
