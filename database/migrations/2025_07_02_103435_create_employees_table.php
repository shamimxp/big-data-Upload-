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
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->string('emp_name')->nullable();
            $table->string('emp_id')->nullable();
            $table->string('job_location')->nullable();
            $table->string('dob')->nullable();
            $table->integer('company_id')->nullable();
            $table->integer('organogram_id')->nullable();
            $table->integer('division_id')->nullable();
            $table->integer('department_id')->nullable();
            $table->integer('section_id')->nullable();
            $table->integer('desk_id')->nullable();
            $table->integer('designation_id')->nullable();
            $table->integer('edu_degree_id')->nullable();
            $table->integer('custodian_id')->nullable();
            $table->integer('sub_custodian_id')->nullable();
            $table->integer('emp_category_id')->nullable();
            $table->string('is_head_of_dept')->nullable();
            $table->string('blood_group')->nullable();
            $table->string('gender')->nullable();
            $table->string('made_of_recruitment')->nullable();
            $table->string('religion')->nullable();
            $table->string('gross_salary')->nullable();
            $table->string('joining_date')->nullable();
            $table->string('telephone_ext_no')->nullable();
            $table->string('nid')->nullable();
            $table->string('phone_number')->nullable();
            $table->string('personal_phone_number')->nullable();
            $table->tinyInteger('status')->default(1);
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
        Schema::dropIfExists('employees');
    }
};
