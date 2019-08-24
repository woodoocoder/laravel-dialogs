<?php
namespace Woodoocoder\LaravelDialogs\Model\Message;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Actions extends Model {
    
    use SoftDeletes;
    
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'message_actions';

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'message_id',
        'user_id',
        'is_seen',
        'is_deleted',
    ];

    public function __construct(array $attributes = []) {
        $this->table = config('woodoocoder.dialogs.table_prefix').$this->table;
        parent::__construct($attributes);
    }
}