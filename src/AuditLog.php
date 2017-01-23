<?php 

namespace Deeptruth\PhpAuditLogger;
 
class AuditLog {
 
    public function saySomething() {
    	return config('auditlog.message');
        // return 'Hello World!';
    }
 
 
}