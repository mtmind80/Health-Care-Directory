<?php namespace App\Http\Controllers;

use App\Http\Requests;

use Illuminate\Http\Request;

use App\DocumentActionType;
use App\Http\Requests\DocumentActionTypeRequest;

use EquationTrait;

class DocumentActionTypesController extends CommonController
{
    use EquationTrait;

    public function index(Request $request)
    {
        if ($this->authUserCannot('list-document-action-type')) {
            return redirect()->back()->withError(self::ERROR_NOT_ENOUGH_PRIVILEGES);
        }

        $perPage = $request->input('perPage') ? $request->input('perPage') : 10;
        $documentActionTypes = DocumentActionType::sortable()->paginate($perPage);

        $data = [
            'encToken'            => app('Illuminate\Encryption\Encrypter')->encrypt(csrf_token()),
            'documentActionTypes' => $documentActionTypes,
            'needle'              => null,
            'seo'                 => [
                'pageTitle' => 'Document Action Types',
            ],
        ];

        return view('documentactiontype.index', $data);
    }

    public function search(Request $request)
    {
        if ($this->authUserCannot('search-document-action-type')) {
            return redirect()->back()->withError(self::ERROR_NOT_ENOUGH_PRIVILEGES);
        }

        $this->validate($request, [
            'needle' => 'min:3',
        ]);

        $needle = $request->needle;
        $perPage = $request->input('perPage') ? $request->input('perPage') : 10;
        $documentActionTypes = DocumentActionType::search($needle)->sortable()->paginate($perPage);
        $data = [
            'encToken'            => app('Illuminate\Encryption\Encrypter')->encrypt(csrf_token()),
            'documentActionTypes' => $documentActionTypes,
            'needle'              => $needle,
            'seo'                 => [
                'pageTitle' => 'Document Action Types',
            ],
        ];

        return view('documentactiontype.index', $data);
    }

    public function create()
    {
        if ($this->authUserCannot('create-document-action-type')) {
            return redirect()->back()->withError(self::ERROR_NOT_ENOUGH_PRIVILEGES);
        }

        $data = [
            'encToken' => app('Illuminate\Encryption\Encrypter')->encrypt(csrf_token()),
            'equation' => $this->equation(),
            'seo'      => [
                'pageTitle' => 'Create Document Action Type',
            ],
        ];

        return view('documentactiontype.create', $data);
    }

    public function store(DocumentActionTypeRequest $request)
    {
        if ($this->authUserCannot('create-document-action-type')) {
            return redirect()->back()->withError(self::ERROR_NOT_ENOUGH_PRIVILEGES);
        }

        $inputs = $request->all();

        if (empty($inputs['disable'])) {
            $inputs['disable'] = 0;
        }

        DocumentActionType::create($inputs);

        return redirect()->route('document_action_type_list_path')->withSuccess('Document action type created.');
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
                $documentActionType = DocumentActionType::find($id);
                $documentActionType->{$name} = $value;
                $documentActionType->save();

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
        if ($this->authUserCannot('update-document-action-type')) {
            return redirect()->back()->withError(self::ERROR_NOT_ENOUGH_PRIVILEGES);
        }

        $documentActionType = DocumentActionType::find($id);
        $documentActionType->disabled = !$documentActionType->disabled;
        $documentActionType->save();

        return redirect()->back()->withSuccess('Document action type status toggled.');
    }

    public function destroy(Request $request)
    {
        if ($this->authUserCannot('delete-document-action-type')) {
            return redirect()->back()->withError(self::ERROR_NOT_ENOUGH_PRIVILEGES);
        }

        $strCid = $request->input('strCid');
        if (empty($strCid)) {
            return redirect()->back()->withError('There is no document action type selected.');
        }
        $arrCid = explode('|', $strCid);

        DocumentActionType::destroy($arrCid);

        return redirect()->route('document_action_type_list_path')->withSuccess('Document action type deleted.');
    }

}
