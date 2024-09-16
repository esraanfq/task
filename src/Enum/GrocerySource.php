<?php

namespace App\Enum;

enum GrocerySource : string
{
    case API = 'api';
    case JSON_FILE_IMPORT = 'json_file_import';
}
