<?php


namespace App\Http\Responses;


use Botble\Base\Http\Responses\BaseHttpResponse;

class AjaxResponse
{

    /**
     * @var array
     */
    protected $data;

    /**
     * @var string
     */
    protected $message;

    /**
     * @var int
     */
    protected $status = 4;

    /**
     * @param mixed $data
     * @return BaseHttpResponse
     */
    public function setData($data): self
    {
        $this->data = $data;
        $this->status = 2;
        return $this;
    }

    /**
     * @param string $message
     * @return BaseHttpResponse
     */
    public function setMessage($message): self
    {
        $this->message = $message;
        return $this;
    }

    public function toApiResponse()
    {
        return response()->json(array(
            'status' => $this->status,
            'message' => $this->message,
            'data' => $this->data
        ), 200);
    }
}
