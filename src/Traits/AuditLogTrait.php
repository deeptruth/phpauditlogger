<?php 

namespace Deeptruth\PhpAuditLogger\Traits;

use Deeptruth\PhpAuditLogger\Model\AuditLog as AuditLogModel;
use Illuminate\Support\Facades\Auth;

trait AuditLogTrait {
    
    /**
     * [Description of log]
     *
     * @var [String]
     */
    protected $description;


    /**
     * [user id of user who performed this action]
     *
     * @var [int]
     */

    protected $user_id;

    /**
     * [Check if the use wants to log old and new value]
     *
     * @var [boolean]
     */
    public $log_old_new_value = false;


    /**
     * [Old value of data]
     * 
     * [$old_value description]
     * @var [String]
     */
    protected $old_value = "";

    /**
     * [New value of data]
     * 
     * [$new_value description]
     * @var [String]
     */
    protected $new_value = "";


    /**
     * [log Set log parameters and check if user_id is null(for CLI)]
     *
     * @param [String $description] [description of log]
     * @param [int $user_id]        [customized user id of user who performed this action]
     * @return [boolean]
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

        return $this->saveLog();
    }

    /**
     * [saveLog Log the specifc action]
     * 
     * @return [boolean]
     */

    private function saveLog(){
        $audit_log = new AuditLogModel();
        $audit_log->user_id = $this->user_id;
        $audit_log->record_id = $this->attributes['id'];
        $audit_log->description = $this->description;
        $audit_log->old_value = $this->old_value== "" ? "" : json_encode($this->old_value);
        $audit_log->new_value = $this->new_value== "" ? "" : json_encode($this->new_value);
        return $audit_log->save();
    }


    /**
     * Save data to the database.
     *
     * @param  array  $options
     * @return bool
     */
    public function save(array $options = [])
    {
        if($this->log_old_new_value === true){
            if($this->exists){
                $this->old_value = $this->removeHidden($this->original);
                $this->new_value = $this->removeHidden($this->attributes);
            }else{
                throw new \Exception("Data must exist if you want to log old and new value", 1);
            }
        }
        // do some stuff here later like get old value or something for now save the log
        return parent::save($options);
    }



    private function removeHidden($data){
        $return_data = array();
        foreach ($data as $key => $value) { 
            if(!in_array($key, $this->hidden)){
                $return_data[$key] = $value;
            }
        }
        return $return_data;
    }
}