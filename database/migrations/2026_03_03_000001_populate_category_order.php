<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $categories = DB::table('categories')->orderBy('id')->get();
        foreach ($categories as $index => $cat) {
            DB::table('categories')->where('id', $cat->id)->update(['order' => $index + 1]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('categories')->update(['order' => 0]);
    }
};
