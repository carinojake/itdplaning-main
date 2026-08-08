<?php

namespace App\Http\Requests;

class StoreContractRequest extends ContractRequest
{
    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return $this->contractRules();
    }
}
