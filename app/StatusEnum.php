<?php

namespace App;

enum StatusEnum: string
{
    //
    case PENDING = "pending";
    case IN_PROGRESS = "in_progress";
    case COMPLETED = "completed";
}
