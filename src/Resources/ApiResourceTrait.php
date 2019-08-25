<?php

namespace Woodoocoder\LaravelDialogs\Resources;

use Woodoocoder\LaravelDialogs\Response\ApiStatus;

trait ApiResourceTrait {
    
    /**
     * @var string
     */
    protected $status;

    /**
     * ApiCollection constructor.
     * 
     * @param $resource
     * @param string $status
     */
    public function __construct($resource, string $status = ApiStatus::SUCCESS) {
        parent::__construct($resource);

        $this->status = $status;
    }

    /**
     * Get additional data that should be returned with the resource array.
     *
     * @param  \Illuminate\Http\Request $request
     * 
     * @return array
     */
    public function with($request): array {
        return [
            'status' => $this->status
        ];
    }
}
