<?php
/**
 * Creator htm
 * Created by 2020/11/10 15:31
 **/

namespace Szkj\Rbac\Console\Commands;


use Illuminate\Console\Command;

class InstallCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = 'szkj:rbac-install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install the collection package';

    /**
     * Install directory.
     *
     * @var string
     */
    protected $directory = '';


    /**
     * @return string
     */
    public function getConnection(): string
    {
        return config('database.default');
    }

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $this->createRequests();
    }

    public function createRequests()
    {
        $files = [];
        $this->listDir(__DIR__ . '/../../stubs/Requests',$files);
        dd($files);

    }


    public function listDir($directory,array &$file)
    {
        $temp = scandir($directory);
        foreach ($temp as $v) {
            $a = $temp . '/' . $v;
            if (is_dir($a)) {//如果是文件夹则执行
                if ($v == '.' || $v == '..') {//判断是否为系统隐藏的文件.和..  如果是则跳过否则就继续往下走，防止无限循环再这里。
                    continue;
                }
                $this->listDir($a,$file);//因为是文件夹所以再次调用自己这个函数，把这个文件夹下的文件遍历出来
            } else {
                $this->info($a);
                array_push($file,$a);
            }
        }
    }

    /**
     * Get stub contents.
     *
     * @param $name
     *
     * @return string
     */
    protected function getStub($name)
    {
        return $this->laravel['files']->get(__DIR__ . "/../../stubs/$name.stub");
    }

    /**
     * Make new directory.
     *
     * @param string $path
     */
    protected function makeDir($path = '')
    {
        $this->laravel['files']->makeDirectory(app_path() . '/' . $path, 0755, true, true);
    }
}