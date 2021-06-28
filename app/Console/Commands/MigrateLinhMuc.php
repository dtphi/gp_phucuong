<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;
use App\Http\Common\Tables;
use DB;
use Illuminate\Support\Carbon;

class MigrateLinhMuc extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'linhmuc:migrate {oldTable} {newTable}';

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
                    $thanhId = $data->ten_thanh;
                    $ten = $data->ten;
                    $ngaySinh = ($data->sinhnam)?$data->sinhnam:'0000';
                    $ngaySinh .= ($data->sinhthang)?'-' . $data->sinhthang . '-':'-00-';
                    $ngaySinh .= ($data->sinhngay)?$data->sinhngay:'00';
                    $ngaySinh = $ngaySinh . $timeStr;
                    if ($data->sinhnam) {
                        $date = date_create($ngaySinh);
                        $ngaySinh = date_format($date,$formatDate);
                    }
                    if (empty($ngaySinh) || $ngaySinh == '0000-00-00 00:00:00') $ngaySinh = NULL;

                    $noiSinh = $data->noi_sinh;
                    $tenCha = $data->ten_cha;
                    $tenMe = $data->ten_me;
                    $noiRuaToi = $data->noi_rua_toi;
                    $ngayRuaToi = ($data->ruatoinam)?$data->ruatoinam:'0000' ;
                    $ngayRuaToi .= ($data->ruatoithang)?'-' . $data->ruatoithang . '-':'-00-';
                    $ngayRuaToi .= ($data->ruatoingay)?$data->ruatoingay:'00';
                    $ngayRuaToi = $ngayRuaToi . $timeStr;
                    if ($data->ruatoinam) {
                        $date = date_create($ngayRuaToi);
                        $ngayRuaToi = date_format($date,$formatDate);
                    }
                    if (empty($ngayRuaToi) || $ngayRuaToi == '0000-00-00 00:00:00') $ngayRuaToi = NULL;
                    $noiThemSuc = $data->noi_them_suc;
                    $ngayThemSuc =  ($data->themsucnam)?$data->themsucnam:'0000' ;
                    $ngayThemSuc .= ($data->themsucthang)?'-' . $data->themsucthang . '-':'-00-' ;
                    $ngayThemSuc .= ($data->themsucngay)?$data->themsucngay:'00';
                    $ngayThemSuc = $ngayThemSuc . $timeStr;
                    if ($data->themsucnam) {
                        $date = date_create($ngayThemSuc);
                        $ngayThemSuc = date_format($date,$formatDate);
                    }
                    if (empty($ngayThemSuc) || $ngayThemSuc == '0000-00-00 00:00:00') $ngayThemSuc = NULL;
                    $tieuCv = $data->tieu_cv;
                    $ngayTieuCv = ($data->tieucvnam)?$data->tieucvnam:'0000' ;
                    $ngayTieuCv .= ($data->tieucvthang)?'-' . $data->tieucvthang . '-':'-00-';
                    $ngayTieuCv .= ($data->tieucvngay)?$data->tieucvngay:'00';
                    $ngayTieuCv = $ngayTieuCv . $timeStr;
                    if ($data->tieucvnam) {
                        $date = date_create($ngayTieuCv);
                        $ngayTieuCv = date_format($date,$formatDate);
                    }
                    if (empty($ngayTieuCv) || $ngayTieuCv == '0000-00-00 00:00:00') $ngayTieuCv = NULL;
                    $daiCv = $data->dai_cv;
                    $ngayDaiCv = ($data->daicvnam)?$data->daicvnam:'0000';
                    $ngayDaiCv .= ($data->daicvthang)?'-' . $data->daicvthang . '-':'-00-';
                    $ngayDaiCv .= ($data->daicvngay)?$data->daicvngay:'00';
                    $ngayDaiCv = $ngayDaiCv . $timeStr;
                    if ($data->daicvnam) {
                        $date = date_create($ngayDaiCv);
                        $ngayDaiCv = date_format($date,$formatDate);
                    }
                    if (empty($ngayDaiCv) || $ngayDaiCv == '0000-00-00 00:00:00') $ngayDaiCv = NULL;
                    $image = !empty($data->image) ? '/Image/NewPicture/oldlinhmucs/' . $data ->image: NULL;
                    $cmnd = ($data->socmnd)?$data->socmnd:NULL;
                    $ngayCmnd = ($data->cmndnam)?$data->cmndnam:'0000';
                    $ngayCmnd .= ($data->cmndthang)?'-' . $data->cmndthang . '-':'-00-';
                    $ngayCmnd .= ($data->cmndngay)?$data->cmndngay:'00';
                    $ngayCmnd = $ngayCmnd . $timeStr;
                    if ($data->cmndnam) {
                        $date = date_create($ngayCmnd);
                        $ngayCmnd = date_format($date,$formatDate);
                    }
                    if (empty($ngayCmnd) || $ngayCmnd == '0000-00-00 00:00:00') $ngayCmnd = NULL;
                    $noiCapCmnd = $data->cmndnoicap;
                    $code = $data->code;
                    $phone = $data->phone;
                    $email = $data->email;
                    $trieuDong = $data->trieudong;
                    $dongId = $data->tendong;
                    $dongNgay = ($data->dongnam)?$data->dongnam:'0000';
                    $dongNgay .= ($data->dongthang)?'-' . $data->dongthang . '-':'-00-';
                    $dongNgay .= ($data->dongngay)?$data->dongngay:'00';
                    $dongNgay = $dongNgay . $timeStr;
                    if ($data->dongnam) {
                        $date = date_create($dongNgay);
                        $dongNgay = date_format($date,$formatDate);
                    }
                    if (empty($dongNgay) || $dongNgay == '0000-00-00 00:00:00') $dongNgay = NULL;
                    $ngayKhan =  ($data->khannam)?$data->khannam:'0000';
                    $ngayKhan .= ($data->khanthang)?'-' . $data->khanthang . '-':'-00-';
                    $ngayKhan .= ($data->khanngay)?$data->khanngay:'00';
                    $ngayKhan = $ngayKhan . $timeStr;
                    if ($data->khannam) {
                        $date = date_create($ngayKhan);
                        $ngayKhan = date_format($date,$formatDate);
                    }
                    if (empty($ngayKhan) || $ngayKhan == '0000-00-00 00:00:00') $ngayKhan = NULL;
                    $ngayRip =  ($data->ripnam)?$data->ripnam:'0000';
                    $ngayRip .= ($data->ripthang)?'-' . $data->ripthang . '-':'-00-';
                    $ngayRip .= ($data->ripngay)?$data->ripngay:'00';
                    $ngayRip = $ngayRip . $timeStr;
                    if ($data->ripnam) {
                        $date = date_create($ngayRip);
                        $ngayRip = date_format($date,$formatDate);
                    }
                    if (empty($ngayRip) || $ngayRip == '0000-00-00 00:00:00') $ngayRip = NULL;
                    $ripGiaoXu = $data->ripgiaoxu_id;
                    $ripGhiChu = $data->ripghichu;
                    $ghiChu = $data->ghichu;
                    $active = $data->active;
                    $updateUser = $data->updateuser;
                    $updateTime = $data->updatetime;

                    DB::insert('insert into ' . $arguments['newTable'] . ' (id, ten_thanh_id, ten, ngay_thang_nam_sinh, noi_sinh, ho_ten_cha, ho_ten_me,noi_rua_toi,ngay_rua_toi,noi_them_suc,ngay_them_suc,tieu_chung_vien,ngay_tieu_chung_vien,dai_chung_vien,ngay_dai_chung_vien,image,so_cmnd,ngay_cap_cmnd,noi_cap_cmnd,code,phone,email,trieu_dong,ten_dong_id,ngay_trieu_dong,ngay_khan,ngay_rip,rip_giao_xu_id,rip_ghi_chu,ghi_chu,active,update_user,created_at) values (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?, ?, ?, ?, ?, ?, ?,?,?)',
                        [$id,$thanhId,$ten,$ngaySinh,$noiSinh,$tenCha,$tenMe,$noiRuaToi,$ngayRuaToi,$noiThemSuc,$ngayThemSuc,$tieuCv,$ngayTieuCv,$daiCv,$ngayDaiCv,$image,$cmnd,$ngayCmnd,$noiCapCmnd,$code,$phone,$email,$trieuDong,$dongId,$dongNgay,$ngayKhan,$ngayRip,$ripGiaoXu,$ripGhiChu,$ghiChu,$active,$updateUser,$updateTime]);
                    
                }

                $this->info('Migrate success from :'. $arguments['oldTable'] .' to '. $arguments['newTable'] . ': total records =' . $numRows);
            });
            
        }
    }
}
