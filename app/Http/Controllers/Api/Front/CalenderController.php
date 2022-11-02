<?php

namespace App\Http\Controllers\Api\Front;

use App\Http\Controllers\Api\Admin\Services\Contracts\NgayLeModel;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\Front\Base\ApiController as Controller;
use Illuminate\Http\Response as HttpResponse;
use Illuminate\Support\Arr;
use stdClass;

use function PHPUnit\Framework\matches;

class CalenderController extends Controller
{
  public function __construct()
  {
  }

  public function getpam(Request $request)
  {
    //$data = $request->data;Gn 1,1–2,1.11
    $data = $request->data;
    $data=$this->codeToAtt($data);
    //dd($data);
    if (count($data)<=1){
      $sach = $data[0]->sach;
      $chuong = $data[0]->chuong;
      $lstcau = $data[0]->lstcau;
      
      $strwherels = [];
      foreach ($lstcau as $item) {
        if (count($item) > 1) {
          $strwherels[] = "(cau BETWEEN $item[0] and $item[1])";
        } else if (!empty($item[0])) {
          $strwherels[] = "(cau = $item[0])";
        }
      }
      $strwhere = join(' or ', $strwherels);
  
      $sql = sprintf("ten='%s' and chuong='%s' and ($strwhere) ORDER BY cau", $sach, $chuong);
  
      $res = \DB::table('kinh_thanhs')
        ->whereRaw($sql)
        ->get();
      return $res;
    }
    else {
      //dd($data);
      $sach = $data[0]->sach;
      $codecaulst=array();
      foreach($data as $key=>$value){
        $chuong=$value->chuong;
        $lstcau=$value->lstcau;
        foreach($lstcau as $cau){
          if (substr_count($cau,'-')<1){
            array_push($codecaulst,str_pad($chuong, 3, '0', STR_PAD_LEFT).str_pad($cau, 3, '0', STR_PAD_LEFT));
          }
        }
      }
      if (count($codecaulst)>2){
        $caucodecaulstOR=array_slice($codecaulst,2);
        $strwherels = [];
        foreach($caucodecaulstOR as $item){
          $strwhere[]="CONCAT(LPAD(chuong, 3, '0'), LPAD(cau, 3, '0')) = '$item'";
        }
        $strwheresql=join(' or ', $strwhere);
        $sql = sprintf("ten='%s' 
        and CONCAT(LPAD(chuong, 3, '0'), LPAD(cau, 3, '0')) >= '%s' 
        and (CONCAT(LPAD(chuong, 3, '0'), LPAD(cau, 3, '0')) <= '%s'
        or $strwheresql)",$sach,$codecaulst[0],$codecaulst[1]);
      }
      else{
        $sql = sprintf("ten='%s' 
        and CONCAT(LPAD(chuong, 3, '0'), LPAD(cau, 3, '0')) >= '%s' 
        and CONCAT(LPAD(chuong, 3, '0'), LPAD(cau, 3, '0')) <= '%s'",$sach,$codecaulst[0],$codecaulst[1]);
      }

      $res = \DB::table('kinh_thanhs')
      ->whereRaw($sql)
      ->get();
      return $res;
    }

  }
  public function codeToAtt($str_phucam){
    $so_chuong=substr_count($str_phucam,',');
    
    if ($so_chuong<=1){
      $matches = array();
      preg_match('/^\S+ /',$str_phucam, $matches);
      $sach=trim($matches[0],' ');
      preg_match('/^\S+ (.*),/',$str_phucam,$matches);
      $chuong = $matches[1].trim(' ');
      preg_match('/^\S+ \d+,(.*)/',$str_phucam,$matches);
      $caus =$matches[1].trim(' ');
      //dd($sach.'/'.$chuong.'/'.$caus);
      $causp = explode(".", $caus);

      $lstcau =array();
      foreach( $causp as $cauitem){
        $cas = explode("-", $cauitem);
        foreach($cas as $key=>$value){
          $cas[$key]=preg_replace('/\D/','',$value);
        }
        array_push($lstcau,$cas);
      }
      
      $phucs_am_object = (object) [
        'sach' => $sach,
        'chuong' => $chuong,
        'lstcau' => $lstcau,
        'so_chuong' => $so_chuong
      ];
      //dd( $phucs_am_object);
      return array($phucs_am_object);
    }
    else {
      $str_phucam_replace=str_replace('–','-',$str_phucam);
      $chuongsp = explode("-", $str_phucam_replace);
      $matches = array();
      preg_match('/^\S+ /',$str_phucam_replace, $matches);
      $sach=trim($matches[0],' ');
      $lstchuong= array();
      //dd($chuongsp);
      foreach($chuongsp as $chuongitem){
        $lstcau=array();
        if(substr_count($chuongitem,',')===0)
        {
        $current_lstcau=$lstchuong[array_key_last($lstchuong)]->lstcau;
        $current_cau=$current_lstcau[array_key_last($current_lstcau)];
        $lstchuong[array_key_last($lstchuong)]->lstcau[array_key_last($current_lstcau)].='-'.$chuongitem;
        } else
        {preg_match('/\d+,/',$chuongitem, $matches);
        $chuong=str_replace(',','',$matches[0]);
        preg_match('/,\d+((\.)?(\d+)?)+/',$chuongitem, $matches);
        $caus=str_replace(',','',$matches[0]);
        $causp = explode(".", $caus);
        foreach( $causp as $cauitem){
          //$cas = explode("-", $cauitem);
          preg_replace('/\D/','',$cauitem);
          array_push($lstcau,$cauitem);
        }
    
        $phucs_am_object = (object) [
          'sach' => $sach,
          'chuong' => $chuong,
          'lstcau' => $lstcau,
          'so_chuong' => $so_chuong
        ];

        array_push($lstchuong,$phucs_am_object);
      }
      }
      //dd($lstchuong);
      return $lstchuong;
    }
  }
  public function getlist(Request $request)
  {
    $month = empty($request->month) ? date('m') : $request->month;
    $year = empty($request->year) ? date('Y') : $request->year;
    return $this->GetFullLichAndLe($month, $year);
  }

  public function GetFullLichAndLe($month, $year)
  {
    $NgayLe = $this->getCacNgayLeTrongNam($year);
    $NgayLeThang = array_filter(
      $NgayLe,
      function ($item) use ($month) {
        return $item->month == $month;
      }
    );

    $lich = $this->getFullCal($month, $year);

    foreach ($lich as $item) {

      $mm = array_filter($NgayLeThang, function ($itemfilter) use ($item) {
        return $itemfilter->day == $item->day && $itemfilter->month == $item->month && $itemfilter->year == $item->year;
      });
      $item->le =  $mm;
    }

    return $lich;
  }


  public function is_leap_year($year)
  {
    return $year % 4 == 0 && ($year % 100 != 0 || $year % 400 == 0);
  }


  public function getFullCal($month, $year)
  {
    $listMonth = $this->getListCal($month, $year);

    $start = $listMonth[0];
    $dayAddStart = $start->n == 7 ? 0 : $start->n;

    $end = $listMonth[count($listMonth) - 1];
    $dayAddEnd = $end->n == 7 ? 6 : 6 - $end->n;
    $listAfter = [];
    $listBefore = [];

    for ($i = $dayAddStart; $i >= 1; $i--) {
      $newdate = strtotime("-$i day", strtotime($start->year . "-" . $start->month . "-" . $start->day));
      $daym = date("d", $newdate);
      $monthm = date("m", $newdate);
      $yearm = date("Y", $newdate);
      $listAfter[] = $this->itemCal($daym, $monthm, $yearm);
    }

    for ($i = 1; $i <= $dayAddEnd; $i++) {
      $newdate = strtotime("+$i day", strtotime($end->year . "-" . $end->month . "-" . $end->day));
      $daym = date("d", $newdate);
      $monthm = date("m", $newdate);
      $yearm = date("Y", $newdate);
      $listBefore[] = $this->itemCal($daym, $monthm, $yearm);
    }

    $result = array_merge($listAfter, $listMonth, $listBefore);

    return $result;
  }



  public function itemCal($day, $month, $year)
  {
    $todayd = date("d");
    $todaym = date("m");
    $todayy = date("Y");
    $item = new stdClass();
    $item->day = $day;
    $item->month = $month;
    $item->year = $year;
    $item->namthanh = $this->TinhNam($year);
    $item->isToday = $day == $todayd && $month == $todaym && $year == $todayy;
    $item->amlich = $this->getAL($day, $month, $year);
    $item->l = $this->WeekdayVi($day, $month, $year);
    $item->n = strtolower(date('N', strtotime("$year-$month-$day")));
    return $item;
  }

  public function getListCal($month, $year)
  {
    $totalDay = cal_days_in_month(0, $month, $year);
    $list = [];
    for ($i = 1; $i <= $totalDay; $i++) {
      $list[] = $this->itemCal($i, $month, $year);
    }
    return $list;
  }

  public function WeekdayVi($day, $month, $year)
  {
    $weekday = strtolower(date('l', strtotime("$year-$month-$day")));
    switch ($weekday) {
      case 'monday':
        $weekday = 'Thứ hai';
        break;
      case 'tuesday':
        $weekday = 'Thứ ba';
        break;
      case 'wednesday':
        $weekday = 'Thứ tư';
        break;
      case 'thursday':
        $weekday = 'Thứ năm';
        break;
      case 'friday':
        $weekday = 'Thứ sáu';
        break;
      case 'saturday':
        $weekday = 'Thứ bảy';
        break;
      default:
        $weekday = 'Chủ nhật';
        break;
    }
    return $weekday;
  }

  public function getAL($day, $month, $year)
  {
    $al = $this->convertSolar2Lunar($day, $month, $year, 7);
    $item = new stdClass();
    $item->day = $al[0];
    $item->month = $al[1];
    $item->year = $this->canchi($year);
    return $item;
  }

  public function INT($d)
  {
    return floor($d);
  }

  public function jdFromDate($dd, $mm, $yy)
  {
    $a = $this->INT((14 - $mm) / 12);
    $y = $yy + 4800 - $a;
    $m = $mm + 12 * $a - 3;
    $jd = $dd + $this->INT((153 * $m + 2) / 5) + 365 * $y + $this->INT($y / 4) - $this->INT($y / 100) + $this->INT($y / 400) - 32045;
    if ($jd < 2299161) {
      $jd = $dd + $this->INT((153 * $m + 2) / 5) + 365 * $y + $this->INT($y / 4) - 32083;
    }
    return $jd;
  }

  public function jdToDate($jd)
  {
    if ($jd > 2299160) { // After 5/10/1582, Gregorian calendar
      $a = $jd + 32044;
      $b = $this->INT((4 * $a + 3) / 146097);
      $c = $a - $this->INT(($b * 146097) / 4);
    } else {
      $b = 0;
      $c = $jd + 32082;
    }
    $d = $this->INT((4 * $c + 3) / 1461);
    $e = $c - $this->INT((1461 * $d) / 4);
    $m = $this->INT((5 * $e + 2) / 153);
    $day = $e - $this->INT((153 * $m + 2) / 5) + 1;
    $month = $m + 3 - 12 * $this->INT($m / 10);
    $year = $b * 100 + $d - 4800 + $this->INT($m / 10);
    //echo "day = $day, month = $month, year = $year\n";
    return array($day, $month, $year);
  }

  public function getNewMoonDay($k, $timeZone)
  {
    $T = $k / 1236.85; // Time in Julian centuries from 1900 January 0.5
    $T2 = $T * $T;
    $T3 = $T2 * $T;
    $dr = M_PI / 180;
    $Jd1 = 2415020.75933 + 29.53058868 * $k + 0.0001178 * $T2 - 0.000000155 * $T3;
    $Jd1 = $Jd1 + 0.00033 * sin((166.56 + 132.87 * $T - 0.009173 * $T2) * $dr); // Mean new moon
    $M = 359.2242 + 29.10535608 * $k - 0.0000333 * $T2 - 0.00000347 * $T3; // Sun's mean anomaly
    $Mpr = 306.0253 + 385.81691806 * $k + 0.0107306 * $T2 + 0.00001236 * $T3; // Moon's mean anomaly
    $F = 21.2964 + 390.67050646 * $k - 0.0016528 * $T2 - 0.00000239 * $T3; // Moon's argument of latitude
    $C1 = (0.1734 - 0.000393 * $T) * sin($M * $dr) + 0.0021 * sin(2 * $dr * $M);
    $C1 = $C1 - 0.4068 * sin($Mpr * $dr) + 0.0161 * sin($dr * 2 * $Mpr);
    $C1 = $C1 - 0.0004 * sin($dr * 3 * $Mpr);
    $C1 = $C1 + 0.0104 * sin($dr * 2 * $F) - 0.0051 * sin($dr * ($M + $Mpr));
    $C1 = $C1 - 0.0074 * sin($dr * ($M - $Mpr)) + 0.0004 * sin($dr * (2 * $F + $M));
    $C1 = $C1 - 0.0004 * sin($dr * (2 * $F - $M)) - 0.0006 * sin($dr * (2 * $F + $Mpr));
    $C1 = $C1 + 0.0010 * sin($dr * (2 * $F - $Mpr)) + 0.0005 * sin($dr * (2 * $Mpr + $M));
    if ($T < -11) {
      $deltat = 0.001 + 0.000839 * $T + 0.0002261 * $T2 - 0.00000845 * $T3 - 0.000000081 * $T * $T3;
    } else {
      $deltat = -0.000278 + 0.000265 * $T + 0.000262 * $T2;
    };
    $JdNew = $Jd1 + $C1 - $deltat;
    //echo "JdNew = $JdNew\n";
    return $this->INT($JdNew + 0.5 + $timeZone / 24);
  }

  public function getSunLongitude($jdn, $timeZone)
  {
    $T = ($jdn - 2451545.5 - $timeZone / 24) / 36525; // Time in Julian centuries from 2000-01-01 12:00:00 GMT
    $T2 = $T * $T;
    $dr = M_PI / 180; // degree to radian
    $M = 357.52910 + 35999.05030 * $T - 0.0001559 * $T2 - 0.00000048 * $T * $T2; // mean anomaly, degree
    $L0 = 280.46645 + 36000.76983 * $T + 0.0003032 * $T2; // mean longitude, degree
    $DL = (1.914600 - 0.004817 * $T - 0.000014 * $T2) * sin($dr * $M);
    $DL = $DL + (0.019993 - 0.000101 * $T) * sin($dr * 2 * $M) + 0.000290 * sin($dr * 3 * $M);
    $L = $L0 + $DL; // true longitude, degree
    //echo "\ndr = $dr, M = $M, T = $T, DL = $DL, L = $L, L0 = $L0\n";
    $L = $L * $dr;
    $L = $L - M_PI * 2 * ($this->INT($L / (M_PI * 2))); // Normalize to (0, 2*PI)
    return $this->INT($L / M_PI * 6);
  }

  public function getLunarMonth11($yy, $timeZone)
  {
    $off = $this->jdFromDate(31, 12, $yy) - 2415021;
    $k = $this->INT($off / 29.530588853);
    $nm = $this->getNewMoonDay($k, $timeZone);
    $sunLong = $this->getSunLongitude($nm, $timeZone); // sun longitude at local midnight
    if ($sunLong >= 9) {
      $nm = $this->getNewMoonDay($k - 1, $timeZone);
    }
    return $nm;
  }

  public function getLeapMonthOffset($a11, $timeZone)
  {
    $k = $this->INT(($a11 - 2415021.076998695) / 29.530588853 + 0.5);
    $last = 0;
    $i = 1; // We start with the month following lunar month 11
    $arc = $this->getSunLongitude($this->getNewMoonDay($k + $i, $timeZone), $timeZone);
    do {
      $last = $arc;
      $i = $i + 1;
      $arc = $this->getSunLongitude($this->getNewMoonDay($k + $i, $timeZone), $timeZone);
    } while ($arc != $last && $i < 14);
    return $i - 1;
  }

  /* Comvert solar date dd/mm/yyyy to the corresponding lunar date */
  public function convertSolar2Lunar($dd, $mm, $yy, $timeZone)
  {
    $dayNumber = $this->jdFromDate($dd, $mm, $yy);
    $k = $this->INT(($dayNumber - 2415021.076998695) / 29.530588853);
    $monthStart = $this->getNewMoonDay($k + 1, $timeZone);
    if ($monthStart > $dayNumber) {
      $monthStart = $this->getNewMoonDay($k, $timeZone);
    }
    $a11 = $this->getLunarMonth11($yy, $timeZone);
    $b11 = $a11;
    if ($a11 >= $monthStart) {
      $lunarYear = $yy;
      $a11 = $this->getLunarMonth11($yy - 1, $timeZone);
    } else {
      $lunarYear = $yy + 1;
      $b11 = $this->getLunarMonth11($yy + 1, $timeZone);
    }
    $lunarDay = $dayNumber - $monthStart + 1;
    $diff = $this->INT(($monthStart - $a11) / 29);
    $lunarLeap = 0;
    $lunarMonth = $diff + 11;
    if ($b11 - $a11 > 365) {
      $leapMonthDiff = $this->getLeapMonthOffset($a11, $timeZone);
      if ($diff >= $leapMonthDiff) {
        $lunarMonth = $diff + 10;
        if ($diff == $leapMonthDiff) {
          $lunarLeap = 1;
        }
      }
    }
    if ($lunarMonth > 12) {
      $lunarMonth = $lunarMonth - 12;
    }
    if ($lunarMonth >= 11 && $diff < 4) {
      $lunarYear -= 1;
    }
    return array($lunarDay, $lunarMonth, $lunarYear, $lunarLeap);
  }

  /* Convert a lunar date to the corresponding solar date */
  public function convertLunar2Solar($lunarDay, $lunarMonth, $lunarYear, $lunarLeap, $timeZone)
  {
    if ($lunarMonth < 11) {
      $a11 = $this->getLunarMonth11($lunarYear - 1, $timeZone);
      $b11 = $this->getLunarMonth11($lunarYear, $timeZone);
    } else {
      $a11 = $this->getLunarMonth11($lunarYear, $timeZone);
      $b11 = $this->getLunarMonth11($lunarYear + 1, $timeZone);
    }
    $k = $this->INT(0.5 + ($a11 - 2415021.076998695) / 29.530588853);
    $off = $lunarMonth - 11;
    if ($off < 0) {
      $off += 12;
    }
    if ($b11 - $a11 > 365) {
      $leapOff = $this->getLeapMonthOffset($a11, $timeZone);
      $leapMonth = $leapOff - 2;
      if ($leapMonth < 0) {
        $leapMonth += 12;
      }
      if ($lunarLeap != 0 && $lunarMonth != $leapMonth) {
        return array(0, 0, 0);
      } else if ($lunarLeap != 0 || $off >= $leapOff) {
        $off += 1;
      }
    }
    $monthStart = $this->getNewMoonDay($k + $off, $timeZone);
    return $this->jdToDate($monthStart + $lunarDay - 1);
  }

  public function canchi($nam_dl)
  {
    $mang_can = array("Quý", "Giáp", "Ất", "Bính", "Đinh", "Mậu", "Kỉ", "Canh", "Tân", "Nhâm");
    $mang_chi = array("Hợi", "Tý", "Sửu", "Dần", "Mão", "Thìn", "Tỵ", "Ngọ", "Mùi", "Thân", "Dậu", "Tuất");
    $nam_dl = $nam_dl - 3;
    $can = $nam_dl % 10;
    $chi = $nam_dl % 12;
    $nam_al = $mang_can[$can] . " " . $mang_chi[$chi];
    return $nam_al;
  }


  public function getCacNgayLeTrongNam($year)
  {
    $colpm = $this->TinhNam2ColDB($year);
    $NgayLeDB = \DB::table('pc_ngay_les')
      ->selectRaw("id,code,solar_day,solar_month,lunar_day,lunar_month,ten_le,$colpm as phucam");
    $NgayLeDL = $NgayLeDB->clone()->whereRaw('solar_day > 0')->get();
    $NgayLeAL = $NgayLeDB->clone()->whereRaw('lunar_day > 0')->get();
    $lstleBonMang = [];
    $lstNgayLeDL = [];
    foreach ($NgayLeDL as $item) {
      $m = new stdClass();
      $m->day = $item->solar_day;
      $m->month = $item->solar_month;
      $m->year = $year;
      $m->date =  "$year-$item->solar_month-$item->solar_day";     // $item['solar_day']."-".$item['solar_month']."-".$year.'-';
      $m->code = $item->code;
      $m->idngayle = $item->id;
      $m->name = $item->ten_le;
      $m->type = 2;
      $m->phucam = html_entity_decode($item->phucam);
      $lstNgayLeDL[] =  $m;
    }

    $lstNgayLeAL = [];
    foreach ($NgayLeAL as $item) {
      $m = new stdClass();
      $leap = $this->is_leap_year($year);
      $dl = $this->convertLunar2Solar($item->lunar_day, $item->lunar_month, $year, $leap, 7);
      $m->day = $dl[0];
      $m->month = $dl[1];
      $m->year = $dl[2];
      $m->dateal = $item->lunar_day . "-" . $item->lunar_month . "-" . $year;
      $m->date = $dl[0] . "-" . $dl[1] . "-" . $dl[2];
      $m->name = $item->ten_le;
      $m->idngayle = $item->id;
      $m->phucam = html_entity_decode($item->phucam);
      $m->type = 3;
      $lstNgayLeAL[] = $m;
    }

    $leTinh = $this->catholiccalendar($year);

    $lstLeTinh = [];

    foreach ($leTinh as $k => $v) {
      foreach ($v as $item) {
        $m = new stdClass();
        $dl = explode('-', $k);
        $m->day = $dl[2];
        $m->month = $dl[1];
        $m->year = $dl[0];
        $m->date = $k;
        $m->code = $item;
        $m->type = 4;
        $ls = $NgayLeDB->clone()->where(['code' => $item])->first();
        if (!empty($ls)) {
          $m->name = $ls->ten_le;
          $m->idngayle = $ls->id;
          $m->phucam = html_entity_decode($ls->phucam);
        }
        $lstLeTinh[] = $m;
      }
    }
    $res = array_merge($lstleBonMang, $lstNgayLeDL, $lstNgayLeAL, $lstLeTinh);
    return $res;
  }

  function TinhNam($year){
    $stry = strval($year);
    $sum = 0;
    for($i=0;$i<strlen($stry);$i++){
        $sum+=$stry[$i];
    }
    if($sum%3 == 0)
        return "C";
    else if($sum%3 == 1)
        return "A";
    else if($sum%3 == 2)
        return "B";
}

function TinhNam2ColDB($year){
    $type = $this->TinhNam($year);
    $chanle = "i";
    if($year%2==0){
        $chanle = "ii";
    }
    return strtolower("nam_".$type."$chanle");
}

  public function lookupEaster($y = 2000)
  {
    $c = intval($y / 100);
    $n = $y - (19 * intval($y / 19));
    $k = intval(($c - 17) / 25);
    $i = $c - intval($c / 4) - intval(($c - $k) / 3) + 19 * $n + 15;
    $i = $i - 30 * intval($i / 30);
    $i = $i - intval($i / 28) * (1 - intval($i / 28) * intval(29 / ($i + 1)) * intval((21 - $n) / 11));
    $j = $y + intval($y / 4) + $i + 2 - $c + intval($c / 4);
    $j = $j - 7 * intval($j / 7);
    $l = $i - $j;
    $m = 3 + intval(($l + 40) / 44);
    $d = $l + 28 - 31 * intval($m / 4);
    return date($y . '-' . $m . '-' . $d);
  }

  public function findNameByCode($code)
  {
    return $code;
  }

  public function catholiccalendar($year)
  {

    $data['Calendar']['year'] = $year;
    // $data['Calendar']['month'] = date('m');
    $date_ceremonys = array();
    //$lastday = date('t',strtotime($data['Calendar']['year'].'-'.$data['Calendar']['month'].'-01'));

    // Lay nhung le kinh nho
    //getNgayle($data['Calendar']['year'], $data['Calendar']['month'],$lastday,$date_ceremonys);
    // Mua Chay
    $dayEaster = date('Y-m-d', strtotime($this->lookupEaster($data['Calendar']['year'])));
    $date_ceremonys[$dayEaster][] = $this->findNameByCode('PS011');

    $ar_dayEaster = explode('-', $dayEaster);
    for ($i = 1; $i < 7; $i++) {
      $tuanbatnhat = date('Y-m-d', mktime(0, 0, 0, $ar_dayEaster[1], intval($ar_dayEaster[2] + $i), $ar_dayEaster[0]));
      $date_ceremonys[$tuanbatnhat][] = $this->findNameByCode('PS01' . ($i + 1));
    }

    for ($i = 1; $i < 7; $i++) {
      $tuanthanh = date('Y-m-d', mktime(0, 0, 0, $ar_dayEaster[1], intval($ar_dayEaster[2] - $i), $ar_dayEaster[0]));
      $date_ceremonys[$tuanthanh][] = $this->findNameByCode('TUAN_THANH' . (8 - $i));
    }
    $cnhatll = date('Y-m-d', mktime(0, 0, 0, $ar_dayEaster[1], $ar_dayEaster[2] - 7, $ar_dayEaster[0]));
    $date_ceremonys[$cnhatll][] = $this->findNameByCode('CNLLA');

    $cnhat5mc = date('Y-m-d', mktime(0, 0, 0, $ar_dayEaster[1], $ar_dayEaster[2] - 14, $ar_dayEaster[0]));
    $cnhat4mc = date('Y-m-d', mktime(0, 0, 0, $ar_dayEaster[1], $ar_dayEaster[2] - 21, $ar_dayEaster[0]));
    $cnhat3mc = date('Y-m-d', mktime(0, 0, 0, $ar_dayEaster[1], $ar_dayEaster[2] - 28, $ar_dayEaster[0]));
    $cnhat2mc = date('Y-m-d', mktime(0, 0, 0, $ar_dayEaster[1], $ar_dayEaster[2] - 35, $ar_dayEaster[0]));
    $cnhat1mc = date('Y-m-d', mktime(0, 0, 0, $ar_dayEaster[1], $ar_dayEaster[2] - 42, $ar_dayEaster[0]));


    $date_ceremonys[$cnhat5mc][] = $this->findNameByCode('CH051');
    $tmp = explode('-', $cnhat5mc);
    for ($i = 1; $i < 7; $i++) {
      $muachayngaythuong = date('Y-m-d', mktime(0, 0, 0, $tmp[1], intval($tmp[2] + $i), $tmp[0]));
      $date_ceremonys[$muachayngaythuong][] = $this->findNameByCode('CH05' . ($i + 1));
    }
    $date_ceremonys[$cnhat4mc][] = $this->findNameByCode('CH041');
    $tmp = explode('-', $cnhat4mc);
    for ($i = 1; $i < 7; $i++) {
      $muachayngaythuong = date('Y-m-d', mktime(0, 0, 0, $tmp[1], intval($tmp[2] + $i), $tmp[0]));
      $date_ceremonys[$muachayngaythuong][] = $this->findNameByCode('CH04' . ($i + 1));
    }

    $date_ceremonys[$cnhat3mc][] = $this->findNameByCode('CH031');
    $tmp = explode('-', $cnhat3mc);
    for ($i = 1; $i < 7; $i++) {
      $muachayngaythuong = date('Y-m-d', mktime(0, 0, 0, $tmp[1], intval($tmp[2] + $i), $tmp[0]));
      $date_ceremonys[$muachayngaythuong][] = $this->findNameByCode('CH03' . ($i + 1));
    }

    $date_ceremonys[$cnhat2mc][] = $this->findNameByCode('CH021');
    $tmp = explode('-', $cnhat2mc);
    for ($i = 1; $i < 7; $i++) {
      $muachayngaythuong = date('Y-m-d', mktime(0, 0, 0, $tmp[1], intval($tmp[2] + $i), $tmp[0]));
      $date_ceremonys[$muachayngaythuong][] = $this->findNameByCode('CH02' . ($i + 1));
    }
    $date_ceremonys[$cnhat1mc][] = $this->findNameByCode('CH011');
    $tmp = explode('-', $cnhat1mc);
    for ($i = 1; $i < 7; $i++) {
      $muachayngaythuong = date('Y-m-d', mktime(0, 0, 0, $tmp[1], intval($tmp[2] + $i), $tmp[0]));
      $date_ceremonys[$muachayngaythuong][] = $this->findNameByCode('CH01' . ($i + 1));
    }

    $letro = date('Y-m-d', mktime(0, 0, 0, $ar_dayEaster[1], $ar_dayEaster[2] - 46, $ar_dayEaster[0]));
    $date_ceremonys[$letro][] = $this->findNameByCode('LETRO');

    $thunamsauletro = date('Y-m-d', mktime(0, 0, 0, $ar_dayEaster[1], $ar_dayEaster[2] - 45, $ar_dayEaster[0]));
    $thusausauletro = date('Y-m-d', mktime(0, 0, 0, $ar_dayEaster[1], $ar_dayEaster[2] - 44, $ar_dayEaster[0]));
    $thubaysauletro = date('Y-m-d', mktime(0, 0, 0, $ar_dayEaster[1], $ar_dayEaster[2] - 43, $ar_dayEaster[0]));

    $date_ceremonys[$thunamsauletro][] = $this->findNameByCode('TR005');
    $date_ceremonys[$thusausauletro][] = $this->findNameByCode('TR006');
    $date_ceremonys[$thubaysauletro][] = $this->findNameByCode('TR007');


    //Tinh tu dau nam
    $date_ceremonys[$data['Calendar']['year'] . '-01-01'][] = $this->findNameByCode('DUC_ME_ME_TCHUA');
    $lehienlinh = "";
    $chuachiupheprua = "";
    for ($i = 2; $i <= 8; $i++) {
      if (date('l', strtotime($data['Calendar']['year'] . '-01-' . $i)) == "Sunday") {
        $lehienlinh = date('Y-m-d', strtotime($data['Calendar']['year'] . '-01-' . $i));
        $date_ceremonys[$lehienlinh][] = $this->findNameByCode('LEHIENLINH011');
        $k = 7;
        for ($j = ($i - 1); $j > 1; $j--) {
          $truochienlinh = date('Y-m-d', strtotime($data['Calendar']['year'] . '-01-' . $j));
          $date_ceremonys[$truochienlinh][] = $this->findNameByCode('LEHIENLINH01' . $k);
          $k--;
        }
        if ($i == 7 || $i == 8) {
          $chuachiupheprua = date('Y-m-d', strtotime($data['Calendar']['year'] . '-01-' . ($i + 1)));
          $date_ceremonys[$chuachiupheprua][] = $this->findNameByCode('CGSPR');
        } else {
          $chuachiupheprua = date('Y-m-d', strtotime($data['Calendar']['year'] . '-01-' . ($i + 7)));
          $date_ceremonys[$chuachiupheprua][] = $this->findNameByCode('CGSPR');
        }
        break;
      }
    }
    $tmp = explode('-', $chuachiupheprua);
    $thuongniennext = "";
    if (date('l', strtotime($chuachiupheprua)) == "Sunday") {
      $thuongniennext = date('Y-m-d', mktime(0, 0, 0, $tmp[1], intval($tmp[2] + 7), $tmp[0]));
    } else {

      $thuongniennext = date('Y-m-d', mktime(0, 0, 0, $tmp[1], intval($tmp[2] + 6), $tmp[0]));
    }
    $date_ceremonys[$thuongniennext][] = $this->findNameByCode('TN021');
    $tmp = explode('-', $thuongniennext);
    for ($i = 1; $i < 7; $i++) {
      $thuongnienngaythuong = date('Y-m-d', mktime(0, 0, 0, $tmp[1], intval($tmp[2] - $i), $tmp[0]));
      $date_ceremonys[$thuongnienngaythuong][] = $this->findNameByCode('TN01' . (8 - $i));
    }
    for ($i = 1; $i < 7; $i++) {
      $thuongnienngaythuong = date('Y-m-d', mktime(0, 0, 0, $tmp[1], intval($tmp[2] + $i), $tmp[0]));
      $date_ceremonys[$thuongnienngaythuong][] = $this->findNameByCode('TN02' . ($i + 1));
    }

    $tmp = explode('-', $thuongniennext);
    $thuongniennext = date('Y-m-d', mktime(0, 0, 0, $tmp[1], intval($tmp[2] + 7), $tmp[0]));
    $ii = 3;
    while ($thuongniennext < $letro) {
      $date_ceremonys[$thuongniennext][] = $this->findNameByCode("TN" . str_pad($ii, 2, '0', STR_PAD_LEFT) . '1');
      $tmp = explode('-', $thuongniennext);
      for ($i = 1; $i < 7; $i++) {
        $thuongnienngaythuong = date('Y-m-d', mktime(0, 0, 0, $tmp[1], intval($tmp[2] + $i), $tmp[0]));
        $date_ceremonys[$thuongnienngaythuong][] = $this->findNameByCode('TN' . str_pad($ii, 2, '0', STR_PAD_LEFT) . ($i + 1));
      }

      $ii++;
      $tmp = explode('-', $thuongniennext);
      $thuongniennext = date('Y-m-d', mktime(0, 0, 0, $tmp[1], intval($tmp[2] + 7), $tmp[0]));
    }

    // Tinh Tu Le Chua Phuc Sinh
    $cnhat2ps = date('Y-m-d', mktime(0, 0, 0, $ar_dayEaster[1], $ar_dayEaster[2] + 7, $ar_dayEaster[0]));
    $cnhat3ps = date('Y-m-d', mktime(0, 0, 0, $ar_dayEaster[1], $ar_dayEaster[2] + 14, $ar_dayEaster[0]));
    $cnhat4ps = date('Y-m-d', mktime(0, 0, 0, $ar_dayEaster[1], $ar_dayEaster[2] + 21, $ar_dayEaster[0]));
    $cnhat5ps = date('Y-m-d', mktime(0, 0, 0, $ar_dayEaster[1], $ar_dayEaster[2] + 28, $ar_dayEaster[0]));
    $cnhat6ps = date('Y-m-d', mktime(0, 0, 0, $ar_dayEaster[1], $ar_dayEaster[2] + 35, $ar_dayEaster[0]));
    $cnhat7ps = date('Y-m-d', mktime(0, 0, 0, $ar_dayEaster[1], $ar_dayEaster[2] + 42, $ar_dayEaster[0]));

    $date_ceremonys[$cnhat2ps][] = $this->findNameByCode('PS021');
    $tmp = explode('-', $cnhat2ps);
    for ($i = 1; $i < 7; $i++) {
      $phucsinhngaythuong = date('Y-m-d', mktime(0, 0, 0, $tmp[1], intval($tmp[2] + $i), $tmp[0]));
      $date_ceremonys[$phucsinhngaythuong][] = $this->findNameByCode('PS02' . ($i + 1));
    }

    $date_ceremonys[$cnhat3ps][] = $this->findNameByCode('PS031');
    $tmp = explode('-', $cnhat3ps);
    for ($i = 1; $i < 7; $i++) {
      $phucsinhngaythuong = date('Y-m-d', mktime(0, 0, 0, $tmp[1], intval($tmp[2] + $i), $tmp[0]));
      $date_ceremonys[$phucsinhngaythuong][] = $this->findNameByCode('PS03' . ($i + 1));
    }

    $date_ceremonys[$cnhat4ps][] = $this->findNameByCode('PS041');
    $tmp = explode('-', $cnhat4ps);
    for ($i = 1; $i < 7; $i++) {
      $phucsinhngaythuong = date('Y-m-d', mktime(0, 0, 0, $tmp[1], intval($tmp[2] + $i), $tmp[0]));
      $date_ceremonys[$phucsinhngaythuong][] = $this->findNameByCode('PS04' . ($i + 1));
    }

    $date_ceremonys[$cnhat5ps][] = $this->findNameByCode('PS051');
    $tmp = explode('-', $cnhat5ps);
    for ($i = 1; $i < 7; $i++) {
      $phucsinhngaythuong = date('Y-m-d', mktime(0, 0, 0, $tmp[1], intval($tmp[2] + $i), $tmp[0]));
      $date_ceremonys[$phucsinhngaythuong][] = $this->findNameByCode('PS05' . ($i + 1));
    }

    $date_ceremonys[$cnhat6ps][] = $this->findNameByCode('PS061');
    $tmp = explode('-', $cnhat6ps);
    for ($i = 1; $i < 7; $i++) {
      $phucsinhngaythuong = date('Y-m-d', mktime(0, 0, 0, $tmp[1], intval($tmp[2] + $i), $tmp[0]));
      $date_ceremonys[$phucsinhngaythuong][] = $this->findNameByCode('PS06' . ($i + 1));
    }

    $date_ceremonys[$cnhat7ps][] = $this->findNameByCode('PS071');
    $tmp = explode('-', $cnhat7ps);
    for ($i = 1; $i < 7; $i++) {
      $phucsinhngaythuong = date('Y-m-d', mktime(0, 0, 0, $tmp[1], intval($tmp[2] + $i), $tmp[0]));
      $date_ceremonys[$phucsinhngaythuong][] = $this->findNameByCode('PS07' . ($i + 1));
    }

    $cnhatctthx = date('Y-m-d', mktime(0, 0, 0, $ar_dayEaster[1], $ar_dayEaster[2] + 49, $ar_dayEaster[0]));
    $cnhatcbn = date('Y-m-d', mktime(0, 0, 0, $ar_dayEaster[1], $ar_dayEaster[2] + 56, $ar_dayEaster[0]));
    $cnhatmmtck = date('Y-m-d', mktime(0, 0, 0, $ar_dayEaster[1], $ar_dayEaster[2] + 63, $ar_dayEaster[0]));
    $thanhtamchuagiesu = date('Y-m-d', mktime(0, 0, 0, $ar_dayEaster[1], $ar_dayEaster[2] + 68, $ar_dayEaster[0]));

    $date_ceremonys[$cnhatctthx][] = $this->findNameByCode('CNHATLECTTHX');
    $date_ceremonys[$cnhatcbn][] = $this->findNameByCode('CNHATLECBN');
    $date_ceremonys[$cnhatmmtck][] = $this->findNameByCode('CNHATMMTCK');
    $date_ceremonys[$thanhtamchuagiesu][] = $this->findNameByCode('THANHTAMCHUAGIESU');

    //Tinh Tu Le Giang Sinh
    $christmas = $data['Calendar']['year'] . '-12-25';
    //$date_ceremonys[$christmas][] = findNameByCode('CHRISTMAS');

    if (date('l', strtotime($christmas)) == "Sunday") {
      $date_ceremonys[$data['Calendar']['year'] . '-12-26'][] = $this->findNameByCode('CHRISTMAS02');
      $date_ceremonys[$data['Calendar']['year'] . '-12-27'][] = $this->findNameByCode('CHRISTMAS03');
      $date_ceremonys[$data['Calendar']['year'] . '-12-28'][] = $this->findNameByCode('CHRISTMAS04');
      $date_ceremonys[$data['Calendar']['year'] . '-12-29'][] = $this->findNameByCode('CHRISTMAS05');
      $date_ceremonys[$data['Calendar']['year'] . '-12-30'][] = $this->findNameByCode('LETHANHGIA');
      $date_ceremonys[$data['Calendar']['year'] . '-12-31'][] = $this->findNameByCode('CHRISTMAS06');
    } else {
      $ii = 26;
      while (date('l', strtotime($data['Calendar']['year'] . '-12-' . $ii)) != "Sunday") {
        $ii++;
      }
      $date_ceremonys[$data['Calendar']['year'] . '-12-' . $ii][] = $this->findNameByCode('LETHANHGIA');
      $j = $ii + 1;
      $k = 2;
      while ($j <= 31) {
        $date_ceremonys[$data['Calendar']['year'] . '-12-' . $j][] = $this->findNameByCode('CHRISTMAS0' . $k);
        $j++;
        $k++;
      }
      $j = $ii - 1;
      $k = 7;
      while ($j > 25) {
        $date_ceremonys[$data['Calendar']['year'] . '-12-' . $j][] = $this->findNameByCode('CHRISTMAS0' . $k);
        $j--;
        $k--;
      }
    }


    $ii = 24;
    $cnhatmv4 = $data['Calendar']['year'] . '-12-' . $ii;
    if (date('l', strtotime($christmas)) != "Sunday") {
      while (date('l', strtotime($cnhatmv4)) != "Sunday") {
        $ii--;
        $cnhatmv4 = $data['Calendar']['year'] . '-12-' . $ii;
      }
    } else {
      $cnhatmv4 = $data['Calendar']['year'] . '-12-18';
    }

    $date_ceremonys[$cnhatmv4][] = $this->findNameByCode('MV041');
    $tmp = explode('-', $cnhatmv4);
    for ($i = 1; $i < 7; $i++) {
      $muavongngaythuong = date('Y-m-d', mktime(0, 0, 0, $tmp[1], intval($tmp[2] + $i), $tmp[0]));
      if ($muavongngaythuong < $christmas) {
        $date_ceremonys[$muavongngaythuong][] = $this->findNameByCode("MV04" . ($i + 1));
      }
    }
    $cnhatmv3 = date('Y-m-d', mktime(0, 0, 0, $tmp[1], $tmp[2] - 7, $tmp[0]));
    $date_ceremonys[$cnhatmv3][] = $this->findNameByCode('MV031');
    $tmp = explode('-', $cnhatmv3);
    for ($i = 1; $i < 7; $i++) {
      $muavongngaythuong = date('Y-m-d', mktime(0, 0, 0, $tmp[1], intval($tmp[2] + $i), $tmp[0]));
      $date_ceremonys[$muavongngaythuong][] = $this->findNameByCode("MV03" . ($i + 1));
    }

    $cnhatmv2 = date('Y-m-d', mktime(0, 0, 0, $tmp[1], $tmp[2] - 7, $tmp[0]));
    $date_ceremonys[$cnhatmv2][] = $this->findNameByCode('MV021');
    $tmp = explode('-', $cnhatmv2);
    for ($i = 1; $i < 7; $i++) {
      $muavongngaythuong = date('Y-m-d', mktime(0, 0, 0, $tmp[1], intval($tmp[2] + $i), $tmp[0]));
      $date_ceremonys[$muavongngaythuong][] = $this->findNameByCode("MV02" . ($i + 1));
    }

    $cnhatmv1 = date('Y-m-d', mktime(0, 0, 0, $tmp[1], $tmp[2] - 7, $tmp[0]));
    $date_ceremonys[$cnhatmv1][] = $this->findNameByCode('MV011');
    $tmp = explode('-', $cnhatmv1);
    for ($i = 1; $i < 7; $i++) {
      $muavongngaythuong = date('Y-m-d', mktime(0, 0, 0, $tmp[1], intval($tmp[2] + $i), $tmp[0]));
      $date_ceremonys[$muavongngaythuong][] = $this->findNameByCode("MV01" . ($i + 1));
    }

    $cnhatckv = date('Y-m-d', mktime(0, 0, 0, $tmp[1], $tmp[2] - 7, $tmp[0]));
    $date_ceremonys[$cnhatckv][] = $this->findNameByCode('CN-CHUA-KITO-VUA');

    $tmp = explode('-', $cnhatckv);
    for ($i = 1; $i < 7; $i++) {
      $thuongnienngaythuong = date('Y-m-d', mktime(0, 0, 0, $tmp[1], intval($tmp[2] + $i), $tmp[0]));
      $date_ceremonys[$thuongnienngaythuong][] = $this->findNameByCode("TN34" . ($i + 1));
    }

    $ii = 33;
    $tmp = explode('-', $cnhatckv);
    $cnhattnpre = date('Y-m-d', mktime(0, 0, 0, $tmp[1], $tmp[2] - 7, $tmp[0]));
    while ($cnhattnpre >= $cnhatctthx) {
      $date_ceremonys[$cnhattnpre][] = $this->findNameByCode("TN" . str_pad($ii, 2, '0', STR_PAD_LEFT) . '1');
      $tmp = explode('-', $cnhattnpre);
      for ($iii = 1; $iii < 7; $iii++) {
        $thuongnienngaythuong = date('Y-m-d', mktime(0, 0, 0, $tmp[1], intval($tmp[2] + $iii), $tmp[0]));
        $date_ceremonys[$thuongnienngaythuong][] = $this->findNameByCode("TN" . str_pad($ii, 2, '0', STR_PAD_LEFT) . ($iii + 1));
      }
      $ii--;
      $tmp = explode('-', $cnhattnpre);
      $cnhattnpre = date('Y-m-d', mktime(0, 0, 0, $tmp[1], intval($tmp[2] - 7), $tmp[0]));
    }

    return $date_ceremonys;
  }
}
