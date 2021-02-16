<?php
declare(strict_types=1);

namespace Vcg\Configuration\Model;

class RecordDefaultsModel
{
    private RequestModel $requestModel;
    private ResponseModel $responseModel;

    public function getRequestModel(): RequestModel
    {
        return $this->requestModel;
    }

    public function setRequestModel(RequestModel $requestModel): self
    {
        $this->requestModel = $requestModel;

        return $this;
    }

    public function getResponseModel(): ResponseModel
    {
        return $this->responseModel;
    }

    public function setResponseModel(ResponseModel $responseModel): self
    {
        $this->responseModel = $responseModel;

        return $this;
    }
}
