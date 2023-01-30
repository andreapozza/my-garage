<?php

namespace App\Console\Commands;

use Artisan;
use NumberFormatter;
use Illuminate\Support\Str;
use Illuminate\Console\Command;

class MakeModule extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:module {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create boilerplate files for a new module';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $model_name = $this->argument('name');

        $this->runWithExecutionTime(
            fn() => Artisan::call('make:model '.$model_name.' -ms'),
            "$model_name module creation"
        );
        $output = Artisan::output();
        if (preg_match('/^\s*info/i', $output)) {
            $this->info($output);
        }
        elseif (preg_match('/^\s*error/i', $output)) {
            $this->error($output);
        }
        else {
            $this->warn($output);
        }

        $name_singular = Str::camel($model_name);
        $name_plural = Str::pluralStudly($name_singular);

        $seeder_path = database_path('seeders').'/'.$model_name.'Seeder.php';
        $content = file_get_contents($seeder_path);

        $content = preg_replace('/use Illuminate\\\Database\\\Seeder;/', implode(PHP_EOL, [
        'use TCG\Voyager\Models\Menu;',
        'use TCG\Voyager\Models\MenuItem;',
        'use Database\Seeders\BaseModuleSeeder;'
        ]), $content);

        $content = preg_replace('/(class \w+ extends) Seeder.*/s', '$1 BaseModuleSeeder', $content);
        $content = preg_replace('/(extends BaseModuleSeeder).*/s', "$1
{
    protected \$name_singular = '$name_singular';
    protected \$name_plural   = '$name_plural';
    protected \$icon          = 'voyager-puzzle';

    public function content()
    {
        \$file = __DIR__.'/$name_plural.csv';
        \$$name_plural = \$this->csvToArray(\$file);
        \\App\\Models\\".ucfirst($name_singular)."::insert(\$$name_plural);
    }

    protected function dataTypesTableSeeder()
    {
        /*
        \$data = [
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
        \$this->defaultDataType(/*\$data*/);
    }

    protected function dataRowsTableSeeder()
    {
        \$order = 0;
        \$dataRow = \$this->dataRow('id');
        if (!\$dataRow->exists) {
            \$dataRow->fill([
                'type'         => 'number',
                'display_name' => __('voyager::seeders.data_rows.id'),
                'required'     => 1,
                'browse'       => 0,
                'read'         => 0,
                'edit'         => 0,
                'add'          => 0,
                'delete'       => 0,
                'order'        => ++\$order,
            ])->save();
        }


        /*
        \$dataRow = \$this->dataRow('name');
        if (!\$dataRow->exists) {
            \$dataRow->fill([
                'type'         => 'text',
                'display_name' => 'Nome',
                'required'     => 1,
                'browse'       => 1,
                'read'         => 1,
                'edit'         => 1,
                'add'          => 1,
                'delete'       => 1,
                'order'        => ++\$order,
            ])->save();
        }
        */



        /*
        * ----------------
        * RELATION
        * -----------------
        */

        /*
        \$dataRow = \$this->dataRow('user_id');
        if (!\$dataRow->exists) {
            \$dataRow->fill([
                'type'         => 'number',
                'display_name' => 'Utente',
                'required'     => 0,
                'browse'       => 1,
                'read'         => 1,
                'edit'         => 1,
                'add'          => 1,
                'delete'       => 1,
                'order'        => ++\$order,
            ])->save();
        }

        \$dataRow = \$this->dataRow('".$name_singular."_belongsto_users_relationship');
        if (!\$dataRow->exists) {
            \$dataRow->fill([
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
                'order'        => ++\$order,
            ])->save();
        }
        */



        /*
        * ----------------
        * IMAGE
        * -----------------
        */

        /*
        \$dataRow = \$this->dataRow('image');
        if (!\$dataRow->exists) {
            \$dataRow->fill([
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
                'order' => ++\$order,
            ])->save();
        }
        */


        \$dataRow = \$this->dataRow('created_at');
        if (!\$dataRow->exists) {
            \$dataRow->fill([
                'type'         => 'timestamp',
                'display_name' => __('voyager::seeders.data_rows.created_at'),
                'required'     => 0,
                'browse'       => 0,
                'read'         => 1,
                'edit'         => 0,
                'add'          => 0,
                'delete'       => 0,
                'order'        => ++\$order,
            ])->save();
        }

        \$dataRow = \$this->dataRow('updated_at');
        if (!\$dataRow->exists) {
            \$dataRow->fill([
                'type'         => 'timestamp',
                'display_name' => __('voyager::seeders.data_rows.updated_at'),
                'required'     => 0,
                'browse'       => 0,
                'read'         => 0,
                'edit'         => 0,
                'add'          => 0,
                'delete'       => 0,
                'order'        => ++\$order,
            ])->save();
        }
    }

    protected function menuItemsTableSeeder()
    {
        \$menu = Menu::where('name', 'admin')->firstOrFail();

        \$position = 3;

        \$menu->items()->where('order', '>=', \$position)->increment('order');

        \$menuItem = MenuItem::firstOrNew([
            'menu_id' => \$menu->id,
            'title'   => __(\$this->name_plural),
            'url'     => '',
            'route'   => 'voyager.'.\$this->name_plural.'.index',
        ]);
        if (!\$menuItem->exists) {
            \$menuItem->fill([
                'target'     => '_self',
                'icon_class' => \$this->icon,
                'color'      => null,
                'parent_id'  => null,
                'order'      => \$position,
            ])->save();
        }

        return \$menuItem;
    }
}", $content);

        file_put_contents($seeder_path, $content);

        return Command::SUCCESS;
    }

    private function runWithExecutionTime($callable, $task)
    {
        $this->line('');
        echo $task . ' ';
        $c = 131 - strlen($task);
        for ($i=0; $i < $c; $i++) { 
            echo '.';
        }
        echo ' ';
        $this->comment('RUNNING');
        $time_start = microtime(true);
        $callable();
        $time_end = microtime(true);
        $time_formatted = NumberFormatter::create('en', NumberFormatter::DECIMAL)->format($time_end - $time_start, NumberFormatter::TYPE_DOUBLE) . ' ms ';
        $c -= strlen($time_formatted);
        echo $task . ' ';
        for ($i=0; $i < $c; $i++) { 
            echo '.';
        }
        echo ' ';
        echo $time_formatted;
        $this->info('DONE');
    }
}
