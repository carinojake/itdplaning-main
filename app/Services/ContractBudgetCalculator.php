<?php

namespace App\Services;

use App\Models\Contract;

final class ContractBudgetCalculator
{
    /**
     * Return the PR/PA totals for one fiscal year using one consistent scope.
     *
     * Draft and cancelled contracts are excluded. Legacy numeric statuses and
     * null statuses remain included for backward compatibility.
     *
     * @return array{pr_total: float, pa_total: float, per_year_pa_total: float, refund_pa_total: float}
     */
    public function forFiscalYear(int|string|null $fiscalYear): array
    {
        $query = Contract::query()->budgetCounted();

        if ($fiscalYear !== null) {
            $query->where('contract_fiscal_year', (int) $fiscalYear);
        }

        $totals = (clone $query)
            ->selectRaw('COALESCE(SUM(contract_pr_budget), 0) AS pr_total')
            ->selectRaw('COALESCE(SUM(contract_pa_budget), 0) AS pa_total')
            ->selectRaw('COALESCE(SUM(contract_peryear_pa_budget), 0) AS per_year_pa_total')
            ->first();

        $refundTotal = (clone $query)
            ->where('contract_refund_pa_status', 1)
            ->sum('contract_refund_pa_budget');

        return [
            'pr_total' => (float) ($totals->pr_total ?? 0),
            'pa_total' => (float) ($totals->pa_total ?? 0),
            'per_year_pa_total' => (float) ($totals->per_year_pa_total ?? 0),
            'refund_pa_total' => (float) $refundTotal,
        ];
    }
}
