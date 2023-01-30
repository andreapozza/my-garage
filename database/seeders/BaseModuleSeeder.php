<?php

namespace Database\Seeders;

use Illuminate\Support\Str;
use TCG\Voyager\Models\Role;
use Illuminate\Database\Seeder;
use TCG\Voyager\Models\DataRow;
use TCG\Voyager\Models\DataType;
use TCG\Voyager\Models\Permission;
use TCG\Voyager\Models\Translation;

abstract class BaseModuleSeeder extends Seeder
{
    protected $trans = [];
    protected $permissions = true;
    protected $attach_permissions = ['admin'];
    private $dataType = true;

    abstract protected function content();
    abstract protected function dataTypesTableSeeder();
    abstract protected function dataRowsTableSeeder();
    abstract protected function menuItemsTableSeeder();

    /**
     * Auto generated seed file.
     *
     * @return void
     */
    public function run()
    {
        $this->dataTypesTableSeeder();
        $this->dataRowsTableSeeder();
        $menuItem = $this->menuItemsTableSeeder();
        $this->translations($menuItem);
        //Permissions
        if($this->permissions){
            Permission::generateFor(strtolower($this->name_plural));
            // attach new permissions to role
            foreach($this->attach_permissions as $role_name){
                $role = Role::where('name', $role_name)->firstOrFail();
                $role->permissions()->attach(
                    Permission::where('table_name', Str::lower($this->name_plural))->pluck('id')
                );
            }
        }
        $this->content();
    }
    
    /**
     * [dataRow description].
     *
     * @param [type] $type  [description]
     * @param [type] $field [description]
     *
     * @return [type] [description]
     */
    protected function dataRow($field, $type = null)
    {
        if($type == null){
            $type = $this->dataType ?? $this->defaultDataType();
        }
        return DataRow::firstOrNew([
            'data_type_id' => $type->id,
            'field'        => $field,
        ]);
    }

    /**
     * [dataType description].
     *
     * @param [type] $field [description]
     * @param [type] $for   [description]
     *
     * @return [type] [description]
     */
    protected function dataType($field, $for)
    {
        return DataType::firstOrNew([$field => $for]);
    }

    /**
     * @param string $lang
     * @param array $keys
     * @param string $value
     * @return void
     */
    protected function trans($lang, $keys, $value)
    {
        $_t = Translation::firstOrNew(array_merge($keys, [
            'locale' => $lang,
        ]));

        if (!$_t->exists) {
            $_t->fill(array_merge(
                $keys,
                ['value' => $value]
            ))->save();
        }
    }

    /**
     *
     * @param string[] $par [table_name, column_name]
     * @param int $id
     * @return array
     */
    protected function arr($par, $id)
    {
        return [
            'table_name'  => $par[0],
            'column_name' => $par[1],
            'foreign_key' => $id,
        ];
    }

    protected function translations($menuItem = false)
    {
        $dataType = DataType::where('name', Str::of($this->name_plural)->lower())->firstOrFail();

        foreach($this->trans as $lang => $values) {
            foreach($values['fields'] as $field => $value) {
                $dataRow = DataRow::where('data_type_id', $dataType->id)->where('field', $field)->firstOrFail();
                if ($dataRow->exists) {
                    $this->trans($lang, $this->arr(['data_rows', 'display_name'], $dataRow->id), $value);
                }
            }

            $this->trans($lang, $this->arr(['data_types', 'display_name_singular'], $dataType->id), $values['display_name_singular']);
            $this->trans($lang, $this->arr(['data_types', 'display_name_plural'], $dataType->id), $values['display_name_plural']);
            

            if(is_object($menuItem)){
                $this->trans($lang, $this->arr(['menu_items', 'title'], $menuItem->id), $values['menu_item_title']);
            }
        }
    }

    protected function translateContent($lang, $fields, $id, $table_name = null)
    {
        if(null === $table_name){
            $table_name = $this->name_plural;
        }
        foreach ($fields as $field => $value) {
            $this->trans($lang, $this->arr([$table_name, $field], $id), $value);
        }
    }

    protected function defaultDataType($data = [])
    {
        $name = Str::of($this->name_singular)->lower();
        $name_plural = Str::of($this->name_plural)->lower();
        $dataType = $this->dataType('name', $name_plural);
        if (!$dataType->exists) {
            $dataType->fill(array_merge([
                'slug'                  => $name_plural,
                'display_name_singular' => ucfirst(__($this->name_singular)),
                'display_name_plural'   => ucfirst(__($this->name_plural)),
                'icon'                  => $this->icon,
                'model_name'            => 'App\\Models\\'.$name->studly(),
                'controller'            => '',
                'generate_permissions'  => $this->permissions ? 1 : 0,
                'description'           => '',
                'details'               => ''
                ], $data))->save();
        }

        $this->dataType = $dataType;

        return $dataType;
    }

    /**
     * Read a CSV file and return an array of associative arrays
     *  
     * @param $file Path of file to read
     * 
     * @return array
     */
    protected function csvToArray($file)
    {
        $array = [];
        if (file_exists($file) && false !== ($stream = fopen($file, 'r'))) {
            $headers = fgetcsv($stream);
            while (false !== ($data = fgetcsv($stream))) {
                $array[] = array_combine($headers, $data);
            }
        }
        return $array;
    }

}