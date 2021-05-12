<?php

namespace App\Console\Commands;

use App\Models\Category;
use App\Models\CategoryDescription;
use App\Models\CategoryPath;
use DB;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class ImportCategoryCsv extends Command
{
    /**
     * php artisan import:category NewsGroup
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:category {fileName}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import data from category csv file to category table database';

    /**
     * Category path .
     */
    protected $modelPath = null;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->modelPath = new CategoryPath();
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
        $this->importCsvToDb($fileName);

        $this->info('File name import: ' . $fileName);
    }

    /*
    array:17 [
        "A" => "NewsGroupId"
        "B" => "NewsGroupIdFather"
        "C" => "NewsGroupName"
        "D" => "NewsGroupNameNoMark"
        "E" => "Picture"
        "G" => "Context"
        "H" => "Description"
        "I" => "NewsGroupLink"
        "J" => "NewsGroupIds"
        "K" => "Tag"
        "L" => "MetaTitle"
        "M" => "MetaDescription"
        "N" => "MetaKeyword"
        "O" => "TopLevel"
        "P" => "CreateDate"
        "Q" => "UserIdCreate"
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
            foreach ($sheetData as $group) {
                $categoryId = (int)$group['A'];
                $parentId   = (int)$group['B'];
                if ($parentId == -1) {
                    $parentId = 0;
                }
                $name       = $group['C'];
                $metaTitle  = $group['D'];
                $nameSlug   = Str::slug($name . ' ' . $categoryId);
                $createUser = (int)$group['Q'];

                if ($categoryId) {
                    Category::insertForce($categoryId, $nameSlug, $parentId, $createUser);
                    CategoryDescription::insertByCateId($categoryId, $name, '', $metaTitle, '', '');

                    /*MySQL Hierarchical Data Closure Table Pattern*/
                    $level       = 0;
                    $resultPaths = $this->modelPath->where('category_id', $parentId)
                        ->orderBy('level', 'ASC')->get();

                    foreach ($resultPaths as $key => $resultPath) {
                        CategoryPath::insertByCateId($categoryId, $resultPath['path_id'], $level);

                        $level++;
                    }
                    CategoryPath::insertByCateId($categoryId, $categoryId, $level);
                }
            }
        }
    }
}
