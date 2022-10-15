<?php

return [
    'common' => [
        'actions' => 'Actions',
        'create' => 'Create',
        'edit' => 'Edit',
        'update' => 'Update',
        'new' => 'New',
        'cancel' => 'Cancel',
        'attach' => 'Attach',
        'detach' => 'Detach',
        'save' => 'Save',
        'delete' => 'Delete',
        'delete_selected' => 'Delete selected',
        'search' => 'Search...',
        'back' => 'Back to Index',
        'are_you_sure' => 'Are you sure?',
        'no_items_found' => 'No items found',
        'created' => 'Successfully created',
        'saved' => 'Saved successfully',
        'removed' => 'Successfully removed',
    ],

    'categories' => [
        'name' => 'Categories',
        'index_title' => 'Categories List',
        'new_title' => 'New Category',
        'create_title' => 'Create Category',
        'edit_title' => 'Edit Category',
        'show_title' => 'Show Category',
        'inputs' => [
            'user_id' => 'User',
            'name' => 'Name',
        ],
    ],

    'subcategories' => [
        'name' => 'Subcategories',
        'index_title' => 'Subcategories List',
        'new_title' => 'New Subcategory',
        'create_title' => 'Create Subcategory',
        'edit_title' => 'Edit Subcategory',
        'show_title' => 'Show Subcategory',
        'inputs' => [
            'category_id' => 'Category',
            'name' => 'Name',
        ],
    ],

    'all_products' => [
        'name' => 'All Products',
        'index_title' => 'AllProducts List',
        'new_title' => 'New Products',
        'create_title' => 'Create Products',
        'edit_title' => 'Edit Products',
        'show_title' => 'Show Products',
        'inputs' => [
            'image' => 'Image',
            'name' => 'Name',
            'subcategory_id' => 'Subcategory',
        ],
    ],

    'roles' => [
        'name' => 'Roles',
        'index_title' => 'Roles List',
        'create_title' => 'Create Role',
        'edit_title' => 'Edit Role',
        'show_title' => 'Show Role',
        'inputs' => [
            'name' => 'Name',
        ],
    ],

    'permissions' => [
        'name' => 'Permissions',
        'index_title' => 'Permissions List',
        'create_title' => 'Create Permission',
        'edit_title' => 'Edit Permission',
        'show_title' => 'Show Permission',
        'inputs' => [
            'name' => 'Name',
        ],
    ],
];
