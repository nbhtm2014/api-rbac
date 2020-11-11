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
        $this->makeDir('Http/Requests');
        $files = [];
        $this->listDir(__DIR__ . '/../../Stubs/Requests', $files);

        foreach ($files as $file){

            $dir = basename(dirname($file));

            $this->makeDir('Http/Requests/'.$dir);

            $filename = pathinfo($file,PATHINFO_FILENAME);

            $request = app_path("Http/Requests/{$dir}/{$filename}.php");

            $stub_request =  $this->laravel['files']->get($file);

            $use_BaseRequest = file_exists(app_path('Http/Requests/BaseRequest.php'))
                ? 'use App\\Http\\Requests\\BaseRequest'
                : 'use Szkj\\Rbac\\Requests\\BaseRequest';

            $this->laravel['files']->put(
                $request,
                str_replace(
                    ['DummyNamespace','DummyUseNamespace'],
                    ["App\\Http\\Requests\\{$dir}",$use_BaseRequest],
                    $stub_request
                )
            );
            $this->line('<info>'.$filename.' file was created:</info> ' . str_replace(base_path(), '', $request));
        }
    }


    protected function listDir($directory, array &$file)
    {
        $temp = scandir($directory);
        foreach ($temp as $k => $v) {
            if ($v == '.' || $v == '..') {
                continue;
            }
            $a = $directory . '/' . $v;
            if (is_dir($a)) {
                $this->listDir($a, $file);
            } else {
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