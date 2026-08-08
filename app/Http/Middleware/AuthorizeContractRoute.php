<?php

namespace App\Http\Middleware;

use App\Models\Contract;
use App\Models\Taskcon;
use Closure;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Vinkla\Hashids\Facades\Hashids;

class AuthorizeContractRoute
{
    /**
     * @throws AuthorizationException
     */
    public function handle(Request $request, Closure $next): mixed
    {
        $route = $request->route();
        $routeName = $route?->getName();

        if (in_array($routeName, ['contract.index', 'contract.getdata', 'expenses.index'], true)) {
            Gate::authorize('viewAny', Contract::class);
        }

        if (in_array($routeName, [
            'contract.create',
            'contract.store',
            'contract.createsubcn',
            'contract.createsubno',
            'contract.createModal',
            'contract.check-contract',
            'expenses.create',
            'expenses.store',
            'expenses.createsubno',
        ], true)) {
            Gate::authorize('create', Contract::class);
        }

        $routeContract = $route?->parameter('contract') ?? $route?->parameter('expense');

        if ($routeContract !== null) {
            $contract = $this->resolveContract($routeContract);
            Gate::authorize($this->ability($routeName), $contract);
            $request->attributes->set('authorized_contract', $contract);

            $routeTaskcon = $route?->parameter('taskcon');

            if ($routeTaskcon !== null) {
                $taskcon = $this->resolveTaskcon($routeTaskcon, $contract);
                $request->attributes->set('authorized_taskcon', $taskcon);
            }
        }

        return $next($request);
    }

    private function resolveContract(mixed $routeContract): Contract
    {
        if ($routeContract instanceof Contract) {
            return $routeContract;
        }

        $decoded = Hashids::decode((string) $routeContract);
        abort_unless(isset($decoded[0]), 404);

        return Contract::withoutGlobalScope(Contract::VISIBILITY_SCOPE)
            ->findOrFail((int) $decoded[0]);
    }

    private function resolveTaskcon(mixed $routeTaskcon, Contract $contract): Taskcon
    {
        if ($routeTaskcon instanceof Taskcon) {
            abort_unless((int) $routeTaskcon->contract_id === (int) $contract->getKey(), 404);

            return $routeTaskcon;
        }

        $decoded = Hashids::decode((string) $routeTaskcon);
        abort_unless(isset($decoded[0]), 404);

        return Taskcon::where('contract_id', $contract->getKey())
            ->findOrFail((int) $decoded[0]);
    }

    private function ability(?string $routeName): string
    {
        if (in_array($routeName, ['contract.destroy', 'expenses.destroy'], true)) {
            return 'delete';
        }

        if (in_array($routeName, [
            'contract.edit',
            'contract.update',
            'contract.editpay',
            'contract.updatepay',
            'contract.task.create',
            'contract.task.store',
            'contract.task.edit',
            'contract.task.update',
            'contract.task.destroy',
            'contract.task.editview',
            'contract.task.filesdel',
            'expenses.edit',
            'expenses.update',
            'expenses.task.create',
            'expenses.task.store',
            'expenses.task.edit',
            'expenses.task.update',
            'expenses.task.destroy',
        ], true)) {
            return 'update';
        }

        return 'view';
    }
}
