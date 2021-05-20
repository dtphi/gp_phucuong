<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;
use Alexusmai\LaravelFileManager\FileManager;
use Storage;
use Image;

class ResizeThumb extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'resize:thumb {dirName} {width}';

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
        $disk = 'public';
        $directories = Storage::disk($disk)->directories($arguments['dirName']);
        foreach($directories as $dir) {
            $files = Storage::disk($disk)->files($dir);
            foreach($files as $filePath) {
                $fileResize = new \Illuminate\Http\File(storage_path('app/public/'.$filePath));
                $extension = $fileResize->extension();

                $resize = Image::make($fileResize)->resize((int)$arguments['width'], null, function ($constraint) {
                    $constraint->aspectRatio();
                  })->encode($extension);
        
                Storage::disk($disk)->put("thumbs/" . $filePath, $resize->__toString());
            }
        }
        
        //$contents = Storage::disk($disk)->get($path);
        
        /*$resize = Image::make($contents)->resize((int)$arguments['width'], null, function ($constraint) {
            $constraint->aspectRatio();
          })->encode($extension);

        Storage::disk($disk)->put("testimages/app/app_tim_nha_tho.jpg", $resize->__toString());*/
        
    
        $this->info('Thumb size : ' . $arguments['width'] . $arguments['dirName']);
    }
}
