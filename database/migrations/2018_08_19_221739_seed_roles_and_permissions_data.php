<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use App\Models\Model;

class SeedRolesAndPermissionsData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //清除缓存
        app()['cache']->forget('spatie.permission.cache');

        //创建内容管理权限
        Permission::create(['name' => 'manage_contents']);
        //创建管理用户权限
        Permission::create(['name' => 'manage_users']);
        //创建站点全局配置修改权限
        Permission::create(['name' => 'edit_settings']);

        //创建站长角色
        $master = Role::create(['name' => 'Founder']);
        $master->givePermissionTo('manage_contents');
        $master->givePermissionTo('manage_users');
        $master->givePermissionTo('edit_settings');

        //创建管理员角色
        $manage = Role::create(['name' => 'Maintainer']);
        $manage->givePermissionTo('manage_contents');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //清除缓存
        app()['cache']->forget('spatie.permission.cache');

        // 清空所有数据表数据
        $tableNames = config('permission.table_names');
        //临时取消批量赋值保护
        Model::unguard();
        //清空所有数据
        DB::table($tableNames['role_has_permissions'])->delete();
        DB::table($tableNames['model_has_roles'])->delete();
        DB::table($tableNames['model_has_permissions'])->delete();
        DB::table($tableNames['roles'])->delete();
        DB::table($tableNames['permissions'])->delete();
        Model::reguard();
    }
}
