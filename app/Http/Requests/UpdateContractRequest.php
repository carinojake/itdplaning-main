<?php

namespace App\Http\Requests;

use App\Models\Contract;
use Vinkla\Hashids\Facades\Hashids;

class UpdateContractRequest extends ContractRequest
{
    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return $this->contractRules($this->contractId());
    }

    private function contractId(): ?int
    {
        $contract = $this->route('contract');

        if ($contract instanceof Contract) {
            return (int) $contract->getKey();
        }

        $decoded = Hashids::decode((string) $contract);

        return isset($decoded[0]) ? (int) $decoded[0] : null;
    }
}
