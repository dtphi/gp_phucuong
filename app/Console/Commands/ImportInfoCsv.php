<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Information;
use App\Models\InformationDescription;
use App\Models\InformationToCategory;

class ImportInfoCsv extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:info {fileName}';

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
        $fileName = storage_path('import_csv') . '/' . $arguments['fileName'] . '.csv';
        $this->importCsvToDb($fileName);

        $this->info('File name import: ' . $fileName);
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
        $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($inputFileType);
        $worksheetData = $reader->listWorksheetInfo($inputFileName);

        if (count($worksheetData)) {
            $spreadsheet = $reader->load($inputFileName);
            $sheetData = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);
            $this->info('count: ' . count($sheetData));
            unset($sheetData[1]);

            foreach ($sheetData as $info) {
                $infoId = (int)$info['A'];
                $image = $info['G'];
                $viewed = (int)$info['N'];
                $vote = (int)$info['M'];
                $sortDes = $info['J'];

                $name = $info['C'];
                $des = htmlentities($info['E']);
                $tag = $info['O'];
                $metaTitle = $info['P'];
                $metaDes = $info['Q'];
                $metaKey = $info['R'];

                $cateId = (int)$info['D'];

                Information::insertForce($infoId, $image, 0, 1, $viewed, $vote, $sortDes);
                InformationDescription::insertByInfoId($infoId, $name, $des, $tag, $metaTitle, $metaDes, $metaKey);
                InformationToCategory::insertByInfoId($infoId, $cateId);
            }
        }
    }
}
