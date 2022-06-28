<?php

namespace Beike\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Customer extends Authenticatable
{
    use HasFactory;
    use SoftDeletes;

    const AUTH_GUARD = 'web_shop';

    protected $fillable = ['name', 'email', 'password', 'status', 'avatar', 'customer_group_id', 'language_id', 'status', 'from'];
}
