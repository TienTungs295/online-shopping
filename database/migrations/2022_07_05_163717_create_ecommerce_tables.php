<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEcommerceTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('ec_product_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('parent_id')->unsigned()->default(0);
            $table->mediumText('description')->nullable();
            $table->string('status', 60)->default('published');
            $table->integer('order')->unsigned()->default(0);
            $table->string('image', 255)->nullable();
            $table->tinyInteger('is_featured')->unsigned()->default(0);
            $table->timestamps();
        });

        Schema::create('ec_product_collections', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug');
            $table->string('description', 400)->nullable();
            $table->string('image', 255)->nullable();
            $table->string('status', 60)->default('published');
            $table->tinyInteger('is_featured')->unsigned()->default(0);
            $table->timestamps();
        });


        Schema::create('ec_products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug');
            $table->text('description')->nullable();
            $table->longText('content')->nullable();
//            $table->string('status', 60)->default('published');
            $table->text('image')->nullable();
            $table->string('sku')->nullable();
            $table->integer('order')->unsigned()->default(0);
            $table->integer('quantity')->unsigned()->nullable();
            $table->tinyInteger('allow_checkout_when_out_of_stock')->unsigned()->nullable();
            $table->tinyInteger('with_storehouse_management')->unsigned()->default(0);
            $table->tinyInteger('is_featured')->unsigned()->default(0);
//            $table->text('options')->nullable();
            $table->integer('category_id')->unsigned()->nullable();
//            $table->integer('brand_id')->unsigned()->nullable();
//            $table->tinyInteger('is_variation')->default(0);
            $table->tinyInteger('is_searchable')->default(0);
            $table->tinyInteger('is_show_on_list')->default(0);
//            $table->tinyInteger('sale_type')->default(0);
            $table->bigInteger('price')->unsigned()->nullable();
            $table->bigInteger('sale_price')->unsigned()->nullable();
            $table->dateTime('start_date')->nullable();
            $table->dateTime('end_date')->nullable();
//            $table->float('length')->nullable();
//            $table->float('wide')->nullable();
//            $table->float('height')->nullable();
//            $table->float('weight')->nullable();
//            $table->string('barcode')->nullable();
//            $table->string('length_unit', 20)->nullable();
//            $table->string('wide_unit', 20)->nullable();
//            $table->string('height_unit', 20)->nullable();
//            $table->string('weight_unit', 20)->nullable();
            $table->tinyInteger('stock_status')->nullable();
            $table->tinyInteger('is_contact')->default(0);
            $table->tinyInteger('is_flash_sale')->default(0);
            $table->timestamps();
        });

        Schema::create('ec_product_category_product', function (Blueprint $table) {
            $table->id();
            $table->integer('category_id')->unsigned()->index();
            $table->integer('product_id')->unsigned()->index();
            $table->bigInteger('views')->default(0);
        });

        Schema::create('ec_product_tags', function (Blueprint $table) {
            $table->id();
            $table->string('name', 120);
            $table->string('description', 400)->nullable();
            $table->string('status', 60)->default('published');
            $table->timestamps();
        });

        Schema::create('ec_product_tag_product', function (Blueprint $table) {
            $table->integer('product_id')->unsigned()->index();
            $table->integer('tag_id')->unsigned()->index();

            $table->primary(['product_id', 'tag_id']);
        });

        Schema::create('ec_product_collection_products', function (Blueprint $table) {
            $table->id();
            $table->integer('product_collection_id')->unsigned()->index();
            $table->integer('product_id')->unsigned()->index();
        });

        Schema::create('ec_product_attribute_sets', function (Blueprint $table) {
            $table->id();
            $table->string('title', 120);
            $table->string('slug', 120)->nullable();
            $table->string('display_layout')->default('swatch_dropdown');
            $table->tinyInteger('is_searchable')->unsigned()->default(1);
            $table->tinyInteger('is_comparable')->unsigned()->default(1);
            $table->tinyInteger('is_use_in_product_listing')->unsigned()->default(0);
            $table->string('status', 60)->default('published');
            $table->tinyInteger('order')->unsigned()->default(0);
            $table->timestamps();
        });

        Schema::create('ec_product_attributes', function (Blueprint $table) {
            $table->id();
            $table->integer('attribute_set_id')->unsigned();
            $table->string('title', 120);
            $table->string('slug', 120)->nullable();
            $table->string('color', 50)->nullable();
            $table->string('image')->nullable();
            $table->tinyInteger('is_default')->unsigned()->default(0);
            $table->tinyInteger('order')->unsigned()->default(0);
            $table->string('status', 60)->default('published');
            $table->timestamps();
        });

        Schema::create('ec_product_with_attribute_set', function (Blueprint $table) {
            $table->id();
            $table->integer('attribute_set_id')->unsigned();
            $table->integer('product_id')->unsigned();
            $table->tinyInteger('order')->unsigned()->default(0);
        });

        Schema::create('ec_product_with_attribute', function (Blueprint $table) {
            $table->id();
            $table->integer('attribute_id')->unsigned();
            $table->integer('product_id')->unsigned();
        });

        Schema::create('ec_product_variations', function (Blueprint $table) {
            $table->id();
            $table->integer('product_id')->unsigned()->nullable();
            $table->integer('configurable_product_id')->unsigned();
            $table->tinyInteger('is_default')->default(0);
        });

        Schema::create('ec_product_variation_items', function (Blueprint $table) {
            $table->id();
            $table->integer('attribute_id')->unsigned();
            $table->integer('variation_id')->unsigned();
        });

        Schema::create('ec_reviews', function (Blueprint $table) {
            $table->id();
            $table->integer('customer_id')->unsigned();
            $table->integer('product_id')->unsigned();
            $table->tinyInteger('star');
            $table->text('comment');
            $table->tinyInteger('status')->default(1);
            $table->timestamps();
        });

        Schema::create('ec_shipping', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->string('country', 120)->nullable();
            $table->timestamps();
        });

        Schema::create('ec_orders', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->unsigned()->nullable();
//            $table->string('shipping_option', 60)->nullable();
//            $table->string('shipping_method', 60)->default('default');
            $table->tinyInteger('status')->default(1);
//            $table->bigInteger('amount');
//            $table->integer('currency_id')->unsigned()->nullable();
//            $table->decimal('tax_amount', 15)->nullable();
            $table->bigInteger('shipping_fee')->default(0);
            $table->text('description')->nullable();
            $table->string('coupon_code', 120)->nullable();
            $table->bigInteger('discount_value')->nullable();
            $table->bigInteger('sub_total');
            $table->bigInteger('sub_total_final');
            $table->bigInteger('received_price');
//            $table->boolean('is_confirmed')->default(false);
//            $table->string('discount_description', 255)->nullable();
//            $table->boolean('is_finished')->default(1)->nullable();
            $table->tinyInteger('payment_method')->default(1);
//            $table->string('token', 120)->nullable();
//            $table->integer('payment_id')->unsigned()->nullable();
            $table->timestamps();
        });

        Schema::create('ec_order_product', function (Blueprint $table) {
            $table->id();
            $table->integer('order_id')->unsigned();
            $table->integer('qty');
            $table->decimal('price', 15);
            $table->text('options')->nullable();
            $table->integer('product_id')->unsigned()->nullable();
            $table->string('product_name');
            $table->float('weight')->default(0)->nullable();
            $table->integer('restock_quantity', false, true)->default(0)->nullable();
            $table->timestamps();
        });

        Schema::create('ec_order_addresses', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('phone', 20)->nullable();
            $table->string('email')->nullable();
            $table->string('province')->nullable();
            $table->text('province_name')->nullable();
            $table->string('district')->nullable();
            $table->text('district_name')->nullable();
            $table->string('ward')->nullable();
            $table->text('ward_name')->nullable();
            $table->text('address')->nullable();
            $table->integer('order_id')->unsigned();
        });

        Schema::create('ec_discounts', function (Blueprint $table) {
            $table->id();
//            $table->string('title', 120)->nullable();
            $table->string('code', 50)->unique()->nullable();
            $table->dateTime('start_date')->nullable();
            $table->dateTime('end_date')->nullable();
//            $table->integer('quantity')->nullable();
//            $table->integer('total_used')->unsigned()->default(0);
            $table->bigInteger('value')->nullable();
//            $table->string('type', 60)->default('coupon')->nullable();
//            $table->boolean('can_use_with_promotion')->default(false);
//            $table->string('discount_on', 20)->nullable();
//            $table->integer('product_quantity', false, true)->nullable();
            $table->string('type_option', 100)->default('amount');
            $table->string('target', 100)->default('all-orders');
//            $table->decimal('min_order_price', 15)->nullable();
            $table->timestamps();
        });

        Schema::create('ec_wish_lists', function (Blueprint $table) {
            $table->id();
            $table->integer('customer_id')->unsigned();
            $table->integer('product_id')->unsigned();
            $table->timestamps();
        });

        Schema::create('ec_cart', function (Blueprint $table) {
            $table->string('identifier');
            $table->string('instance');
            $table->longText('content');
            $table->nullableTimestamps();

            $table->primary(['identifier', 'instance']);
        });

        Schema::create('ec_grouped_products', function (Blueprint $table) {
            $table->id();
            $table->integer('parent_product_id')->unsigned();
            $table->integer('product_id')->unsigned();
            $table->integer('fixed_qty')->default(1);
        });

        Schema::create('ec_customers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('avatar', 255)->nullable();
            $table->date('dob')->nullable();
            $table->string('phone', 25)->nullable();
            $table->dateTime('confirmed_at')->nullable();
            $table->string('email_verify_token', 120)->nullable();
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('ec_customer_password_resets', function (Blueprint $table) {
            $table->string('email')->index();
            $table->string('token')->index();
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('ec_customer_addresses', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email', 60)->nullable();
            $table->string('phone');
            $table->string('country', 120)->nullable();
            $table->string('state', 120)->nullable();
            $table->string('city', 120)->nullable();
            $table->string('address');
            $table->integer('customer_id')->unsigned();
            $table->tinyInteger('is_default')->default(0)->unsigned();
            $table->string('zip_code', 20)->nullable();
            $table->timestamps();
        });

        Schema::create('ec_product_related_relations', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->id();
            $table->integer('from_product_id')->unsigned()->index();
            $table->integer('to_product_id')->unsigned()->index();
        });

        Schema::create('ec_product_cross_sale_relations', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->id();
            $table->integer('from_product_id')->unsigned()->index();
            $table->integer('to_product_id')->unsigned()->index();
        });

        Schema::create('ec_product_up_sale_relations', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->id();
            $table->integer('from_product_id')->unsigned()->index();
            $table->integer('to_product_id')->unsigned()->index();
        });

        Schema::create('ec_shipping_rules', function (Blueprint $table) {
            $table->id();
            $table->string('name', 120);
            $table->integer('shipping_id')->unsigned();
            $table->enum('type', ['base_on_price', 'base_on_weight'])->default('base_on_price')->nullable();
            $table->integer('currency_id')->unsigned()->nullable();
            $table->decimal('from', 15)->default(0)->nullable();
            $table->decimal('to', 15)->default(0)->nullable();
            $table->decimal('price', 15)->default(0)->nullable();
            $table->timestamps();
        });

        Schema::create('ec_shipping_rule_items', function (Blueprint $table) {
            $table->id();
            $table->integer('shipping_rule_id', false, true);
            $table->string('country', 120)->nullable();
            $table->string('state', 120)->nullable();
            $table->string('city', 120)->nullable();
            $table->decimal('adjustment_price', 15)->default(0)->nullable();
            $table->boolean('is_enabled')->default(true);
            $table->timestamps();
        });

        Schema::create('ec_order_histories', function (Blueprint $table) {
            $table->id();
            $table->string('action', 120);
            $table->string('description', 255);
            $table->integer('user_id', false, true)->nullable();
            $table->integer('order_id', false, true);
            $table->text('extras')->nullable();
            $table->timestamps();
        });

        Schema::create('ec_shipments', function (Blueprint $table) {
            $table->id();
            $table->integer('order_id', false, true);
            $table->integer('user_id', false, true)->nullable();
            $table->float('weight')->default(0)->nullable();
            $table->string('shipment_id', 120)->nullable();
            $table->string('note', 120)->nullable();
            $table->string('status', 120)->default('pending');
            $table->decimal('cod_amount', 15)->default(0)->nullable();
            $table->string('cod_status', 60)->default('pending');
            $table->string('cross_checking_status', 60)->default('pending');
            $table->decimal('price', 15)->default(0)->nullable();
            $table->integer('store_id', false, true)->nullable();
            $table->timestamps();
        });

        Schema::create('ec_shipment_histories', function (Blueprint $table) {
            $table->id();
            $table->string('action', 120);
            $table->string('description', 255);
            $table->integer('user_id', false, true)->nullable();
            $table->integer('shipment_id', false, true);
            $table->integer('order_id', false, true);
            $table->timestamps();
        });

        Schema::create('ec_discount_products', function (Blueprint $table) {
            $table->integer('discount_id', false, true);
            $table->integer('product_id', false, true);
            $table->primary(['discount_id', 'product_id']);
        });

        Schema::create('ec_discount_customers', function (Blueprint $table) {
            $table->integer('discount_id', false, true);
            $table->integer('customer_id', false, true);
            $table->primary(['discount_id', 'customer_id']);
        });

        Schema::create('ec_discount_product_collections', function (Blueprint $table) {
            $table->integer('discount_id', false, true);
            $table->integer('product_collection_id', false, true);
            $table->primary(['discount_id', 'product_collection_id'], 'discount_product_collections_primary_key');
        });

        Schema::create('ec_flash_sales', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255);
            $table->dateTime('end_date');
            $table->string('status', 60)->default('published');
            $table->timestamps();
        });

        Schema::create('ec_flash_sale_products', function (Blueprint $table) {
            $table->integer('flash_sale_id')->unsigned();
            $table->integer('product_id')->unsigned();
            $table->double('price')->unsigned()->nullable();
            $table->integer('quantity')->unsigned()->nullable();
            $table->integer('sold')->unsigned()->default(0);
        });

        Schema::create('ec_product_labels', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255);
            $table->string('color', 120)->nullable();
            $table->string('status', 60)->default('published');
            $table->timestamps();
        });

        Schema::create('ec_product_label_products', function (Blueprint $table) {
            $table->integer('product_label_id')->unsigned()->index();
            $table->integer('product_id')->unsigned()->index();
            $table->primary(['product_label_id', 'product_id']);
        });

        Schema::create('ec_product_imgs', function (Blueprint $table) {
            $table->id();
            $table->text('image');
            $table->integer('pro_id')->unsigned();
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
        Schema::dropIfExists('ec_product_categories');
        Schema::dropIfExists('ec_product_collections');
        Schema::dropIfExists('ec_products');
        Schema::dropIfExists('ec_product_category_product');
        Schema::dropIfExists('ec_product_tags');
        Schema::dropIfExists('ec_product_tag_product');
        Schema::dropIfExists('ec_product_collection_products');
        Schema::dropIfExists('ec_product_attribute_sets');
        Schema::dropIfExists('ec_product_attributes');
        Schema::dropIfExists('ec_product_with_attribute_set');
        Schema::dropIfExists('ec_product_with_attribute');
        Schema::dropIfExists('ec_product_variations');
        Schema::dropIfExists('ec_product_variation_items');
        Schema::dropIfExists('ec_reviews');
        Schema::dropIfExists('ec_shipping');
        Schema::dropIfExists('ec_orders');
        Schema::dropIfExists('ec_order_product');
        Schema::dropIfExists('ec_order_addresses');
        Schema::dropIfExists('ec_discounts');
        Schema::dropIfExists('ec_wish_lists');
        Schema::dropIfExists('ec_cart');
        Schema::dropIfExists('ec_grouped_products');
        Schema::dropIfExists('ec_customers');
        Schema::dropIfExists('ec_customer_password_resets');
        Schema::dropIfExists('ec_customer_addresses');
        Schema::dropIfExists('ec_product_related_relations');
        Schema::dropIfExists('ec_product_cross_sale_relations');
        Schema::dropIfExists('ec_product_up_sale_relations');
        Schema::dropIfExists('ec_shipping_rules');
        Schema::dropIfExists('ec_shipping_rule_items');
        Schema::dropIfExists('ec_order_histories');
        Schema::dropIfExists('ec_shipments');
        Schema::dropIfExists('ec_shipment_histories');
        Schema::dropIfExists('ec_discount_products');
        Schema::dropIfExists('ec_discount_customers');
        Schema::dropIfExists('ec_discount_product_collections');
        Schema::dropIfExists('ec_flash_sales');
        Schema::dropIfExists('ec_flash_sale_products');
        Schema::dropIfExists('ec_product_labels');
        Schema::dropIfExists('ec_product_label_products');
        Schema::dropIfExists('ec_product_imgs');
    }
}
