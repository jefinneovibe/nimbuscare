<?php

namespace App\Widgets;

use Arrilot\Widgets\AbstractWidget;


use App\WorkType;

class RecentNews extends AbstractWidget
{
    /**
     * The configuration array.
     *
     * @var array
     */
    protected $config = [
        'type' =>'number',
        'name' =>'First Name',
        'class' =>'full_name_wrp',
        'id' =>'fullName',
        'required' =>true,
        'relation' =>[
            'is_related' => false,
            'relation_name' => ''
        ],
        'validation'=> [
            'required' => true
        ]
    ];


    /**
     * Treat this method as a controller action.
     * Return view() or other content to display.
     */
    public function run()
    {
        //$work_type = WorkType::orderBy('name')->get();
        return view('widgets.recent_news', [ 'config' => $this->config]);
    }
}
