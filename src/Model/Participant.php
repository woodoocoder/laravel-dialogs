<?php
namespace Woodoocoder\LaravelDialogs\Model;

use Illuminate\Database\Eloquent\Relations\Pivot;

class Participant extends Pivot {
    
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'participants';

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at', 'last_seen'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'dialog_id',
        'user_id',
        'subject'
    ];

    public function __construct(array $attributes = []) {
        $this->table = config('woodoocoder.dialogs.table_prefix').$this->table;
        parent::__construct($attributes);
    }

    /**
     * Dialog relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function dialog() {
        return $this->hasOne(Dialog::class, 'dialog_id', 'id');
    }

    /**
     * User relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user() {
        return $this->belongsTo(config('woodoocoder.dialogs.user_model'), 'user_id');
    }
}