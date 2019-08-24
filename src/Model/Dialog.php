<?php
namespace Woodoocoder\LaravelDialogs\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Dialog extends Model {
    
    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'dialogs';

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
        'subject'
    ];

    public function __construct(array $attributes = []) {
        $this->table = config('woodoocoder.dialogs.table_prefix').$this->table;
        parent::__construct($attributes);
    }

    /**
     * Users relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users() {
        return $this->belongsToMany(\App\User::class, Participant::class, 'dialog_id', 'user_id');
    }

    /**
     * Messages relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function messages() {
        return $this->hasMany(Message::class, 'dialog_id', 'id');
    }
}