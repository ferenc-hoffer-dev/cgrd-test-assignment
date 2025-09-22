<?php

namespace App\Enums;

enum NewsResponseEnum: string
{
    case CREATED_SUCCESS = 'News created successfully';
    case CREATED_ERROR = 'Failed to create news';

    case UPDATED_SUCCESS = 'News updated successfully';
    case UPDATED_ERROR = 'Failed to update news';

    case DELETED_SUCCESS = 'News deleted successfully';
    case DELETED_ERROR = 'Failed to delete news';

    case FETCH_ERROR = 'Error fetching news';
}
