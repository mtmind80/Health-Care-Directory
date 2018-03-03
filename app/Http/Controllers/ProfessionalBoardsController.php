<?php namespace App\Http\Controllers;

use App\Http\Requests;

use Illuminate\Http\Request;

use App\ProfessionalBoard;
use App\Http\Requests\ProfessionalBoardRequest;

use ProfessionalBoardObserver;

use EquationTrait;

class ProfessionalBoardsController extends CommonController
{
    use EquationTrait;

    public function __construct()
    {
        parent::__construct();

        ProfessionalBoard::observe(new ProfessionalBoardObserver);
    }

    public function index(Request $request, $professional_id)
    {
        if ($this->authUserCannot('list-professional-board')) {
            return redirect()->back()->withError(self::ERROR_NOT_ENOUGH_PRIVILEGES);
        }

        $perPage = $request->input('perPage') ? $request->input('perPage') : 10;
        $boards = ProfessionalBoard::active()->sortable()->professional($professional_id)->paginate($perPage);

        $professional = \App\Professional::find($professional_id);

        $data = [
            'encToken'         => app('Illuminate\Encryption\Encrypter')->encrypt(csrf_token()),
            'boards'           => $boards,
            'needle'           => null,
            'professional_id'  => $professional_id,
            'professionalName' => $professional->fullName,
            'provider_id'      => $professional->provider_id,
            'jsonBodiesCB'     => json_encode(\App\Body::bodiesCB()),
            'seo'              => [
                'pageTitle' => 'Provider Boards',
            ],
        ];

        return view('provider.board.index', $data);
    }

    public function search(Request $request, $professional_id)
    {
        if ($this->authUserCannot('search-professional-board')) {
            return redirect()->back()->withError(self::ERROR_NOT_ENOUGH_PRIVILEGES);
        }

        $this->validate($request, [
            'needle' => 'min:3',
        ]);

        $professional = \App\Professional::find($professional_id);

        $needle = $request->needle;
        $perPage = $request->input('perPage') ? $request->input('perPage') : 10;
        $boards = ProfessionalBoard::active()->search($needle)->professional($professional_id)->sortable()->paginate($perPage);

        $data = [
            'encToken'         => app('Illuminate\Encryption\Encrypter')->encrypt(csrf_token()),
            'boards'           => $boards,
            'needle'           => $needle,
            'professional_id'  => $professional_id,
            'professionalName' => $professional->fullName,
            'provider_id'      => $professional->provider_id,
            'jsonBodiesCB'     => json_encode(\App\Body::bodiesCB()),
            'seo'              => [
                'pageTitle' => 'Provider Boards',
            ],
        ];

        return view('provider.board.index', $data);
    }

    public function create($professional_id)
    {
        if ($this->authUserCannot('create-professional-board')) {
            return redirect()->back()->withError(self::ERROR_NOT_ENOUGH_PRIVILEGES);
        }

        $professional = \App\Professional::find($professional_id);

        $data = [
            'encToken'             => app('Illuminate\Encryption\Encrypter')->encrypt(csrf_token()),
            'equation'             => $this->equation(),
            'professional_id'      => $professional_id,
            'professionalName'     => $professional->fullName,
            'provider_id'          => $professional->provider_id,
            'specialityTypesCB'    => \App\SpecialityType::specialityTypesCB(['0' => 'Select speciality type']),
            'specialitySubtypesCB' => [],
            'bodiesCB'             => \App\Body::bodiesCB(['0' => 'Select body']),
            'certificationsCB'     => \App\Certification::certificationsCB(['0' => 'Select certification']),
            'countriesCB'          => \App\Country::countriesCB(['0' => 'Select Country']),
            'statesCB'             => [],
            'seo'                  => [
                'pageTitle' => 'Add Board',
            ],
        ];

        return view('provider.board.create', $data);
    }

    public function store(ProfessionalBoardRequest $request)
    {
        if ($this->authUserCannot('create-professional-board')) {
            return redirect()->back()->withError(self::ERROR_NOT_ENOUGH_PRIVILEGES);
        }

        $inputs = $request->all();

        if (!empty($inputs['issued_at'])) {
            $inputs['issued_at'] = date('Y-m-d', strtotime($inputs['issued_at']));
        }
        if (!empty($inputs['expired_at'])) {
            $inputs['expired_at'] = date('Y-m-d', strtotime($inputs['expired_at']));
        }

        ProfessionalBoard::create($inputs);

        return redirect()->route('professional_board_list_path', ['professional_id' => $inputs['professional_id']])->withSuccess('Board added.');
    }

    public function edit(ProfessionalBoard $board)
    {
        if ($this->authUserCannot('update-professional-board')) {
            return redirect()->back()->with('error', self::ERROR_NOT_ENOUGH_PRIVILEGES);
        }

        $professional = \App\Professional::find($board->professional_id);

        $data = [
            'encToken'             => app('Illuminate\Encryption\Encrypter')->encrypt(csrf_token()),
            'board'                => $board,
            'equation'             => $this->equation(),
            'professional_id'      => $board->professional_id,
            'professionalName'     => $professional->fullName,
            'provider_id'          => $professional->provider_id,
            'specialityTypesCB'    => \App\SpecialityType::specialityTypesCB(),
            'specialitySubtypesCB' => \App\SpecialitySubtype::specialitySubtypesCB($board->speciality_type_id),
            'bodiesCB'             => \App\Body::bodiesCB(),
            'certificationsCB'     => \App\Certification::certificationsCB(),
            'countriesCB'          => \App\Country::countriesCB(),
            'statesCB'             => \App\State::statesCB($board->country_id),
            'seo'                  => [
                'pageTitle' => 'Update Board',
            ],
        ];

        return view('provider.board.edit', $data);
    }

    public function update(ProfessionalBoard $board, ProfessionalBoardRequest $request)
    {
        if ($this->authUserCannot('update-professional-board')) {
            return redirect()->back()->with('error', self::ERROR_NOT_ENOUGH_PRIVILEGES);
        }

        $inputs = $request->all();

        $inputs['issued_at'] = !empty($inputs['issued_at']) ? date('Y-m-d', strtotime($inputs['issued_at'])) : null;
        $inputs['expired_at'] = !empty($inputs['expired_at']) ? date('Y-m-d', strtotime($inputs['expired_at'])) : null;

        $board->update($inputs);

        return redirect()->route('professional_board_list_path', ['professional_id' => $board->professional_id])->withSuccess('Board updated.');
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
                $professionalBoard = ProfessionalBoard::find($id);
                $professionalBoard->{$name} = $value;
                $professionalBoard->save();

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
        if ($this->authUserCannot('delete-professional-board')) {
            return redirect()->back()->withError(self::ERROR_NOT_ENOUGH_PRIVILEGES);
        }

        $strCid = $request->input('strCid');
        if (empty($strCid)) {
            return redirect()->back()->withError('There is no board selected.');
        }
        $arrCid = explode('|', $strCid);

        foreach ($arrCid as $id) {
            $professionalBoard = ProfessionalBoard::find($id);
            $professionalBoard->delete();
        }

        return redirect()->route('professional_board_list_path', ['professional_id' => $request->input('professional_id')])->withSuccess('Board deleted.');
    }

}
