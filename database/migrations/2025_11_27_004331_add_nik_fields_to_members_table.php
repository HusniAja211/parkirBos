<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('members', function (Blueprint $table) {

            // Tambah field baru
            $table->string('name', 100)->after('id');
            $table->string('nik', 16)->unique()->after('name');
            $table->string('email', 100)->unique()->after('nik');

            // Hapus field lama
            $table->dropColumn('license_plate');
        });
    }

    public function down(): void
    {
        Schema::table('members', function (Blueprint $table) {

            // Kembalikan license_plate
            $table->string('license_plate', 255)->after('id');

            // Hapus field baru
            $table->dropUnique(['nik']);
            $table->dropUnique(['email']);
            $table->dropColumn(['name', 'nik', 'email']);
        });
    }
};
