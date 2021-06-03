<?php

namespace App\Widgets;

use Arrilot\Widgets\AbstractWidget;
use App\WorkTypeData;
use MongoDB\BSON\ObjectID;

class MultipleFileUploader extends AbstractWidget
{
    /**
     * The configuration array.
     *
     * @var array
     */
    protected $config = [];

    /**
     * Treat this method as a controller action.
     * Return view() or other content to display.
     */
    public function run()
    {

        $workTypeDataId = $this->config['workTypeDataId'];
        $workTypeData = WorkTypeData::where('_id', new ObjectId($workTypeDataId))->first();
        $files = [];
        if (!empty($workTypeData['files'])) {
            foreach ($workTypeData['files'] as $key => $value) {
                if ($value['upload_type'] == $this->config['data']['valueKey']) {
                    $files[] = $value;
                }
            }
        }
        return view(
            'widgets.multiple_file_uploader', [
            'config' => $this->config['data'],
            'configValue' => $this->config['value'],
            'value'=>@$files
            ]
        );
    }
}
