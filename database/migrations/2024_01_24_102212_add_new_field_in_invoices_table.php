<?php

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
        Schema::table('user_invoices', function (Blueprint $table) {
            $table->string('customer_mobile')->nullable()->after('customer_name');
            $table->string('customer_taxid')->nullable()->after('customer_mobile');
            $table->text('payload')->nullable()->after('html_content');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_invoices', function (Blueprint $table) {
            $table->dropColumn('customer_mobile');
            $table->dropColumn('customer_taxid');
            $table->dropColumn('payload');
        });
    }
};
