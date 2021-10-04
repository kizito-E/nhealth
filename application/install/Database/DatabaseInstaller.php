<?php

namespace Install\Database;

use Illuminate\Database\Capsule\Manager as DB;

class DatabaseInstaller
{
    public $databaseVersion = 1;

    public function createTables()
    {
        DB::schema()->create('ads', function ($table) {
            $table->integer('ad_id', true);
            $table->string('hash_id');
            $table->integer('user_id')->index();
            $table->integer('camp_id')->index();
            $table->integer('status');
            $table->text('status_message');
            $table->string('type');
            $table->text('title');
            $table->text('description');
            $table->string('filename', 100);
            $table->integer('img_width');
            $table->integer('img_height');
            $table->string('img_wh');
            $table->text('ad_url');
            $table->string('action_text');
            $table->integer('views');
            $table->integer('clicks');
            $table->decimal('ctr', 5, 2);
            $table->decimal('cpm', 12, 5)->index();
            $table->decimal('costs', 12, 5)->index();
            $table->string('payment_mode');
            $table->decimal('cpc', 10, 4);
            $table->decimal('cpv', 10, 4);
            $table->dateTime('created_at');
            $table->dateTime('updated_at')->nullable();
        });

        DB::schema()->create('adunits', function ($table) {
            $table->integer('unit_id', true);
            $table->string('hash_id')->index();
            $table->integer('site_id')->index();
            $table->integer('user_id')->index();
            $table->string('name');
            $table->integer('status');
            $table->string('type');
            $table->string('banner_size')->index();
            $table->decimal('min_cpc', 10, 2)->index();
            $table->decimal('min_cpv', 10, 2)->index();
            $table->text('params');
            $table->string('allowed_payments');
            $table->dateTime('created_at');
            $table->dateTime('updated_at')->nullable();
        });

        DB::schema()->create('bl_sites', function ($table) {
            $table->integer('camp_id');
            $table->string('site');
        });

        DB::schema()->create('camps', function ($table) {
            $table->integer('id', true)->index();
            $table->integer('user_id')->index();
            $table->integer('isolated');
            $table->integer('status');
            $table->string('name');
            $table->string('type');
            $table->string('theme');
            $table->text('allowed_site_themes');
            $table->date('start_date');
            $table->date('end_date');
            $table->string('days');
            $table->string('hours');
            $table->text('geos');
            $table->string('devs');
            $table->text('platforms');
            $table->text('browsers');
            $table->dateTime('created_at');
            $table->dateTime('updated_at')->nullable();
        });

        DB::schema()->create('ci_sessions', function ($table) {
            $table->string('id', 128);
            $table->string('ip_address', 45);
            $table->integer('timestamp')->unsigned()->default(0)->index();
            $table->binary('data');
        });

        DB::schema()->create('filter_ad_views', function ($table) {
            $table->integer('ad_id');
            $table->integer('long_ip');
            $table->integer('views');
            $table->dateTime('date');
            $table->unique(['ad_id', 'long_ip', 'views'], 'ad_id');
        });

        DB::schema()->create('filter_clicks', function ($table) {
            $table->integer('ad_id');
            $table->integer('unit_id');
            $table->integer('long_ip');
            $table->timestamp('date')->nullable();
            $table->index(['ad_id', 'unit_id', 'long_ip'], 'ad_id');
        });

        DB::schema()->create('filter_unit_views', function ($table) {
            $table->integer('unit_id');
            $table->integer('long_ip');
            $table->integer('views');
            $table->dateTime('date');
            $table->unique(['unit_id', 'long_ip', 'views'], 'unit_id');
        });

        DB::schema()->create('messages', function ($table) {
            $table->integer('message_id', true);
            $table->integer('ticket_id')->index();
            $table->integer('user_id')->index();
            $table->dateTime('created_at');
            $table->dateTime('read_at')->nullable();
            $table->text('message');
        });

        DB::schema()->create('payments', function ($table) {
            $table->integer('payment_id', true);
            $table->string('payment_hid', 32);
            $table->integer('user_id')->index();
            $table->string('gateway');
            $table->string('currency');
            $table->decimal('amount', 10, 4);
            $table->text('description');
            $table->text('payment_data')->nullable();
            $table->dateTime('created_at');
        });

        DB::schema()->create('payouts', function ($table) {
            $table->integer('id', true);
            $table->integer('user_id');
            $table->string('status', 100);
            $table->string('payout_gateway', 100);
            $table->string('payout_account');
            $table->decimal('amount', 10, 2);
            $table->string('currency');
            $table->text('details');
            $table->dateTime('created_at');
            $table->dateTime('completed_at')->nullable();
        });

        DB::schema()->create('settings', function ($table) {
            $table->integer('id', true);
            $table->integer('user_id');
            $table->string('option_key');
            $table->text('option_value');
            $table->index(['user_id', 'option_key'], 'user_id');
        });

        DB::schema()->create('sites', function ($table) {
            $table->integer('site_id', true);
            $table->integer('user_id')->index();
            $table->integer('isolated');
            $table->integer('status');
            $table->text('status_message');
            $table->string('domain');
            $table->string('theme');
            $table->text('allowed_camp_themes');
            $table->text('stat_url');
            $table->text('stat_login');
            $table->text('stat_password');
            $table->dateTime('created_at');
            $table->dateTime('updated_at');
        });

        DB::schema()->create('stat_ads', function ($table) {
            $table->integer('id', true);
            $table->integer('ad_id');
            $table->integer('user_id');
            $table->integer('camp_id');
            $table->integer('views');
            $table->integer('clicks');
            $table->decimal('ctr', 5, 2);
            $table->decimal('cpm', 12, 5);
            $table->decimal('costs', 12, 5);
            $table->date('date');
        });

        DB::schema()->create('stat_adunits', function ($table) {
            $table->integer('id', true);
            $table->integer('unit_id');
            $table->integer('user_id');
            $table->integer('site_id');
            $table->integer('views');
            $table->integer('clicks');
            $table->decimal('ctr', 5, 2);
            $table->decimal('cpm', 12, 5);
            $table->decimal('profit', 12, 5);
            $table->date('date');
        });

        DB::schema()->create('stat_advertisers', function ($table) {
            $table->integer('id', true);
            $table->integer('user_id');
            $table->integer('views');
            $table->integer('clicks');
            $table->decimal('ctr', 5, 2);
            $table->decimal('cpm', 12, 5);
            $table->decimal('costs', 12, 5);
            $table->date('date');
        });

        DB::schema()->create('stat_camps', function ($table) {
            $table->integer('id', true);
            $table->integer('camp_id');
            $table->integer('user_id');
            $table->integer('views');
            $table->integer('clicks');
            $table->decimal('ctr', 5, 2);
            $table->decimal('cpm', 12, 5);
            $table->decimal('costs', 12, 5);
            $table->date('date');
        });

        DB::schema()->create('stat_sites', function ($table) {
            $table->integer('id', true);
            $table->integer('site_id');
            $table->integer('user_id');
            $table->integer('views');
            $table->integer('clicks');
            $table->decimal('ctr', 5, 2);
            $table->decimal('cpm', 12, 5);
            $table->decimal('profit', 12, 5);
            $table->date('date');
        });

        DB::schema()->create('stat_webmasters', function ($table) {
            $table->integer('id', true);
            $table->integer('user_id');
            $table->integer('views');
            $table->integer('clicks');
            $table->decimal('ctr', 5, 2);
            $table->decimal('cpm', 12, 5);
            $table->decimal('profit', 12, 5);
            $table->date('date');
        });

        DB::schema()->create('tickets', function ($table) {
            $table->integer('ticket_id', true);
            $table->integer('user_id')->index();
            $table->text('subject');
            $table->integer('status');
            $table->dateTime('created_at');
            $table->dateTime('closed_at')->nullable();
        });

        DB::schema()->create('users', function ($table) {
            $table->integer('id', true);
            $table->string('username');
            $table->string('email');
            $table->string('password');
            $table->string('role');
            $table->string('subrole');
            $table->integer('status');
            $table->text('status_message');
            $table->decimal('webmaster_balance', 12, 5);
            $table->decimal('advertiser_balance', 12, 5);
            $table->string('reset_pass_token');
            $table->timestamp('register_date')->default(DB::raw('CURRENT_TIMESTAMP'));
        });

        DB::schema()->create('db_config', function ($table) {
            $table->integer('id', true);
            $table->string('database_version');
            $table->timestamp('last_update_date')->default(DB::raw('CURRENT_TIMESTAMP'));
        });

        // внешние ключи
        DB::schema()->table('ads', function ($table) {
            $table->foreign('camp_id')->references('id')->on('camps')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
        });

        DB::schema()->table('adunits', function ($table) {
            $table->foreign('site_id')->references('site_id')->on('sites')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
        });

        DB::schema()->table('camps', function ($table) {
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
        });

        DB::schema()->table('messages', function ($table) {
            $table->foreign('ticket_id')->references('ticket_id')->on('tickets')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
        });

        DB::schema()->table('payments', function ($table) {
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
        });

        DB::schema()->table('sites', function ($table) {
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
        });

        DB::schema()->table('tickets', function ($table) {
            $table->foreign('user_id')->references('id')->on('users');
        });

        $this->setDatabaseVersion();
    }

    public function createAdminAccount($data)
    {
        DB::table("users")->insertGetId($data);
    }

    public function setDatabaseVersion()
    {
        DB::table("db_config")->insert([
            "database_version" => $this->databaseVersion
        ]);
    }

}