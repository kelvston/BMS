
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIndexesForOptimization extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->index('email');
        });

        Schema::table('products', function (Blueprint $table) {
            $table->index('quantity');
        });

        Schema::table('invoices', function (Blueprint $table) {
            $table->index('status');
        });

        Schema::table('customers', function (Blueprint $table) {
            $table->index('deleted_at');
        });

        Schema::table('logs', function (Blueprint $table) {
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropIndex(['email']);
        });

        Schema::table('products', function (Blueprint $table) {
            $table->dropIndex(['quantity']);
        });

        Schema::table('invoices', function (Blueprint $table) {
            $table->dropIndex(['status']);
        });

        Schema::table('customers', function (Blueprint $table) {
            $table->dropIndex(['deleted_at']);
        });

        Schema::table('logs', function (Blueprint $table) {
            $table->dropIndex(['created_at']);
        });
    }
}

