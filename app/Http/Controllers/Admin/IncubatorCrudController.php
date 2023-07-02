<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\IncubatorRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class IncubatorCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class IncubatorCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     * 
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\Incubator::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/incubator');
        CRUD::setEntityNameStrings('incubator', 'incubators');
    }

    /**
     * Define what happens when the List operation is loaded.
     * 
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        CRUD::column('key');
        CRUD::column('user_id');
        CRUD::column('logo');
        CRUD::column('image');
        CRUD::column('name_officer');
        CRUD::column('projects');
        CRUD::column('country_code_id');
        CRUD::column('country_id');
        CRUD::column('message');
        CRUD::column('password');
        CRUD::column('condition');
        CRUD::column('name');
        CRUD::column('email');

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
        CRUD::setValidation(IncubatorRequest::class);

        CRUD::field('key');
        CRUD::field('user_id');
        CRUD::field('logo');
        CRUD::field('image');
        CRUD::field('name_officer');
        CRUD::field('projects');
        CRUD::field('country_code_id');
        CRUD::field('country_id');
        CRUD::field('message');
        CRUD::field('password');
        CRUD::field('condition');
        CRUD::field('name');
        CRUD::field('email');

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
}
