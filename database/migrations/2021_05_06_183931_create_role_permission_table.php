<?php

use App\Models\CommunityPermission;
use App\Models\CommunityRole;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRolePermissionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('community_roles_permissions', function (Blueprint $table) {
            $table->foreignId('role_id')->constrained(CommunityRole::tablename());
            $table->foreignId('permission_id')->constrained(CommunityPermission::tablename());
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('community_roles_permissions');
    }
}
