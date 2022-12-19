<?php

namespace App\Helpers;

class LockMode
{
    public const ACCESS_SHARE = 'ACCESS SHARE';
    public const ROW_SHARE = 'ROW SHARE';
    public const ROW_EXCLUSIVE = 'ROW EXCLUSIVE';
    public const SHARE_UPDATE_EXCLUSIVE = 'SHARE UPDATE EXCLUSIVE';
    public const SHARE = 'SHARE';
    public const SHARE_ROW_EXCLUSIVE = 'SHARE ROW EXCLUSIVE';
    public const EXCLUSIVE = 'EXCLUSIVE';
    public const ACCESS_EXCLUSIVE = 'ACCESS EXCLUSIVE';

}
