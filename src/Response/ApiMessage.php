<?php

namespace Woodoocoder\LaravelDialogs\Response;

use Illuminate\Http\Response;
use Illuminate\Http\Resources\Json\JsonResource;
use Woodoocoder\LaravelDialogs\Response\ApiStatus;
use Woodoocoder\LaravelDialogs\Resources\ApiResourceTrait;

class ApiMessage extends JsonResource {

    use ApiResourceTrait;

    /**
     * @param string $status
     */
    public function __construct(string $status = ApiStatus::SUCCESS) {
        parent::__construct(null);

        $this->status = $status;
    }
}
