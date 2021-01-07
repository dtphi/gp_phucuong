<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

/**
 * Class UpdateFileMessages
 *
 * @package App\Console\Commands
 */
class UpdateFileMessages extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fix:file_messages';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $records = DB::table('messages')->whereNotNull('file')->get();

        if ($records) {
            foreach ($records as $record) {
                $file = unserialize($record->file);
                $parts = pathinfo($file['url']);
                $data = [];

                if ($parts['extension'] == 'pdf') {
                    $data = [
                        'isFile' => true,
                        'name'   => $parts['basename'],
                        'url'    => $file['url']
                    ];
                } else {
                    $data[] = [
                        'name' => $parts['basename'],
                        'url'  => $file['url']
                    ];
                }
                DB::table('messages')->where('id', $record->id)->update([ 'file' => serialize($data) ]);
            }
        }
    }
}
