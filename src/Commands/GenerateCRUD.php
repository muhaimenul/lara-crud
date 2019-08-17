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
        {name : Class (singular) for example User}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate Crud including controller, model, views & migrations.';

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
        $crudGnt = app()->makeWith(CrudGenerator::class, ['name' => $name]);
        $crudGnt->generate();
    }

}