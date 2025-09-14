<?php

namespace App\Constants;

enum Role: string
{
    case GUEST = 'ROLE_GUEST';
    case NEW = 'ROLE_NEW';
    case USER = 'ROLE_USER';
    case MANDANT = 'ROLE_MANDANT';
    case ADMIN = 'ROLE_ADMIN';
    case ROOT = 'ROLE_ROOT';
}
