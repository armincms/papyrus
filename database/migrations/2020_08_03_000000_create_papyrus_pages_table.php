<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePapyrusPagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('papyrus_pages', function (Blueprint $table) {
            $table->id();
            $table->string('resource');
            $table->multilingualContent(); 
            $table->markable();    
            $table->resourceHits(); 
            $table->multilingualRefer(); 
            $table->timestamps();
            $table->softDeletes(); 
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('papyrus_pages');
    }
}
