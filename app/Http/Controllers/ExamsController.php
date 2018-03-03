<?php namespace App\Http\Controllers;

use App\Http\Requests;

use Illuminate\Http\Request;

use App\Exam;
use App\Http\Requests\ExamRequest;

use EquationTrait;

class ExamsController extends CommonController
{
    use EquationTrait;

    public function index(Request $request)
    {
        if ($this->authUserCannot('list-exam')) {
            return redirect()->back()->withError(self::ERROR_NOT_ENOUGH_PRIVILEGES);
        }

        $perPage = $request->input('perPage') ? $request->input('perPage') : 10;
        $exams = Exam::sortable()->paginate($perPage);

        $data = [
            'encToken' => app('Illuminate\Encryption\Encrypter')->encrypt(csrf_token()),
            'exams'    => $exams,
            'needle'   => null,
            'seo'      => [
                'pageTitle' => 'Exams',
            ],
        ];

        return view('exam.index', $data);
    }

    public function search(Request $request)
    {
        if ($this->authUserCannot('search-exam')) {
            return redirect()->back()->withError(self::ERROR_NOT_ENOUGH_PRIVILEGES);
        }

        $this->validate($request, [
            'needle' => 'min:3',
        ]);

        $needle = $request->needle;
        $perPage = $request->input('perPage') ? $request->input('perPage') : 10;
        $exams = Exam::search($needle)->sortable()->paginate($perPage);
        $data = [
            'encToken' => app('Illuminate\Encryption\Encrypter')->encrypt(csrf_token()),
            'exams'    => $exams,
            'needle'   => $needle,
            'seo'      => [
                'pageTitle' => 'Exams',
            ],
        ];

        return view('exam.index', $data);
    }

    public function create()
    {
        if ($this->authUserCannot('create-exam')) {
            return redirect()->back()->withError(self::ERROR_NOT_ENOUGH_PRIVILEGES);
        }

        $data = [
            'encToken' => app('Illuminate\Encryption\Encrypter')->encrypt(csrf_token()),
            'equation' => $this->equation(),
            'seo'      => [
                'pageTitle' => 'Create Exam',
            ],
        ];

        return view('exam.create', $data);
    }

    public function store(ExamRequest $request)
    {
        if ($this->authUserCannot('create-exam')) {
            return redirect()->back()->withError(self::ERROR_NOT_ENOUGH_PRIVILEGES);
        }

        $inputs = $request->all();

        if (empty($inputs['disable'])) {
            $inputs['disable'] = 0;
        }

        Exam::create($inputs);

        return redirect()->route('exam_list_path')->withSuccess('Exam created.');
    }

    public function inlineUpdate(Request $request)
    {
        if ($request->isMethod('post') && $request->ajax()) {
            $input = $request->all();

            $id = $input['pk'];
            $name = $input['name'];
            $value = $input['value'];
            $rule = (isset($input['rule'])) ? $input['rule'] : 'text';

            /*
             * The first argument passed to the make method is the data under validation.
             * The second argument is the validation rules that should be applied to the data.
             */

            $validator = \Validator::make(
                [$name => $value],
                [$name => $rule]
            );

            if ($validator->fails()) {
                $response = [
                    'status'  => 'error',
                    'message' => $validator->messages()->first(),
                ];
            } else {
                $exam = Exam::find($id);
                $exam->{$name} = $value;
                $exam->save();

                $response = [
                    'status' => 'success',
                ];
            }
        } else {
            $response = [
                'status'  => 'error',
                'message' => 'Invalid request.',
            ];
        }

        return json_encode($response);
    }

    public function toggleStatus($id)
    {
        if ($this->authUserCannot('update-exam')) {
            return redirect()->back()->withError(self::ERROR_NOT_ENOUGH_PRIVILEGES);
        }

        $exam = Exam::find($id);
        $exam->disabled = !$exam->disabled;
        $exam->save();

        return redirect()->back()->withSuccess('Exam status toggled.');
    }

    public function destroy(Request $request)
    {
        if ($this->authUserCannot('delete-exam')) {
            return redirect()->back()->withError(self::ERROR_NOT_ENOUGH_PRIVILEGES);
        }

        $strCid = $request->input('strCid');
        if (empty($strCid)) {
            return redirect()->back()->withError('There is no exam selected.');
        }
        $arrCid = explode('|', $strCid);

        Exam::destroy($arrCid);

        return redirect()->route('exam_list_path')->withSuccess('Exam deleted.');
    }

}
