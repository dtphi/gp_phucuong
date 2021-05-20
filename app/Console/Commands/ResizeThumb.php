<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;
use Alexusmai\LaravelFileManager\FileManager;

class ResizeThumb extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'resize:thumb {width} {height}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Resize thumb';

    /**
     * @var FileManager
     */
    public $fm;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(FileManager $fm)
    {
        parent::__construct();
        $this->fm = $fm;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $arguments = $this->arguments();
        //$fileName  = storage_path('import_csv') . '/' . $arguments['fileName'] . '.csv';
        //dd(get_class_methods($this->fm));F:\gp_phucuong\public\Image\Picture\Logo\lgoweb.png
        dd($this->fm->thumbnails('public','Logo/logo-lg.jpg'));

        $this->info('Thumb size : ' . $arguments['width'] . $arguments['height']);
    }

    /*
    array:22 [
        "A" => "NewsId"
        "B" => "UserIdCreate"
        "C" => "NewsName"
        "D" => "NewsGroupId"
        "E" => "Context"
        "F" => "Context1"
        "G" => "Picture"
        "H" => "Text"
        "I" => "Status"
        "J" => "Description"
        "K" => "NewsLink"
        "L" => "NewsNameNoMark"
        "M" => "Vote"
        "N" => "Visit"
        "O" => "Tag"
        "P" => "MetaTitle"
        "Q" => "MetaDescription"
        "R" => "MetaKeyword"
        "S" => "TopLevel"
        "T" => "CreateDate"
        "U" => "NewsName2"
        "V" => "NewsType"
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
            unset($sheetData[1]);

            /*$testData[] = $sheetData[2];
            $testData[] = $sheetData[3];*/
            
            foreach ($sheetData as $info) {
                $infoId     = (int)$info['A'];
                $createUser = (int)$info['B'];
                $image      = $info['G'];
                $viewed     = (int)$info['N'];
                $vote       = (int)$info['M'];
                $sortDes    = empty($info['J'])?$info['C']:nl2br(strip_tags($info['J']));

                $name      = $info['C'];
                $nameSlug  = Str::slug($name . ' ' . $infoId);
                $des       = empty($info['E'])?$name: $info['E'];
                $tag       = $info['O'];
                $metaTitle = $info['P'];
                $metaDes   = $info['Q'];
                $metaKey   = $info['R'];

                $cateId   = (int)$info['D'];
                $infoType = 1;
                if ($info['V'] == 'Video') {
                    $infoType = 2;
                }
                $date = date_create($info['T']);
                $dateAvailable = date_format($date,"Y/m/d H:i:s");

                Information::insertForce($infoId, $image, $dateAvailable, 0, 1, $viewed, $vote, $sortDes, $nameSlug,
                    $createUser, $infoType);
                InformationDescription::insertByInfoId($infoId, $name, $des, $tag, $metaTitle, $metaDes, $metaKey);
                InformationToCategory::insertByInfoId($infoId, $cateId);
            }
        }
    }
}
