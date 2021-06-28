<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;
use App\Http\Common\Tables;
use DB;
use Illuminate\Support\Carbon;

class MigrateLinhMucChucThanh extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'chucthanh:migrate {oldTable} {newTable}';

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
                $timeStr = ' 00:00:00';
                $formatDate = "Y-m-d H:i:s";


                DB::statement('truncate table ' . $arguments['newTable']);
                foreach ($oldData as $data) {
                    $id = $data->id;
                    $linhMucId = $data->linhmuc_id;
                    $chucThanhId = $data->chucthanh;

                    $ngay = ($data->chucthanhnam)?$data->chucthanhnam:'0000';
                    $ngay .= ($data->chucthanhthang)?'-' . $data->chucthanhthang . '-':'-00-';
                    $ngay .= ($data->chucthanhngay)?$data->chucthanhngay:'00';
                    $ngay = $ngay . $timeStr;
                    if ($data->chucthanhnam) {
                        $date = date_create($ngay);
                        $ngay = date_format($date,$formatDate);
                    }
                    if (empty($ngay) || $ngay == '0000-00-00 00:00:00') $ngay = NULL;

                    $noiThuPhong = $data->noithuphong;
                    $nguoiThuPhong = $data->nguoithuphong;
                    $ghiChu = $data->ghichu;
                    $active = $data->active;
                    $updateUser = $data->updateuser;
                    $updateTime = $data->updatetime;

                    DB::insert('insert into ' . $arguments['newTable'] . ' (id, linh_muc_id, chuc_thanh_id, ngay_thang_nam_chuc_thanh, noi_thu_phong, nguoi_thu_phong,active, ghi_chu,update_user,update_time) values (?,?,?,?,?,?,?,?,?,?)',
                        [$id,$linhMucId,$chucThanhId, $ngay,$noiThuPhong,$nguoiThuPhong,$active,$ghiChu,$updateUser,$updateTime]);
                    
                }

                $this->info('Migrate success from :'. $arguments['oldTable'] .' to '. $arguments['newTable'] . ': total records =' . $numRows);
            });
            
        }
    }
}
