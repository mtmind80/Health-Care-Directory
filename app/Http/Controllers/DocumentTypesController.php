<?php namespace App\Http\Controllers;

use App\Http\Requests;

use Illuminate\Http\Request;

use App\DocumentType;
use App\Http\Requests\DocumentTypeRequest;

use EquationTrait;

class DocumentTypesController extends CommonController
{
    use EquationTrait;

    public function index(Request $request)
    {
        if ($this->authUserCannot('list-document-type')) {
            return redirect()->back()->withError(self::ERROR_NOT_ENOUGH_PRIVILEGES);
        }

        $perPage = $request->input('perPage') ? $request->input('perPage') : 10;
        $documentTypes = DocumentType::sortable()->paginate($perPage);

        $data = [
            'encToken'      => app('Illuminate\Encryption\Encrypter')->encrypt(csrf_token()),
            'documentTypes' => $documentTypes,
            'needle'        => null,
            'seo'           => [
                'pageTitle' => 'Document Types',
            ],
        ];

        return view('documenttype.index', $data);
    }

    public function search(Request $request)
    {
        if ($this->authUserCannot('search-document-type')) {
            return redirect()->back()->withError(self::ERROR_NOT_ENOUGH_PRIVILEGES);
        }

        $this->validate($request, [
            'needle' => 'min:3',
        ]);

        $needle = $request->needle;
        $perPage = $request->input('perPage') ? $request->input('perPage') : 10;
        $documentTypes = DocumentType::search($needle)->sortable()->paginate($perPage);
        $data = [
            'encToken'      => app('Illuminate\Encryption\Encrypter')->encrypt(csrf_token()),
            'documentTypes' => $documentTypes,
            'needle'        => $needle,
            'seo'           => [
                'pageTitle' => 'Document Types',
            ],
        ];

        return view('documenttype.index', $data);
    }

    public function create()
    {
        if ($this->authUserCannot('create-document-type')) {
            return redirect()->back()->withError(self::ERROR_NOT_ENOUGH_PRIVILEGES);
        }

        $data = [
            'encToken' => app('Illuminate\Encryption\Encrypter')->encrypt(csrf_token()),
            'equation' => $this->equation(),
            'seo'      => [
                'pageTitle' => 'Create Document Type',
            ],
        ];

        return view('documenttype.create', $data);
    }

    public function store(DocumentTypeRequest $request)
    {
        if ($this->authUserCannot('create-document-type')) {
            return redirect()->back()->withError(self::ERROR_NOT_ENOUGH_PRIVILEGES);
        }

        $inputs = $request->all();

        if (empty($inputs['disable'])) {
            $inputs['disable'] = 0;
        }

        DocumentType::create($inputs);

        return redirect()->route('document_type_list_path')->withSuccess('Document type created.');
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
                $documentType = DocumentType::find($id);
                $documentType->{$name} = $value;
                $documentType->save();

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
        if ($this->authUserCannot('update-document-type')) {
            return redirect()->back()->withError(self::ERROR_NOT_ENOUGH_PRIVILEGES);
        }

        $documentType = DocumentType::find($id);
        $documentType->disabled = !$documentType->disabled;
        $documentType->save();

        return redirect()->back()->withSuccess('Document type status toggled.');
    }

    public function destroy(Request $request)
    {
        if ($this->authUserCannot('delete-document-type')) {
            return redirect()->back()->withError(self::ERROR_NOT_ENOUGH_PRIVILEGES);
        }

        $strCid = $request->input('strCid');
        if (empty($strCid)) {
            return redirect()->back()->withError('There is no document type selected.');
        }
        $arrCid = explode('|', $strCid);

        DocumentType::destroy($arrCid);

        return redirect()->route('document_type_list_path')->withSuccess('Document type deleted.');
    }

}
