<?php

namespace Woodoocoder\LaravelDialogs\Repository;

use Woodoocoder\LaravelDialogs\Model\Dialog;

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
    public function create(array $attributes) {

        return $this->model->create($attributes);
    }
    
}
