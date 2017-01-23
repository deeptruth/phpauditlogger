<?php 

namespace Deeptruth\PhpAuditLogger\Facade;

use Illuminate\Support\Facades\Facade;

class AuditLog extends Facade{
 
    protected static function getFacadeAccessor() { return 'auditlog'; }
 
}