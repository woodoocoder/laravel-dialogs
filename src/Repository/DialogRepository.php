<?php

namespace Woodoocoder\LaravelDialogs\Repository;

use Woodoocoder\LaravelDialogs\Model\Dialog;
use App\User;

class DialogRepository extends Repository {
    
    /**
     * DialogRepository constructor.
     * 
     * @param Dialog $dialog
     */
    public function __construct(Dialog $dialog) {
        parent::__construct($dialog);
    }

    /**
     * @param int $userId
     * @param int $perPage
     * 
     * @return LengthAwarePaginator
     */
    public function paginateByUser(int $userId, int $perPage = 20, string $orderBy = 'id', string $sortBy = 'desc') {
        $tablePrefix = config('woodoocoder.dialogs.table_prefix');

        return $this->model
            ->join($tablePrefix.'participants',
                $tablePrefix.'dialogs'.'.id', '=',
                $tablePrefix.'participants' . '.dialog_id')
            ->where($tablePrefix.'participants'.'.user_id', $userId)
            ->whereNull($tablePrefix.'dialogs'.'.deleted_at')
            ->select($tablePrefix.'dialogs.*')
            ->orderBy($tablePrefix.'dialogs'.'.updated_at', $sortBy)->paginate($perPage);
    }


    /**
     * @param array $attributes
     * 
     * @return mixed
     */
    public function createDialog(int $userId, array $attributes) {
        $tablePrefix = config('woodoocoder.dialogs.table_prefix');

        $participants = $attributes['participants'];
        $participants[] = $userId;
        
        $dialog = $this->model->select('id')->whereHas('participants', function($q) use ($participants) {
            $q->whereIn('user_id', $participants)
                ->distinct()
                ->select('dialog_id')
                ->groupBy('dialog_id')
                ->havingRaw('COUNT(dialog_id)='.count($participants));
        })->first();

        if(!$dialog) {
            $dialog = $this->model->create();
            
            $i=0;
            $reversedParticipants = array_reverse($participants);
            foreach ($participants as $id) {
                $user = User::find($reversedParticipants[$i]);
                $dialog->users()->attach($id, ['subject' => $user->firstname]);

                $i++;
            }
        }

        return $dialog;
    }
    
}
