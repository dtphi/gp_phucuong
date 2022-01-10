<?php

namespace App\Console\Commands;

use App\Models\Category;
use App\Models\CategoryDescription;
use App\Models\CategoryPath;
use App\Models\InformationDescription;
use App\Models\Tag;
use DB;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class UpdateTags extends Command
{
    /**
     * php artisan update:tag
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:tags {startDesId} {endDesId} {userId}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update data tags';

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

        if ($arguments['startDesId'] && $arguments['endDesId']) {
            DB::transaction(function () use ($arguments) {
                $startId = (int)$arguments['startDesId'];
                $endId = (int)$arguments['endDesId'];

                for ($i = $startId; $i <= $endId; $i++ ) {
                    $model = InformationDescription::where('information_id', $i)->first();
                    $model->tag = $this->_getTagIds($model->tag, $arguments['userId']);
                    $model->save();
                }
            });
        }
    }

    private function _getTagIds($tag = '', $userId) 
    {
        $tagIds = [];
        if (!empty($tag)) {
            $arrTags = explode(',', $tag);
            foreach ($arrTags as $tag) {
                $tagSlug = Str::slug($tag);
                $model = Tag::updateOrCreate(
                    ['name_slug' => $tagSlug],
                    [
                        'name' => $tag, 
                        'update_user' => $userId
                    ]
                );
                if ($model) {
                    $tagIds[] = $model->id;
                }
            }
        }

        return implode('|',$tagIds);
    }
}
