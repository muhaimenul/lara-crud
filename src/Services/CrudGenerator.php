<?php

/**
 * Created by PhpStorm.
 * User: Muhaimenul Islam
 * Date: 8/16/2019
 * Time: 6:49 PM
 */
namespace Muhaimenul\Laracrud\Services;

use File;
class CrudGenerator
{
    protected $name;

    /**
     * CrudGenerator constructor.
     * @param string $name
     */

    public function __construct($name)
    {
        $this->name = $name;
    }

    /**
     * generate crud related files
     */

    public function generate() {
//        $name = $this->name;
        $this->model();
        $this->controller();
        $this->request();
        $this->routes();
    }

    /**
     * get type related stubs
     * @param $type
     * @return string
     */
    public function getStub($type)
    {
        $path = __DIR__ . '/../stubs/' . "$type.stub";
//        return file_get_contents(resource_path("stubs/$type.stub"));
        return file_get_contents($path);
    }

    /**
     * generate model
     */

    protected function model() {
        $name = $this->name;
        $modelTemplate = str_replace(
            ['{{modelName}}'],
            [$name],
            $this->getStub('Model')
        );
        file_put_contents(app_path("/{$name}.php"), $modelTemplate);
    }

    /**
     * generate controller
     */

    protected function controller() {
        $name = $this->name;
        $controllerTemplate = str_replace(
            [
                '{{modelName}}',
                '{{modelNamePluralLowerCase}}',
                '{{modelNameSingularLowerCase}}'
            ],
            [
                $name,
                strtolower(str_plural($name)),
                strtolower($name)
            ],
            $this->getStub('Controller')
        );
        file_put_contents(app_path("/Http/Controllers/{$name}Controller.php"), $controllerTemplate);
    }

    /**
     * generate request
     */
    protected function request()
    {
        $name = $this->name;
        $requestTemplate = str_replace(
            ['{{modelName}}'],
            [$name],
            $this->getStub('Request')
        );
        if(!file_exists($path = app_path('/Http/Requests')))
            mkdir($path, 0777, true);
        file_put_contents(app_path("/Http/Requests/{$name}Request.php"), $requestTemplate);
    }

    protected function routes(){
        $name = $this->name;
        File::append(base_path('routes/api.php'), 'Route::resource(\'' . str_plural(strtolower($name)) . "', '{$name}Controller');");
    }

    protected function migration()
    {

    }

    protected function view(){

    }

}