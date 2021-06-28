<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;
use App\Http\Common\Tables;
use DB;
use Illuminate\Support\Carbon;

class MigrateLinhMucThuyenChuyen extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'thuyenchuyen:migrate {oldTable} {newTable}';

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
                    $fromGxId = $data->fromgiaoxu_id;
                    $fromCvId = $data->fromchucvu_id;

                    $fromDate = ($data->datefromyear)?$data->datefromyear:'0000';
                    $fromDate .= ($data->datefrommonth)?'-' . $data->datefrommonth . '-':'-00-';
                    $fromDate .= ($data->datefromday)?$data->datefromday:'00';
                    $fromDate = $fromDate . $timeStr;
                    if ($data->datefromyear) {
                        $date = date_create($fromDate);
                        $fromDate = date_format($date,$formatDate);
                    }
                    if (empty($fromDate) || $fromDate == '0000-00-00 00:00:00') $fromDate = NULL;

                    $ducChaId = 41;
                    
                    $toDate = ($data->datetoyear)?$data->datetoyear:'0000';
                    $toDate .= ($data->datetomonth)?'-' . $data->datetomonth . '-':'-00-';
                    $toDate .= ($data->datetoday)?$data->datetoday:'00';
                    $toDate = $toDate . $timeStr;
                    if ($data->datetoyear) {
                        $date = date_create($toDate);
                        $toDate = date_format($date,$formatDate);
                    }
                    if (empty($toDate) || $toDate == '0000-00-00 00:00:00') $toDate = NULL;

                    $chucvId = $data->chucvu_id;
                    $gxId = $data->giaoxu_id;
                    $cosoId = $data->cosogp_id;
                    $dongId = $data->dong_id;
                    $banChTrId = $data->banchuyentrach_id;
                    $duHocId = $data->duhoc;
                    $quocGiaId = $data->quocgia;
                    $ghiChu = $data->ghichu;
                    $active = $data->active;
                    $updateUser = $data->updateuser;
                    $updateTime = $data->updatetime;

                    DB::insert('insert into ' . $arguments['newTable'] . ' (id, linh_muc_id, from_giao_xu_id, from_chuc_vu_id, from_date,duc_cha_id,to_date,chuc_vu_id,giao_xu_id,co_so_gp_id,dong_id,ban_chuyen_trach_id,du_hoc,quoc_gia, ghi_chu,active,update_user,update_time) values (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)',
                        [$id,$linhMucId,$fromGxId,$fromCvId,$fromDate,$ducChaId,$toDate,$chucvId,$gxId, $cosoId,$dongId,$banChTrId,$duHocId,$quocGiaId,$ghiChu,$active,$updateUser,$updateTime]);
                    
                }

                $this->info('Migrate success from :'. $arguments['oldTable'] .' to '. $arguments['newTable'] . ': total records =' . $numRows);
            });
            
        }
    }
}
