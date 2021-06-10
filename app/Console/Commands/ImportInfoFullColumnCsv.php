<?php

namespace App\Console\Commands;

use App\Models\Information;
use App\Models\InformationDescription;
use App\Models\InformationToCategory;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class ImportInfoFullColumnCsv extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:allinfo {fileName} {truncat}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import data from information csv file to information table database';

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
        $fileName  = storage_path('import_csv') . '/' . $arguments['fileName'] . '.csv';

        if ($arguments['truncat']) {
            Information::truncateForce();
            InformationDescription::truncateForce();
            InformationToCategory::truncateForce();
        }

        $this->importCsvToDb($fileName);

        $this->info('File name import: ' . $fileName);
    }

    /*
    array:22 [
        "A" => "NewsId" => A
        "B" => "UserIdCreate" => B
        "C" => "NewsName" => C
        "D" => "NewsGroupId" => D
        "E" => "NewsIds"
        "F" => "NewsIds2"
        "G" => "Context" => E
        "H" => "Context1" => F
        "I" => "Context2"
        "J" => "Context3"
        "K" => "Context4"
        "L" => "Context5"
        "M" => "Picture" => G
        "N" => "Picture1"
        "O" => "Picture2"
        "P" => "Picture3"
        "Q" => "Picture4"
        "R" => "Picture5"
        "S" => "Picture6"
        "T" => "Picture7"
        "U" => "Picture8"
        "V" => "Picture9"
        "W" => "Text" => H
        "X" => "Text1"
        "Y" => "Text2"
        "Z" => "Text3"
        "AA" => "Text4"
        "AB" => "Text5"
        "AC" => "Text6"
        "AD" => "Text7"
        "AE" => "Text8"
        "AF" => "Text9"
        "AG" => "ProductIds"
        "AH" => "ProductIds2"
        "AI" => "Status" => I
        "AJ" => "Description" => J
        "AK" => "NewsLink" => K
        "AL" => "NewsNameNoMark" => L
        "AM" => "Vote" => M
        "AN" => "Visit" => N
        "AO" => "Tag" => O
        "AP" => "MetaTitle" => P
        "AQ" => "MetaDescription" => Q
        "AR" => "MetaKeyword" => R
        "AS" => "TopLevel" => S
        "AT" => "CreateDate" => T
        "AU" => "NewsName2" => U
        "AV" => "NewsType" => V
        "AW" => "SlideId"
        "AX" => "SlideId2"
        "AY" => "NewsGroupIds"
        ]
    */
    public function importCsvToDb($inputFileName = '')
    {
        $inputFileType = 'Csv';
        $inputFileName = $inputFileName;
        /**  Create a new Reader of the type defined in $inputFileType  **/
        $reader        = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($inputFileType);
        $worksheetData = $reader->listWorksheetInfo($inputFileName);

        if (count($worksheetData)) {
            $spreadsheet = $reader->load($inputFileName);
            $sheetData   = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);
            $this->info('count: ' . count($sheetData));
            
            foreach ($sheetData as $info) {
                $infoId     = (int)$info['A'];
                $createUser = (int)$info['B'];
                $image      = $info['M'];
                $viewed     = (int)$info['AN'];
                $vote       = (int)$info['AM'];
                $sortDes    = empty($info['AJ'])?$info['C']:nl2br(strip_tags($info['AJ']));

                $name      = $info['C'];
                $nameSlug  = Str::slug($name . ' ' . $infoId);
                $des       = empty($info['G'])?$name: $info['G'];
                $tag       = $info['AO'];
                $metaTitle = $info['AP'];
                $metaDes   = $info['AQ'];
                $metaKey   = $info['AR'];

                $cateId   = (int)$info['D'];
                $infoType = 1;
                if ($info['AV'] == 'Video') {
                    $infoType = 2;
                }
                $date = date_create($info['AT']);
                $dateAvailable = date_format($date,"Y-m-d H:i:s");

                Information::insertForce($infoId, $image, $dateAvailable, 0, 1, $viewed, $vote, $sortDes, $nameSlug,
                    $createUser, $infoType);
                InformationDescription::insertByInfoId($infoId, $name, $des, $tag, $metaTitle, $metaDes, $metaKey);
                InformationToCategory::insertByInfoId($infoId, $cateId);
            }
        }
    }
}
