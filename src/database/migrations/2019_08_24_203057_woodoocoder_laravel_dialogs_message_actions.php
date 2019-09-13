<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class WoodoocoderLaravelDialogsMessageActions extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        $tablePrefix = config('woodoocoder.dialogs.table_prefix');

        Schema::create($tablePrefix.'message_actions', function (Blueprint $table) use ($tablePrefix) {
            $table->bigIncrements('id');
            $table->bigInteger('message_id')->unsigned();
            $table->bigInteger('user_id')->unsigned();
            $table->boolean('seen')->default(0);
            $table->boolean('deleted')->default(0);
            
            $table->timestamps();
            $table->softDeletes();

            $table->index(['message_id', 'user_id']);

            $table->foreign('message_id')->references('id')->on($tablePrefix.'messages')
                ->onDelete('cascade');

            $table->foreign('user_id')->references('id')->on($tablePrefix.'participants')
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

        Schema::table($tablePrefix.'message_actions', function (Blueprint $table) {
            $table->dropIndex(['message_id', 'user_id']);

            $table->dropForeign(['message_id']);
            $table->dropForeign(['user_id']);
        });

        Schema::dropIfExists($tablePrefix.'message_actions');
    }
}
