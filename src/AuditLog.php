<?php 

namespace Deeptruth\PhpAuditLogger;

use Deeptruth\PhpAuditLogger\Model\AuditLog as AuditLogModel;
 
class AuditLog {

	public function __construct(){
		parent::__construct();
	}
 	
    public function saySomething() {

    	$auditlog = new AuditLogModel;

        $auditlog->users_id = 1;
        $auditlog->description = "This is a test log";
        $auditlog->record_id = 1;

        $auditlog->save();


    	return $auditlog;
        // return 'Hello World!';
    }
}