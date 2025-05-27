<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DataResponse extends JsonResource
{
    private $data;
    private $message;
    private $code;

    function __construct($data, $message, $code){
        $this->data = $data;
        $this->message = $message;
        $this->code = $code;
    }

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array{
        // atur http response
        http_response_code($this->code);
        return [
            'data' => $this->data,
            'message' => $this->message,
            'code' => $this->code
        ];
    }
}
