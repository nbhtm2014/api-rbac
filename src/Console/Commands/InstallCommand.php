<?php
/**
 * Creator htm
 * Created by 2020/11/10 15:31.
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
        /*
         * create requests.
         */
        $this->createRequests();
        /*
         * create controllers.
         */
        $this->createControllers();
        /*
         * create models.
         */
        $this->createModels();

        $this->warn('Please modify the route namespace in config !');
    }

    public function createModels(): void
    {
        $files = [];
        $this->listDir(__DIR__.'/../../Stubs/Models', $files);
        foreach ($files as $file) {
            $dir = basename(dirname($file));

            $this->makeDir($dir);

            $filename = pathinfo($file, PATHINFO_FILENAME);

            $model = app_path("Models/{$filename}.php");

            $stub_model = $this->laravel['files']->get($file);

            $this->laravel['files']->put(
                $model,
                str_replace(
                    'DummyNamespace',
                    'App\\Models',
                    $stub_model
                )
            );
            $this->line('<info>'.$filename.' file was created:</info> '.str_replace(base_path(), '', $model));
        }
    }

    public function createControllers(): void
    {
        $files = [];
        $this->listDir(__DIR__.'/../../Stubs/Controllers', $files);
        foreach ($files as $file) {
            $this->makeDir('Http/Controllers/Rbac');

            $filename = pathinfo($file, PATHINFO_FILENAME);

            $controller = app_path("Http/Controllers/Rbac/{$filename}.php");

            $stub_controller = $this->laravel['files']->get($file);

            $use_base_controller = file_exists(app_path('Http/Controllers/BaseController.php'))
                ? 'use App\\Http\\Controllers\\BaseController'
                : 'use Szkj\\Rbac\\Controllers\\BaseController';

            $use_transformer = file_exists(app_path('Http/Transformers/BaseTransformer.php'))
                ? 'use App\\Http\\Transformers\\BaseTransformer'
                : 'use Szkj\\Rbac\\Transformers\\BaseTransformer';
            $this->laravel['files']->put(
                $controller,
                str_replace(
                    ['DummyNamespace', 'DummyUseNamespace','DummyUseTransformerNamespace'],
                    ['App\\Http\\Controllers\\Rbac', $use_base_controller,$use_transformer],
                    $stub_controller
                )
            );
            $this->line('<info>'.$filename.' file was created:</info> '.str_replace(base_path(), '', $controller));
        }
    }

    public function createRequests(): void
    {
        $this->makeDir('Http/Requests');
        $files = [];
        $this->listDir(__DIR__.'/../../Stubs/Requests', $files);
        foreach ($files as $file) {
            $dir = basename(dirname($file));

            $this->makeDir('Http/Requests/'.$dir);

            $filename = pathinfo($file, PATHINFO_FILENAME);

            $request = app_path("Http/Requests/{$dir}/{$filename}.php");

            $stub_request = $this->laravel['files']->get($file);

            $use_base_request = file_exists(app_path('Http/Requests/BaseRequest.php'))
                ? 'use App\\Http\\Requests\\BaseRequest'
                : 'use Szkj\\Rbac\\Requests\\BaseRequest';

            $this->laravel['files']->put(
                $request,
                str_replace(
                    ['DummyNamespace', 'DummyUseNamespace'],
                    ["App\\Http\\Requests\\{$dir}", $use_base_request],
                    $stub_request
                )
            );
            $this->line('<info>'.$filename.' file was created:</info> '.str_replace(base_path(), '', $request));
        }
    }

    /**
     * @param $directory
     * @param array &$file
     */
    protected function listDir($directory, array &$file)
    {
        $temp = scandir($directory);
        foreach ($temp as $k => $v) {
            if ('.' == $v || '..' == $v) {
                continue;
            }
            $a = $directory.'/'.$v;
            if (is_dir($a)) {
                $this->listDir($a, $file);
            } else {
                array_push($file, $a);
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
        return $this->laravel['files']->get(__DIR__."/../../Stubs/$name.stub");
    }

    /**
     * Make new directory.
     *
     * @param string $path
     */
    protected function makeDir($path = '')
    {
        $this->laravel['files']->makeDirectory(app_path().'/'.$path, 0755, true, true);
    }
}
