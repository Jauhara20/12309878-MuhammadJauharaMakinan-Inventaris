<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('lendings', function (Blueprint $table) {
            $table->foreignId('returned_by')->nullable()->constrained('users')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('lendings', function (Blueprint $table) {
            $table->dropForeign(['returned_by']);
            $table->dropColumn('returned_by');
        });
    }
};
