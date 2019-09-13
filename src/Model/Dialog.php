<?php
namespace Woodoocoder\LaravelDialogs\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\User;

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
        $tablePrefix = config('woodoocoder.dialogs.table_prefix');

        return $this->belongsToMany(config('woodoocoder.dialogs.user_model'),
                $tablePrefix.'participants', 'dialog_id', 'user_id')
                ->withPivot('subject', 'unread_messages');
    }

    /**
     * Messages relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function messages() {
        return $this->hasMany(Message::class, 'dialog_id', 'id');
    }

    /**
     * Participants relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function participants() {
        $tablePrefix = config('woodoocoder.dialogs.table_prefix');
        return $this->hasMany(Participant::class, 'dialog_id', 'id');
    }

    /**
     * Checks to see if a user is a current participant of the dialog.
     *
     * @param int $userId
     *
     * @return bool
     */
    public function hasParticipant($userId) {
        $participants = $this->participants()->where('user_id', '=', $userId)->get();
        return $participants;
    }
    

    /**
     * Returns the latest message from a Dialog.
     *
     * @return null|Woodoocoder\LaravelDialogs\Model\Message
     */
    public function latestMessage(){
        return $this->messages()->latest()->first();
    }


}