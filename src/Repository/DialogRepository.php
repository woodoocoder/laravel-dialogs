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
}
