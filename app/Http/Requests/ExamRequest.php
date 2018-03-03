<?php namespace App\Http\Requests;

use App\Http\Requests\Request;

class ExamRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [];

        if ($this->isMethod('post')) {                                                      // creating new exam
            $rules['name'] = 'required|plainText|unique:exams';
        } else if ($this->isMethod('patch')) {                                              // updating exam
            $rules['name'] = 'required|plainText|unique:exams,name,' . $this->get('id');
        }

        return $rules;
    }

}