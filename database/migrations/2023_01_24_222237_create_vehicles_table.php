<?php

use App\Models\Garage;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Garage::class)->constrained();
            $table->string('name');
            $table->string('image');
            $table->string('plate')->unique();
            $table->boolean('notify')->default(true);
            $table->date('revision')->nullable();
            $table->date('insurance')->nullable();
            $table->string('power')->nullable();
            $table->enum('category', ['euro3', 'euro4', 'euro5', 'euro6'])->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vehicles');
    }
};
