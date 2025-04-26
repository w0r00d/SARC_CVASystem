<?php

return [
'temporary_file_upload' => [
    'disk' => 'local',
    'rules' => 'file|max:102400', // max size in KB (this is 100MB)
],
];