<?php

/**
 * Created by PhpStorm.
 * User: Muhaimenul Islam
 * Date: 8/17/2019
 * Time: 12:12 AM
 */
namespace Muhaimenul\Laracrud\Commands;

use Illuminate\Console\Command;
use Muhaimenul\Laracrud\Services\CrudGenerator;

class GenerateCRUD extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:crud
        {name : Class (singular) for example User}
        {option? : Optional arguments to generate specific file}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate CRUD boilerplate including controller, model, routes & migrations.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $name = $this->argument('name');
        $option = $this->argument('option');
        $crudGntSvc = app()->makeWith(CrudGenerator::class, ['name' => $name]);
        

        // option == all 

        // option == s service only
        // option == r repository only

        switch ($option) {
            case 'all':
                $crudGntSvc->generate();
                break;
            case 's':
                $crudGntSvc->generateService();
                break;
            case 'r': 
                $crudGntSvc->generateRepository();
                break;
            default:
                $crudGntSvc->generateBasic();
        }
        
    }

}