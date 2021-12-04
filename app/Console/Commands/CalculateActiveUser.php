<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class CalculateActiveUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'photobbs:calculate-active-user';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '生成论坛活跃用户榜单';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(User $user)
    {
        // 在命令行打印一行信息
        $this->info("开始计算...");

        $user->calculateAndCacheActiveUsers();

        $this->info("成功生成！");
    }
}
