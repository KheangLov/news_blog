<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\ArticleRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Illuminate\Support\Facades\Auth;

/**
 * Class ArticleCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class ArticleCrudController extends CrudController
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
        CRUD::setModel(\App\Models\Article::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/article');
        CRUD::setEntityNameStrings('article', 'articles');
    }

    protected function setupShowOperation()
    {
        CRUD::addColumn([
            'name' => 'name',
            'label' => 'Title',
            'type' => 'text',
        ]);
        CRUD::addColumn([
            'name' => 'content',
            'label' => 'Content',
            'type' => 'markdown',
        ]);
        CRUD::addColumn([
            'name' => 'thumbnail',
            'label' => 'Thumbnail',
            'type' => 'image',
        ]);
        // CRUD::addColumn([
        //     'name' => 'category',
        //     'label' => 'Category',
        //     'type' => 'relationship',
        //     'attribute' => 'name',
        // ]);
        // CRUD::addColumn([
        //     'name' => 'user',
        //     'label' => 'Created By',
        //     'type' => 'relationship',
        //     'attribute' => 'name',
        // ]);
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
        CRUD::addColumn(['name' => 'thumbnail', 'type' => 'image', 'label' => 'Image']);
        CRUD::addColumn(['name' => 'name', 'type' => 'text', 'label' => 'Title']);

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
        CRUD::setValidation(ArticleRequest::class);

        CRUD::addField([   // Hidden
            'name'  => 'created_by',
            'type'  => 'hidden',
            'value' => Auth::guard('backpack')->user()->id,
        ]);
        // CRUD::setFromDb(); // fields
        CRUD::addField(['name' => 'name', 'label' => 'Title', 'type' => 'text']);
        CRUD::addField([  // Select2
            'label'     => "Category",
            'type'      => 'select2',
            'name'      => 'category_id', // the db column for the foreign key
            'entity'    => 'category', // the method that defines the relationship in your Model
            'attribute' => 'name', // foreign key attribute that is shown to user
            'model'     => "App\Models\Category", // foreign key model
            'default'   => 2, // set the default value of the select2
            'options'   => (function ($query) {
                return $query->orderBy('name', 'ASC')->get();
            }), // force the related options to be a custom query, instead of all(); you can use this to filter the results show in the select
        ]);
        CRUD::addField([
            'name' => 'thumbnail',
            'label' => 'Thumbnail',
            'type' => 'upload',
            'upload' => true,
            'disk' => 'uploads'
        ]);
        CRUD::addField([
            'name'  => 'content',
            'label' => 'Content',
            'type'  => 'tinymce',
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
}
