<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tasks', function (Blueprint $table) {
            // Cek apakah kolom title ada sebelum drop
            if (Schema::hasColumn('tasks', 'title')) {
                $table->dropColumn('title');
            }
            
            // Cek apakah kolom recap_id belum ada sebelum menambah
            if (!Schema::hasColumn('tasks', 'recap_id')) {
                $table->unsignedBigInteger('recap_id')->after('id');
            }
        });
        
        // Bersihkan data yang tidak valid jika ada
        DB::statement('UPDATE tasks SET recap_id = 1 WHERE recap_id IS NULL OR recap_id NOT IN (SELECT id FROM recaps)');
        
        Schema::table('tasks', function (Blueprint $table) {
            // Cek apakah foreign key belum ada
            $foreignKeys = DB::select("
                SELECT CONSTRAINT_NAME 
                FROM information_schema.TABLE_CONSTRAINTS 
                WHERE TABLE_SCHEMA = DATABASE() 
                AND TABLE_NAME = 'tasks' 
                AND CONSTRAINT_TYPE = 'FOREIGN KEY'
                AND CONSTRAINT_NAME = 'tasks_recap_id_foreign'
            ");
            
            if (empty($foreignKeys)) {
                $table->foreign('recap_id')->references('id')->on('recaps')->onDelete('cascade');
            }
        });
    }

    public function down(): void
    {
        Schema::table('tasks', function (Blueprint $table) {
            // Drop foreign key dan kolom recap_id
            if (Schema::hasColumn('tasks', 'recap_id')) {
                $table->dropForeign(['recap_id']);
                $table->dropColumn('recap_id');
            }
            
            // Tambahkan kembali kolom title jika belum ada
            if (!Schema::hasColumn('tasks', 'title')) {
                $table->string('title')->after('id');
            }
        });
    }
};