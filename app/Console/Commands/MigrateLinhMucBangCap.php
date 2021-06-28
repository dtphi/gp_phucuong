<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;
use App\Http\Common\Tables;
use DB;
use Illuminate\Support\Carbon;

class MigrateLinhMucBangCap extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bangcap:migrate {oldTable} {newTable}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import data from old table file to new table database';

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

        if ($arguments) {
            DB::transaction(function () use ($arguments) {
                $oldData = DB::table($arguments['oldTable'])->get();
                $numRows = $oldData->count();


                DB::statement('truncate table ' . $arguments['newTable']);
                foreach ($oldData as $data) {
                    $id = $data->id;
                    $linhMucId = $data->linhmuc_id;
                    $name = $data->name;
                    $type = $data->type;
                    $ghiChu = $data->ghichu;
                    $active = $data->active;
                    $updateUser = $data->updateuser;
                    $updateTime = $data->updatetime;

                    DB::insert('insert into ' . $arguments['newTable'] . ' (id, linh_muc_id, name, type, ghi_chu,active,update_user,update_time) values (?,?,?,?,?,?,?,?)',
                        [$id,$linhMucId,$name,$type,$ghiChu,$active,$updateUser,$updateTime]);
                    
                }

                $this->info('Migrate success from :'. $arguments['oldTable'] .' to '. $arguments['newTable'] . ': total records =' . $numRows);
            });
            
        }
    }
}
