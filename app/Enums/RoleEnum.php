<?php

declare(strict_types=1);

namespace App\Enums;

enum RoleEnum: string
{
    case SUPER_ADMIN = 'super admin';
    case ADMINDROITS = 'admindroits';
    case ADMINMETIER = 'adminmetier';
}
