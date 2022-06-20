<?php

use App\Components\Migration\Migration;

class m220331_184739_add_columns_is_video_is_audio_category extends Migration
{
    private string $tableName     = 'Category';
    private string $columnIsVideo = 'isAudio';
    private string $columnIsAudio = 'isVideo';

    public function safeUp()
    {
        $this->addColumn($this->tableName, $this->columnIsAudio, $this->boolean()->defaultValue(0));
        $this->addColumn($this->tableName, $this->columnIsVideo, $this->boolean()->defaultValue(0));
    }

    public function safeDown()
    {
        $this->dropColumn($this->tableName, $this->columnIsAudio);
        $this->dropColumn($this->tableName, $this->columnIsVideo);
    }
}
