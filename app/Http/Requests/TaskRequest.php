<?php namespace App\Http\Requests;

use App\Http\Requests\Request;

class TaskRequest extends Request
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
        $rules = [
            'assigned_to_id' => 'required|positive',
            'title'          => 'required|plainText',
            'content'        => 'required|plainText',
            'due_at'         => 'required|date',
            'response'       => 'plainText',
            'completed_at'   => 'date',
            'completed'      => 'boolean',
            'reminder_sent'  => 'boolean',
            'remind_at'      => 'date',
        ];

        if ($this->isMethod('post')) {                                                      // creating new task
            $rules['creator_id'] = 'positive';
        } else if ($this->isMethod('patch')) {                                              // updating task
            $rules['creator_id'] = 'required|positive';
        }

        return $rules;
    }

}