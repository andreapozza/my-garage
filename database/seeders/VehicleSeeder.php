<?php

namespace Database\Seeders;

use App\Models\Garage;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use TCG\Voyager\Models\Menu;
use TCG\Voyager\Models\MenuItem;
use Database\Seeders\BaseModuleSeeder;

class VehicleSeeder extends BaseModuleSeeder
{
    protected $name_singular = 'vehicle';
    protected $name_plural   = 'vehicles';
    protected $icon          = 'voyager-truck';

    public function content()
    {
        // $file = __DIR__.'/vehicles.csv';
        // $vehicles = $this->csvToArray($file);
        // \App\Models\Vehicle::insert($vehicles);
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
            ])->save();
        }

        /*
        * ----------------
        * RELATION
        * -----------------
        */
        $dataRow = $this->dataRow('garage_id');
        if (!$dataRow->exists) {
            $dataRow->fill([
                'type'         => 'number',
                'display_name' => 'Garage',
                'required'     => 0,
                'browse'       => 1,
                'read'         => 1,
                'edit'         => 1,
                'add'          => 1,
                'delete'       => 1,
                'order'        => ++$order,
            ])->save();
        }

        $dataRow = $this->dataRow('vehicle_belongsto_garages_relationship');
        if (!$dataRow->exists) {
            $dataRow->fill([
                'type'         => 'relationship',
                'display_name' => 'Garage',
                'required'     => 1,
                'browse'       => 1,
                'read'         => 1,
                'edit'         => 1,
                'add'          => 1,
                'delete'       => 0,
                'details'      => collect([
                    'model'       => Garage::class,
                    'table'       => 'garages',
                    'type'        => 'belongsTo',
                    'column'      => 'garage_id',
                    'key'         => 'id',
                    'label'       => 'name',
                    'pivot_table' => '',
                    'pivot'       => '0',
                    'taggable'    => '0',
                ]),
                'order'        => ++$order,
            ])->save();
        }



        /*
        * ----------------
        * IMAGE
        * -----------------
        */

        
        $dataRow = $this->dataRow('image');
        if (!$dataRow->exists) {
            $dataRow->fill([
                'type'         => 'image',
                'display_name' => 'Immagine',
                'required'     => 0,
                'browse'       => 1,
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


        $dataRow = $this->dataRow('plate');
        if (!$dataRow->exists) {
            $dataRow->fill([
                'type'         => 'text',
                'display_name' => 'Targa',
                'required'     => 1,
                'browse'       => 1,
                'read'         => 1,
                'edit'         => 1,
                'add'          => 1,
                'delete'       => 1,
                'order'        => ++$order,
            ])->save();
        }


        $dataRow = $this->dataRow('notify');
        if (!$dataRow->exists) {
            $dataRow->fill([
                'type'         => 'checkbox',
                'display_name' => 'Notifica',
                'required'     => 1,
                'browse'       => 0,
                'read'         => 1,
                'edit'         => 1,
                'add'          => 1,
                'delete'       => 1,
                'order'        => ++$order,
                'details'      => collect([
                    "on"      => "Sì",
                    "off"     => "No",
                    "checked" => true
                ])
            ])->save();
        }

        $dataRow = $this->dataRow('revision');
        if (!$dataRow->exists) {
            $dataRow->fill([
                'type'         => 'date',
                'display_name' => 'Revisione',
                'required'     => 1,
                'browse'       => 0,
                'read'         => 1,
                'edit'         => 1,
                'add'          => 1,
                'delete'       => 1,
                'order'        => ++$order,
                'details'      => collect([
                    'format' => "%d-%m-%Y"
                ])
            ])->save();
        }


        $dataRow = $this->dataRow('insurance');
        if (!$dataRow->exists) {
            $dataRow->fill([
                'type'         => 'date',
                'display_name' => 'Assicurazione',
                'required'     => 1,
                'browse'       => 0,
                'read'         => 1,
                'edit'         => 1,
                'add'          => 1,
                'delete'       => 1,
                'order'        => ++$order,
                'details'      => collect([
                    'format' => "%d-%m-%Y"
                ])
            ])->save();
        }


        $dataRow = $this->dataRow('power');
        if (!$dataRow->exists) {
            $dataRow->fill([
                'type'         => 'number',
                'display_name' => 'Potenza',
                'required'     => 1,
                'browse'       => 0,
                'read'         => 1,
                'edit'         => 1,
                'add'          => 1,
                'delete'       => 1,
                'order'        => ++$order,
            ])->save();
        }


        $dataRow = $this->dataRow('category');
        if (!$dataRow->exists) {
            $dataRow->fill([
                'type'         => 'select_dropdown',
                'display_name' => 'Categoria',
                'required'     => 1,
                'browse'       => 0,
                'read'         => 1,
                'edit'         => 1,
                'add'          => 1,
                'delete'       => 1,
                'order'        => ++$order,
                'details'      => collect([
                    "default" => "euro6",
                    "options" => [
                        // "null"=> "---",
                        "euro3"=> "Euro 3",
                        "euro4"=> "Euro 4",
                        "euro5"=> "Euro 5",
                        "euro6"=> "Euro 6",
                    ]
                ])
            ])->save();
        }
       


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

        $position = 4;

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