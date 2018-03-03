<?php namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Requests\SearchRequest;

use App\Config;

use EquationTrait;

class ConfigController extends CommonController
{
    use EquationTrait;

    public function index(Request $request)
    {
        if ($this->authUserCannot('list-config')) {
            return redirect()->back()->with('error', self::ERROR_NOT_ENOUGH_PRIVILEGES);
        }

        $perPage = $request->input('perPage') ? $request->input('perPage') : 10;
        $config = Config::sortable()->paginate($perPage);
        $data = [
            'encToken' => app('Illuminate\Encryption\Encrypter')->encrypt(csrf_token()),
            'conf'     => $config,
            'needle'   => null,
            'seo'      => [
                'pageTitle' => 'System Configuration',
            ],
        ];

        return view('config.index', $data);
    }

    public function search(SearchRequest $request)
    {
        if ($this->authUserCannot('search-config')) {
            return redirect()->back()->with('error', self::ERROR_NOT_ENOUGH_PRIVILEGES);
        }

        $needle = $request->needle;
        $perPage = $request->input('perPage') ? $request->input('perPage') : 10;
        $config = Config::search($needle)->sortable()->paginate($perPage);
        $data = [
            'encToken' => app('Illuminate\Encryption\Encrypter')->encrypt(csrf_token()),
            'conf'     => $config,
            'needle'   => $needle,
            'seo'      => [
                'pageTitle' => 'System Configuration',
            ],
        ];

        return view('config.index', $data);
    }

    public function create()
    {
        if ($this->authUserCannot('create-config')) {
            return redirect()->back()->with('error', self::ERROR_NOT_ENOUGH_PRIVILEGES);
        }

        $data = [
            'encToken' => app('Illuminate\Encryption\Encrypter')->encrypt(csrf_token()),
            'equation' => $this->equation(),
            'seo'      => [
                'pageTitle' => 'New System Configuration',
            ],
        ];

        return view('config.create', $data);
    }

    public function store(Request $request)
    {
        if ($this->authUserCannot('create-config')) {
            return redirect()->back()->with('error', self::ERROR_NOT_ENOUGH_PRIVILEGES);
        }

        $config = Config::create($request->all());
        $config->reload();

        return redirect()->route('config_list_path')->with('success', 'Item created.');
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
                $config = Config::find($id);
                $config->{$name} = $value;
                $config->save();
                $config->reload();

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
        if ($this->authUserCannot('update-config')) {
            return redirect()->back()->with('error', self::ERROR_NOT_ENOUGH_PRIVILEGES);
        }

        $config = Config::find($id);
        $config->disabled = !$config->disabled;
        $config->save();

        return redirect()->back()->with('success', 'Item status toggled.');
    }

    public function destroy(Request $request)
    {
        if ($this->authUserCannot('delete-config')) {
            return redirect()->back()->with('error', self::ERROR_NOT_ENOUGH_PRIVILEGES);
        }

        $strCid = $request->input('strCid');
        if (empty($strCid)) {
            return redirect()->back()->with('error', 'There is no item selected.');
        }
        $arrCid = explode('|', $strCid);

        Config::destroy($arrCid);

        return redirect()->route('config_list_path')->withSuccess('Item deleted.');
    }

}
