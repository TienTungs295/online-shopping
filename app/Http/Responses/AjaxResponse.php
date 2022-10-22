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

    protected $errors;


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
     * @param string $status
     * @return BaseHttpResponse
     */
    public function setStatus($status): self
    {
        $this->status = $status;
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

    public function setErrors($errors): self
    {
        $this->errors = $errors;
        return $this;
    }

    public function toApiResponse($global_status = 200)
    {
        return response()->json(array(
            'status' => $this->status,
            'message' => $this->message,
            'data' => $this->data,
            'errors' => $this->errors
        ), $global_status);
    }
}
