<?php

namespace App;

enum ProductStatus: string
{
    case Unavailable = 'unavailable';
    case Available = 'available';
}
