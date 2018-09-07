<?php

namespace App\Console\Commands;

use App\Models\Menu;
use Illuminate\Console\Command;

class RefreshMenus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fanbbs:refresh-menus';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'refresh menus from redis';


    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $menus = Menu::all()->toArray();
        $menuFormat = menuFormat($menus);
        \Cache::set('fanbbs_menus',$menuFormat,now()->addDays(30));
    }
}
