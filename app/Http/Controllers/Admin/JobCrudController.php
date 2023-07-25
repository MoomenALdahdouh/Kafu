<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\JobRequest;
use App\Models\Job;
use App\Services\JobAdminService;
use App\Services\JobService;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class JobCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class JobCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;

    //use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    // use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation { store as traitStore; }
    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     */

    protected $jobservice;

    public function __construct(JobAdminService $jobservice)
    {
        parent::__construct();
        $this->jobservice = $jobservice;
    }


    public function setup()
    {
        CRUD::setModel(\App\Models\Job::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/job');
        CRUD::setEntityNameStrings('job', 'jobs');
    }

    /**
     * Define what happens when the List operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */

    protected function setupListOperation()
    {
        CRUD::column('user_id');
        CRUD::column('company');
        CRUD::column('name');
        CRUD::column('description');
        CRUD::column('salary');
        CRUD::column('budget');
        CRUD::column('status');
        /**
         * Columns can be defined using the fluent syntax or array syntax:
         * - CRUD::column('price')->type('number');
         * - CRUD::addColumn(['name' => 'price', 'type' => 'number']);
         */
    }

    /**
     * Define what happens when the Create operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(JobRequest::class);

        CRUD::field('user_id');
        CRUD::field('company_id');
        //CRUD::field('incubator_key');
        //CRUD::field('plan_id');
        CRUD::field('name');
        CRUD::field('description');
        CRUD::field('salary');
        CRUD::field('budget');
        //CRUD::field(['name' => 'status', 'type' => 'checkbox', 'label' => 'Publish']);
        CRUD::field('status') // Field name
        ->type('checkbox') // Field type
        ->label('Check to Published') // Field label
        ->options([        // Map checkbox values to labels (optional)
            0 => '0',
            1 => '1',
        ]);

        /**
         * Fields can be defined using the fluent syntax or array syntax:
         * - CRUD::field('price')->type('number');
         * - CRUD::addField(['name' => 'price', 'type' => 'number']));
         */
    }

    /**
     * Define what happens when the Update operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-update
     * @return void
     */
    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }

    public function update(JobRequest $request)
    {
        $job = $this->jobservice->updateJob($request);
        return redirect(backpack_url('job'))->with('success');
    }
}
