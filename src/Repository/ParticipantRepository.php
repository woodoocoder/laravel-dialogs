<?php

namespace Woodoocoder\LaravelDialogs\Repository;

use Woodoocoder\LaravelDialogs\Model\Dialog;
use Woodoocoder\LaravelDialogs\Model\Participant;

class ParticipantRepository extends Repository {
    
    /**
     * ParticipantRepository constructor.
     * 
     * @param Participant $participant
     */
    public function __construct(Participant $participant) {
        parent::__construct($participant);
    }

    public function getByDialog(Dialog $dialog, int $perPage = 20, string $orderBy = 'id', string $sortBy = 'desc') {
        return $this->model->where('dialog_id', $dialog->id)
            ->orderBy($orderBy, $sortBy)->paginate($perPage);
    }
}
