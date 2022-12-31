<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Spatie\Permission\Models\Permission;

class PermissionCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'permission:create';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'create a new permission';

    /**
     * Execute the console command.
     *
     * @return int
     */

    public function handle()
    {

        $permissions = [
            'brands_store',
            'brands_update',
            'brands_destroy',
            'brands_view',
            'permissions_store',
            'permissions_update',
            'permissions_destroy',
            'permissions_view',
            'permissions_attach_detach',
            'roles_store',
            'roles_update',
            'roles_destroy',
            'roles_view',
            'category_store',
            'category_update',
            'category_destroy',
            'category_view',
            'products_store',
            'products_update',
            'products_destroy',
            'products_view',
            'tags_store',
            'tags_update',
            'tags_destroy',
            'tags_view',
        ];

        foreach ($permissions as $permission){
            Permission::create([
                'name' => $permission
            ]);
        }

    }
}
