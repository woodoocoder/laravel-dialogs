<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UnreadMessages extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        $tablePrefix = config('woodoocoder.dialogs.table_prefix');

        Schema::table($tablePrefix.'participants', function (Blueprint $table) {
            $table->bigInteger('unread_messages')->default(0)->after('subject');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        $tablePrefix = config('woodoocoder.dialogs.table_prefix');

        Schema::table($tablePrefix.'participants', function (Blueprint $table) {
            $table->dropColumn('unread_messages');
        });
    }
}
