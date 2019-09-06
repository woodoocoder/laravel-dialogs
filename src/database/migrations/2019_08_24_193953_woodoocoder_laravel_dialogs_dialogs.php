<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class WoodoocoderLaravelDialogsDialogs extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        $tablePrefix = config('woodoocoder.dialogs.table_prefix');

        Schema::create($tablePrefix.'dialogs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('subject')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists(config('woodoocoder.dialogs.table_prefix').'dialogs');
    }
}
