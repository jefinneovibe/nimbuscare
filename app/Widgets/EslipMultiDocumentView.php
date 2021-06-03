<?php

namespace App\Widgets;

use Arrilot\Widgets\AbstractWidget;

class EslipMultiDocumentView extends AbstractWidget
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
        //
        $files = [];
        if (!empty($this->config['formValues']['files'])) {
            foreach ($this->config['formValues']['files'] as $key => $value) {
                if ($value['upload_type'] == $this->config['data']['uploadType']) {
                    $files[] = $value;
                }
            }
        }
        return view(
            'widgets.eslip_multi_document_view', [
            'config' => $this->config['data'],
            'files' => $files
            ]
        );
    }
}
