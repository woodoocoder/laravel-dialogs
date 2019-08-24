<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class WoodoocoderLaravelDialogsMessages extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        $tablePrefix = config('woodoocoder.dialogs.table_prefix');

        Schema::create($tablePrefix.'messages', function (Blueprint $table) use ($tablePrefix) {
            $table->bigIncrements('id');
            $table->bigInteger('dialog_id')->unsigned();
            $table->bigInteger('user_id')->unsigned();
            $table->text('message');
            $table->timestamps();
            $table->softDeletes();

            $table->index(['dialog_id', 'user_id']);

            $table->foreign('dialog_id')->references('id')->on($tablePrefix.'dialogs')
                ->onDelete('cascade');

            $table->foreign('user_id')->references('id')->on('users')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(){
        $tablePrefix = config('woodoocoder.dialogs.table_prefix');

        Schema::table($tablePrefix.'messages', function (Blueprint $table) {
            $table->dropIndex(['dialog_id', 'user_id']);

            $table->dropForeign(['dialog_id']);
            $table->dropForeign(['user_id']);
        });

        Schema::dropIfExists($tablePrefix.'messages');
    }
}
