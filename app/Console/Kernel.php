<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //\App\Console\Commands\ImportCategoryCsv::class
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')->hourly();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }


    public function importCsvToDb() {
        $inputFileType = 'Csv';
        $inputFileName = './sampleData/example2.csv';

        echo 'Loading file ',pathinfo($inputFileName,PATHINFO_BASENAME),' using IOFactory with a defined reader type of ',$inputFileType,'<br />';
        /**  Create a new Reader of the type defined in $inputFileType  **/
        $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($inputFileType);

        /**  Define how many rows we want to read for each "chunk"  **/
        $chunkSize = 65530;
        /**  Create a new Instance of our Read Filter  **/
        $chunkFilter = new ChunkReadFilter();

        /**  Tell the Reader that we want to use the Read Filter  **/
        /**    and that we want to store it in contiguous rows/columns  **/

        $reader->setReadFilter($chunkFilter)
            ->setContiguous(true);

        /**  Instantiate a new Spreadsheet object manually  **/
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();

        /**  Set a sheet index  **/
        $sheet = 0;
        /**  Loop to read our worksheet in "chunk size" blocks  **/
        /**  $startRow is set to 2 initially because we always read the headings in row #1  **/
        for ($startRow = 2; $startRow <= 1000000; $startRow += $chunkSize) {
            /**  Tell the Read Filter which rows we want to read this loop  **/
            $chunkFilter->setRows($startRow,$chunkSize);

            /**  Increment the worksheet index pointer for the Reader  **/
            $reader->setSheetIndex($sheet);
            /**  Load only the rows that match our filter into a new worksheet  **/
            $reader->loadIntoExisting($inputFileName,$spreadsheet);
            /**  Set the worksheet title for the sheet that we've justloaded)  **/
            /**    and increment the sheet index as well  **/
            $spreadsheet->getActiveSheet()->setTitle('Country Data #'.(++$sheet));
        }
    }
}
