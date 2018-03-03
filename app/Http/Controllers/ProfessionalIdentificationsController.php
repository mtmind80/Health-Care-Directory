<?php namespace App\Http\Controllers;

use App\Http\Requests;

use Illuminate\Http\Request;

use App\ProfessionalIdentification;
use App\Http\Requests\ProfessionalIdentificationRequest;

use ProfessionalIdentificationObserver;

use EquationTrait;

class ProfessionalIdentificationsController extends CommonController
{
    use EquationTrait;

    public function __construct()
    {
        parent::__construct();

        ProfessionalIdentification::observe(new ProfessionalIdentificationObserver);
    }

    public function index(Request $request, $professional_id)
    {
        if ($this->authUserCannot('list-professional-identification')) {
            return redirect()->back()->withError(self::ERROR_NOT_ENOUGH_PRIVILEGES);
        }

        $perPage = $request->input('perPage') ? $request->input('perPage') : 10;
        $identifications = ProfessionalIdentification::active()->sortable()->professional($professional_id)->paginate($perPage);

        $professional = \App\Professional::find($professional_id);

        $data = [
            'encToken'              => app('Illuminate\Encryption\Encrypter')->encrypt(csrf_token()),
            'identifications'       => $identifications,
            'needle'                => null,
            'professional_id'       => $professional_id,
            'professionalName'      => $professional->fullName,
            'provider_id'           => $professional->provider_id,
            'jsonIdentificationsCB' => json_encode(\App\Identification::identificationsCB()),
            'seo'                   => [
                'pageTitle' => 'Provider Identifications',
            ],
        ];

        return view('provider.identification.index', $data);
    }

    public function search(Request $request, $professional_id)
    {
        if ($this->authUserCannot('search-professional-identification')) {
            return redirect()->back()->withError(self::ERROR_NOT_ENOUGH_PRIVILEGES);
        }

        $this->validate($request, [
            'needle' => 'min:3',
        ]);

        $professional = \App\Professional::find($professional_id);

        $needle = $request->needle;
        $perPage = $request->input('perPage') ? $request->input('perPage') : 10;
        $identifications = ProfessionalIdentification::active()->search($needle)->professional($professional_id)->sortable()->paginate($perPage);
        $data = [
            'encToken'              => app('Illuminate\Encryption\Encrypter')->encrypt(csrf_token()),
            'identifications'       => $identifications,
            'needle'                => $needle,
            'professional_id'       => $professional_id,
            'professionalName'      => $professional->fullName,
            'provider_id'           => $professional->provider_id,
            'jsonIdentificationsCB' => json_encode(\App\Identification::identificationsCB()),
            'seo'                   => [
                'pageTitle' => 'Provider Identifications',
            ],
        ];

        return view('provider.identification.index', $data);
    }

    public function create($professional_id)
    {
        if ($this->authUserCannot('create-professional-identification')) {
            return redirect()->back()->withError(self::ERROR_NOT_ENOUGH_PRIVILEGES);
        }

        $professional = \App\Professional::find($professional_id);

        $data = [
            'encToken'          => app('Illuminate\Encryption\Encrypter')->encrypt(csrf_token()),
            'equation'          => $this->equation(),
            'professional_id'   => $professional_id,
            'professionalName'  => $professional->fullName,
            'provider_id'       => $professional->provider_id,
            'identificationsCB' => \App\Identification::identificationsCB(['0' => 'Select identification type']),
            'seo'               => [
                'pageTitle' => 'Add Identification',
            ],
        ];

        return view('provider.identification.create', $data);
    }

    public function store(ProfessionalIdentificationRequest $request)
    {
        if ($this->authUserCannot('create-professional-identification')) {
            return redirect()->back()->withError(self::ERROR_NOT_ENOUGH_PRIVILEGES);
        }

        $inputs = $request->all();

        if (!empty($inputs['expired_at'])) {
            $inputs['expired_at'] = date('Y-m-d', strtotime($inputs['expired_at']));
        }

        ProfessionalIdentification::create($inputs);

        return redirect()->route('professional_identification_list_path', ['professional_id' => $inputs['professional_id']])->withSuccess('Identification added.');
    }

    public function inlineUpdate(Request $request)
    {
        if ($request->isMethod('post') && $request->ajax()) {
            $input = $request->all();

            $id = $input['pk'];
            $name = $input['name'];
            $value = $input['value'];
            $rule = (isset($input['rule'])) ? $input['rule'] : 'text';

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
                $professionalIdentification = ProfessionalIdentification::find($id);
                $professionalIdentification->{$name} = $value;
                $professionalIdentification->save();

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

    public function destroy(Request $request)
    {
        if ($this->authUserCannot('delete-professional-identification')) {
            return redirect()->back()->withError(self::ERROR_NOT_ENOUGH_PRIVILEGES);
        }

        $strCid = $request->input('strCid');
        if (empty($strCid)) {
            return redirect()->back()->withError('There is no identification selected.');
        }
        $arrCid = explode('|', $strCid);

        foreach ($arrCid as $id) {
            $professionalIdentification = ProfessionalIdentification::find($id);
            $professionalIdentification->delete();
        }

        return redirect()->route('professional_identification_list_path', ['professional_id' => $request->input('professional_id')])->withSuccess('Identification deleted.');
    }

}
