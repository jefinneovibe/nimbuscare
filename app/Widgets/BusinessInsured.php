<?php

namespace App\Widgets;

use Arrilot\Widgets\AbstractWidget;
use App\BusinessInsuredOptions;
use App\Insurer;
use MongoDB\BSON\ObjectID;

class BusinessInsured extends AbstractWidget
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
        $workTypeId = $this->config['workTypeId'];
        if (empty($workTypeId) && !empty($this->config['data']['workTypeId'])) {
            $workTypeId = new ObjectId($this->config['data']['workTypeId']);
        }
        $options = [];
        //To select Insuer list instead of Business List flag isInsurerArr = true
        if (isset($this->config['data']['isInsurerArr']) && $this->config['data']['isInsurerArr']) {
            $insurers = Insurer::where('isActive', 1)->orderBy('name', 'ASC')->get();
            foreach ($insurers as $insurer) {
                    $temp['businessName'] = $insurer['name'];
                    $temp['businessNumber'] = $insurer['id'];
                    $options[]= $temp;
            }
        } else {
            $businessInsured = BusinessInsuredOptions::where('worktypeId', $workTypeId)->orderBy('businessNumber', 'ASC')->get();
            foreach ($businessInsured as $buisness) {
                if ($buisness['worktypeId'] == $workTypeId) {
                    $options[]= $buisness;
                }
            }
        }
        return view(
            'widgets.business_insured', [
                'config' => $this->config['data'],
                'value' => $this->config['value'],
                'options'=>$options,
            ]
        );
    }
}
