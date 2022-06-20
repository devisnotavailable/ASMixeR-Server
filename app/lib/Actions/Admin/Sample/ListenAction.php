<?php

declare(strict_types=1);

namespace App\Actions\Admin\Sample;

use App\Actions\BaseAction;
use App\App;
use App\Helper\File;
use App\Models\Sample;
use App\Param;

class ListenAction extends BaseAction
{
    /**
     * @throws \yii\web\HttpException
     */
    public function run(): string
    {
        $id = $this->getRequest()->getInt(Param::ID);

        if (!$id) {
            $this->getResponse()->set404();
        }

        $sample = Sample::findOne($id);

        if (!$sample) {
            $this->getResponse()->set404();
        }

        $pathTo = App::i()->getPathWeb() . '/load/sample/';

        $name = $sample->name . $sample->uuid;

        File::copy($sample->path, $pathTo . '/' . $name);

        $src = '/load/sample/' . $name;

        $this->controller->getView()->title = 'Listen ' . $sample->name;

        return $this->controller->render('listen', [
            'src'    => $src,
            'sample' => $sample,
        ]);
    }
}
