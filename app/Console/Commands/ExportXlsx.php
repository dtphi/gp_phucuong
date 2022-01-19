<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Maatwebsite\Excel\Facades\Excel;
use ReflectionClass;

class ExportXlsx extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'export:xlsx {exportName} {exportFileName}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        //$fileName  = storage_path() . '/' . 'app/formatEx.xlsx';
        //$reader        = \PhpOffice\PhpSpreadsheet\IOFactory::createReader('xlsx');
        //$worksheetData = $reader->listWorksheetInfo($fileName);print_r($worksheetData);die;

        if ($arguments) {
           $this->__exportExcel($arguments);
           $this->info('Export success: ' . $arguments['exportName'] . ': file name-> /storage/app/' . $arguments['exportFileName'] . '.xlsx');
        }
        return 0;
    }

    private function __exportExcel($args = array())
    {   
        $objectClass = 'App\Exports' . '\\' . $args['exportName'];
        $objectReflection = new ReflectionClass($objectClass);
        $objectExport = $objectReflection->newInstanceArgs();
        return Excel::store($objectExport, $args['exportFileName'] . '.xlsx');
    }
}
