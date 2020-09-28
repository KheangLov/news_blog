<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\GalleryRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Illuminate\Support\Facades\Auth;

/**
 * Class GalleryCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class GalleryCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation { store as traitStore; }
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
        CRUD::setModel(\App\Models\Gallery::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/gallery');
        CRUD::setEntityNameStrings('gallery', 'galleries');
    }

    protected function setupShowOperation()
    {
        CRUD::addColumn([
            'name' => 'name',
            'label' => 'Name',
            'type' => 'text',
        ]);
        CRUD::addColumn([
            'name' => 'path',
            'label' => 'Images',
            'type' => 'upload_custom',
            'disk' => 'uploads'
        ]);
    }

    /**
     * Define what happens when the List operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        // CRUD::setFromDb(); // columns
        CRUD::addColumn(['name' => 'name', 'type' => 'text', 'label' => 'Title']);
        // CRUD::addColumn(['name' => 'path', 'type' => 'upload_multiple', 'label' => 'Path']);

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
        CRUD::setValidation(GalleryRequest::class);

        // CRUD::setFromDb(); // fields
        $col6 = 'form-group col-md-6';
        CRUD::addField([   // Hidden
            'name'  => 'created_by',
            'type'  => 'hidden',
            'value' => Auth::guard('backpack')->user()->id,
        ]);
        CRUD::addField([
            'name'      => 'path',
            'label'     => 'Path',
            'type'      => 'upload_multiple',
            'upload'    => true,
            'disk'      => 'uploads',
            'wrapperAttributes' => [
                'class' => $col6
            ]
        ]);
        CRUD::addField([  // Select2
            'label'     => "Type",
            'type'      => 'select2',
            'name'      => 'type_id', // the db column for the foreign key
            'entity'    => 'type', // the method that defines the relationship in your Model
            'attribute' => 'name', // foreign key attribute that is shown to user
            'model'     => "App\Models\Type", // foreign key model
            'default'   => 2, // set the default value of the select2
            'options'   => (function ($query) {
                return $query->orderBy('name', 'ASC')->get();
            }), // force the related options to be a custom query, instead of all(); you can use this to filter the results show in the select
            'wrapperAttributes' => [
                'class' => $col6
            ]
        ]);
        CRUD::addField([
            'name' => 'name',
            'label' => 'Name',
            'type' => 'text'
        ]);

        /**
         * Fields can be defined using the fluent syntax or array syntax:
         * - CRUD::field('price')->type('number');
         * - CRUD::addField(['name' => 'price', 'type' => 'number']));
         */
    }

    public function store()
    {
        $response = $this->traitStore();
        return $response;
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
