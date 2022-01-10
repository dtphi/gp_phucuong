<?php

namespace App\Console\Commands;

use App\Models\Category;
use App\Models\CategoryDescription;
use App\Models\CategoryPath;
use DB;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class ImportTags extends Command
{
    /**
     * php artisan import:tag tags
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:tag {srcTable} {targetTable}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import data tags';

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
     * @return int
     */
    public function handle()
    {
        $arguments = $this->arguments();

        DB::transaction(function () use ($arguments) {
            $oldData = DB::table($arguments['srcTable'])->get();
            DB::statement('truncate table ' . $arguments['targetTable']);
            foreach ($oldData as $data) {
                $id = $data->id;
                $name = $data->name;
                $nameSlug = Str::slug($data->alias);
                $createdAt = $data->created_at;
                DB::insert('insert into ' . $arguments['targetTable'] . ' (id, name, name_slug, active, update_user, created_at) values (?,?,?,?,?,?)',
                        [$id, $name, $nameSlug, 1,1,$createdAt]);
            }
        });
    }
}
