<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('username', 50)->nullable()->unique()->after('name');
            $table->string('role', 20)->default('user')->after('password');   // admin / user
            $table->string('phone', 20)->nullable();
            $table->string('position', 100)->nullable();                        // Jabatan
            $table->string('institution', 100)->nullable();                     // Instansi / Unit
            $table->text('address')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamp('last_login_at')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropUnique(['username']);
            $table->dropColumn([
                'username', 'role', 'phone', 'position',
                'institution', 'address', 'is_active', 'last_login_at',
            ]);
        });
    }
};
