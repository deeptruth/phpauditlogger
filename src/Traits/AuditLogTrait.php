<?php 

namespace Deeptruth\PhpAuditLogger\Traits;

use Deeptruth\PhpAuditLogger\Model\AuditLog as AuditLogModel;
use Illuminate\Support\Facades\Auth;

trait AuditLogTrait {
    
    /**
     * Description of log
     *
     * @var string
     */
    protected $description;


    /**
     * Description of user id
     *
     * Corresponds to driver name in authentication configuration.
     *
     * @var int
     */

    protected $user_id;


    /**
     * Set log parameters and check if user_id is null(for CLI)
     * 
     * @return boolean
     */

    public function log($description, $user_id = null){
        $this->description = $description;
        $this->user_id = $user_id;
        if (is_null($user_id))
        {
            if(Auth::check()){
                $this->user_id = Auth::id();
            }else{
                throw new \Exception("User must be logged in", 1);
            }
        }

        $this->save_log();
    }

    /**
     * Log the specifc action
     * 
     * @return boolean
     */

    public function save_log(){
        $audit_log = new AuditLogModel();
        $audit_log->user_id = $this->user_id;
        $audit_log->record_id = $this->attributes['id'];
        $audit_log->description = $this->description;

        return $audit_log->save();
    }

    /**
     * Save data to the database.
     *
     * @param  array  $options
     * @return bool
     */
    // public function save(array $options = [])
    // {
    //     // do some stuff here later like get old value or something for now save the log
    //     parent::save($options);
    // }
}