<?php

namespace Woodoocoder\LaravelDialogs\Traits; 

use Woodoocoder\LaravelDialogs\Model\Dialog;

trait Messagable {

    /**
     * Dialog relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function dialogs() {
        $tablePrefix = config('woodoocoder.dialogs.table_prefix');
        return $this->belongsToMany(Dialog::class,
                $tablePrefix.'participants', 'user_id', 'dialog_id');
    }

    public function canJoinDialog($dialogId) {
        $dialogs = $this->dialogs()->where('dialog_id', '=', $dialogId)->get();
        return $dialogs->count() > 0 ? true: false;
    }
}

