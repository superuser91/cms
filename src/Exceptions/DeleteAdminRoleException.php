<?php

namespace Vgplay\Acl\Exceptions;

use Exception;

class DeleteAdminRoleException extends Exception
{
    public function __construct($message = 'Không thể xoá nhóm quản trị viên')
    {
        parent::__construct($message);
    }
}
