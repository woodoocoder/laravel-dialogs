<?php
namespace Woodoocoder\LaravelDialogs\Model\Message;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Woodoocoder\LaravelDialogs\Model\Message;

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
        'seen',
        'deleted',
    ];

    public function __construct(array $attributes = []) {
        $this->table = config('woodoocoder.dialogs.table_prefix').$this->table;
        parent::__construct($attributes);
    }

    /**
     * Message relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\hasOne
     */
    public function dialog() {
        return $this->hasOne(Message::class, 'message_id', 'id');
    }
}