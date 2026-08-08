<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('contracts', function (Blueprint $table): void {
            $table->foreignId('owner_user_id')
                ->nullable()
                ->after('contract_owner')
                ->constrained('users')
                ->nullOnDelete();
        });

        $adminUserId = DB::table('model_has_roles')
            ->join('roles', 'roles.id', '=', 'model_has_roles.role_id')
            ->where('roles.name', 'admin')
            ->where('model_has_roles.model_type', User::class)
            ->orderBy('model_has_roles.model_id')
            ->value('model_has_roles.model_id');

        if ($adminUserId !== null) {
            DB::table('contracts')
                ->whereNull('owner_user_id')
                ->update(['owner_user_id' => $adminUserId]);
        }
    }

    public function down(): void
    {
        Schema::table('contracts', function (Blueprint $table): void {
            $table->dropConstrainedForeignId('owner_user_id');
        });
    }
};
