<?php

namespace Database\Seeders;

use TCG\Voyager\Models\Menu;
use TCG\Voyager\Models\MenuItem;
use Database\Seeders\BaseModuleSeeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class GarageSeeder extends BaseModuleSeeder
{
    protected $name_singular = 'garage';
    protected $name_plural   = 'garages';
    protected $icon          = 'voyager-shop';

    public function content()
    {
        // $file = __DIR__.'/garages.csv';
        // $garages = $this->csvToArray($file);
        // \App\Models\Garage::insert($garages);
    }

    protected function dataTypesTableSeeder()
    {
        /*
        $data = [
            'details' => [
                'order_column'         => 'order',
                'order_display_column' => 'name',
                'order_direction'      => 'asc',
                'default_search_key'   => 'name',
                'scope'                => null,
            ],
            'server_side' => 1
        ];
        */
        $this->defaultDataType(/*$data*/);
    }

    protected function dataRowsTableSeeder()
    {
        $order = 0;
        $dataRow = $this->dataRow('id');
        if (!$dataRow->exists) {
            $dataRow->fill([
                'type'         => 'number',
                'display_name' => __('voyager::seeders.data_rows.id'),
                'required'     => 1,
                'browse'       => 0,
                'read'         => 0,
                'edit'         => 0,
                'add'          => 0,
                'delete'       => 0,
                'order'        => ++$order,
            ])->save();
        }


        
        $dataRow = $this->dataRow('name');
        if (!$dataRow->exists) {
            $dataRow->fill([
                'type'         => 'text',
                'display_name' => 'Nome',
                'required'     => 1,
                'browse'       => 1,
                'read'         => 1,
                'edit'         => 1,
                'add'          => 1,
                'delete'       => 1,
                'order'        => ++$order,
                'details'      => '{"validation":{"rule":"required|unique:garages"}}'
            ])->save();
        }


        $dataRow = $this->dataRow('user_id');
        if (!$dataRow->exists) {
            $dataRow->fill([
                'type'         => 'text',
                'display_name' => 'Utente',
                'required'     => 0,
                'browse'       => 1,
                'read'         => 1,
                'edit'         => 0,
                'add'          => 0,
                'delete'       => 1,
                'order'        => ++$order,
            ])->save();
        }
       



        /*
        * ----------------
        * RELATION
        * -----------------
        */

        /*
        $dataRow = $this->dataRow('user_id');
        if (!$dataRow->exists) {
            $dataRow->fill([
                'type'         => 'number',
                'display_name' => 'Utente',
                'required'     => 0,
                'browse'       => 1,
                'read'         => 1,
                'edit'         => 1,
                'add'          => 1,
                'delete'       => 1,
                'order'        => ++$order,
            ])->save();
        }

        $dataRow = $this->dataRow('garage_belongsto_users_relationship');
        if (!$dataRow->exists) {
            $dataRow->fill([
                'type'         => 'relationship',
                'display_name' => 'Utente',
                'required'     => 0,
                'browse'       => 1,
                'read'         => 1,
                'edit'         => 1,
                'add'          => 1,
                'delete'       => 0,
                'details'      => [
                    'model'       => User::class,
                    'table'       => 'users',
                    'type'        => 'belongsTo',
                    'column'      => 'user_id',
                    'key'         => 'id',
                    'label'       => 'full_name',
                    'pivot_table' => '',
                    'pivot'       => '0',
                    'taggable'    => '0',
                ],
                'order'        => ++$order,
            ])->save();
        }
        */



        /*
        * ----------------
        * IMAGE
        * -----------------
        */

        /*
        $dataRow = $this->dataRow('image');
        if (!$dataRow->exists) {
            $dataRow->fill([
                'type'         => 'image',
                'display_name' => 'Immagine',
                'required'     => 0,
                'browse'       => 0,
                'read'         => 1,
                'edit'         => 1,
                'add'          => 1,
                'delete'       => 1,
                'details'      => [
                    'resize' => [
                        'width'  => '1000',
                        'height' => 'null',
                    ],
                    'quality'    => '92%',
                    'upsize'     => true,
                    'thumbnails' => [
                        [
                            'name'  => 'medium',
                            'scale' => '50%',
                        ],
                    ],
                ],
                'order' => ++$order,
            ])->save();
        }
        */


        $dataRow = $this->dataRow('created_at');
        if (!$dataRow->exists) {
            $dataRow->fill([
                'type'         => 'timestamp',
                'display_name' => __('voyager::seeders.data_rows.created_at'),
                'required'     => 0,
                'browse'       => 0,
                'read'         => 1,
                'edit'         => 0,
                'add'          => 0,
                'delete'       => 0,
                'order'        => ++$order,
            ])->save();
        }

        $dataRow = $this->dataRow('updated_at');
        if (!$dataRow->exists) {
            $dataRow->fill([
                'type'         => 'timestamp',
                'display_name' => __('voyager::seeders.data_rows.updated_at'),
                'required'     => 0,
                'browse'       => 0,
                'read'         => 0,
                'edit'         => 0,
                'add'          => 0,
                'delete'       => 0,
                'order'        => ++$order,
            ])->save();
        }
    }

    protected function menuItemsTableSeeder()
    {
        $menu = Menu::where('name', 'admin')->firstOrFail();

        $position = 3;

        $menu->items()->where('order', '>=', $position)->increment('order');

        $menuItem = MenuItem::firstOrNew([
            'menu_id' => $menu->id,
            'title'   => __($this->name_plural),
            'url'     => '',
            'route'   => 'voyager.'.$this->name_plural.'.index',
        ]);
        if (!$menuItem->exists) {
            $menuItem->fill([
                'target'     => '_self',
                'icon_class' => $this->icon,
                'color'      => null,
                'parent_id'  => null,
                'order'      => $position,
            ])->save();
        }

        return $menuItem;
    }
}