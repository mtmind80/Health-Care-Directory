<?php namespace App\Http\Controllers;


use App\Http\Requests;
use Illuminate\Http\Request;
use App\Language;
use App\Http\Requests\LanguageRequest;
use EquationTrait;


class LanguagesController extends CommonController
{
    use EquationTrait;

    public function index(Request $request)
    {
        if ($this->authUserCannot('list-language')) {
            return redirect()->back()->withError(self::ERROR_NOT_ENOUGH_PRIVILEGES);
        }

        $perPage = $request->input('perPage') ? $request->input('perPage') : 10;
        $languages = language::sortable()->paginate($perPage);

        $data = [
            'encToken' => app('Illuminate\Encryption\Encrypter')->encrypt(csrf_token()),
            'languages'    => $languages,
            'needle'   => null,
            'seo'      => [
                'pageTitle' => 'Languages',
            ],
        ];

        return view('language.index', $data);
    }

    public function search(Request $request)
    {
        if ($this->authUserCannot('search-language')) {
            return redirect()->back()->withError(self::ERROR_NOT_ENOUGH_PRIVILEGES);
        }

        $this->validate($request, [
            'needle' => 'min:3',
        ]);

        $needle = $request->needle;
        $perPage = $request->input('perPage') ? $request->input('perPage') : 10;
        $languages = language::search($needle)->sortable()->paginate($perPage);
        $data = [
            'encToken' => app('Illuminate\Encryption\Encrypter')->encrypt(csrf_token()),
            'languages'    => $languages,
            'needle'   => $needle,
            'seo'      => [
                'pageTitle' => 'Languages',
            ],
        ];

        return view('language.index', $data);
    }

    public function create()
    {
        if ($this->authUserCannot('create-language')) {
            return redirect()->back()->withError(self::ERROR_NOT_ENOUGH_PRIVILEGES);
        }

        $data = [
            'encToken' => app('Illuminate\Encryption\Encrypter')->encrypt(csrf_token()),
            'equation' => $this->equation(),
            'seo'      => [
                'pageTitle' => 'Create Language',
            ],
        ];

        return view('language.create', $data);
    }

    public function store(languageRequest $request)
    {
        if ($this->authUserCannot('create-language')) {
            return redirect()->back()->withError(self::ERROR_NOT_ENOUGH_PRIVILEGES);
        }

        $inputs = $request->all();

        if (empty($inputs['disable'])) {
            $inputs['disable'] = 0;
        }

        language::create($inputs);

        return redirect()->route('language_list_path')->withSuccess('New Language created.');
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
                $language = language::find($id);
                $language->{$name} = $value;
                $language->save();

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
        if ($this->authUserCannot('update-language')) {
            return redirect()->back()->withError(self::ERROR_NOT_ENOUGH_PRIVILEGES);
        }

        $language = language::find($id);
        $language->disabled = !$language->disabled;
        $language->save();

        return redirect()->back()->withSuccess('language status toggled.');
    }

    public function destroy(Request $request)
    {
        if ($this->authUserCannot('delete-language')) {
            return redirect()->back()->withError(self::ERROR_NOT_ENOUGH_PRIVILEGES);
        }

        $strCid = $request->input('strCid');
        if (empty($strCid)) {
            return redirect()->back()->withError('There is no language selected.');
        }
        $arrCid = explode('|', $strCid);

        language::destroy($arrCid);

        return redirect()->route('language_list_path')->withSuccess('language deleted.');
    }

}
