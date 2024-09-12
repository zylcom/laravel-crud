<?php

namespace App;

enum UserRole: string
{
    case Admin = 'admin';
    case User = 'user';
}
