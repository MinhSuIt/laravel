<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\DB;

class UniqueTranslate implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    protected $table;
    protected $field;
    protected $foreignName;
    protected $foreignId;
    protected $language;

    public function __construct($table, $field, $foreignName = null, $foreignId = null)
    {
        $this->table = $table;
        $this->field = $field;


        //2 truờng này cho trường hợp update
        $this->foreignId = $foreignId;
        $this->foreignName = $foreignName;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $data = explode(".", $attribute);
        $language = $data[0];
        $this->language = $data[0];
        $translateAttribute = $data[1];
        $translateModel = DB::table($this->table)->where('locale', $language)->where($this->field, $value);
        if ($this->foreignName && $this->foreignId) {
            $translateModel->where($this->foreignName, $this->foreignId);
        }
        $translateModel = $translateModel->get()->toArray();
        if (empty($translateModel)){
            return true;
        } 
        else if(count($translateModel) >=2 && $this->foreignName && $this->foreignId){
            return false;
        }
        // dd(count($translateModel));

        return true;
        // dd($translateModel);
        // dd($this->table,$this->field,$this->foreignId,$this->foreignName);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return "The $this->field of $this->language has exists.";
    }
}
