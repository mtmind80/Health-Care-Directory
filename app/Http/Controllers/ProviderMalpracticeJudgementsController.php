<?php namespace App\Http\Controllers;

use App\Http\Requests;

use Illuminate\Http\Request;

use App\ProviderMalpracticeJudgement;
use App\Http\Requests\ProviderMalpracticeJudgementRequest;

use ProviderMalpracticeJudgementObserver;

use EquationTrait;

class ProviderMalpracticeJudgementsController extends CommonController
{
    use EquationTrait;

    public function __construct()
    {
        parent::__construct();

        ProviderMalpracticeJudgement::observe(new ProviderMalpracticeJudgementObserver);
    }

    public function index(Request $request, $malpractice_id)
    {
        if ($this->authUserCannot('list-provider-malpractice-judgement')) {
            return redirect()->back()->withError(self::ERROR_NOT_ENOUGH_PRIVILEGES);
        }

        $perPage = $request->input('perPage') ? $request->input('perPage') : 10;
        $judgements = ProviderMalpracticeJudgement::sortable()->malpractice($malpractice_id)->paginate($perPage);

        $malpractice = \App\ProviderMalpractice::find($malpractice_id);

        $data = [
            'encToken'       => app('Illuminate\Encryption\Encrypter')->encrypt(csrf_token()),
            'judgements'     => $judgements,
            'needle'         => null,
            'malpractice_id' => $malpractice_id,
            'provider_id'    => $malpractice->provider_id,
            'providerName'   => $malpractice->provider->name,
            'policyNumber'   => $malpractice->policy_number,
            'seo'            => [
                'pageTitle' => 'Provider Malpractice Judgements',
            ],
        ];

        return view('provider.malpractice.judgement.index', $data);
    }

    public function search(Request $request, $malpractice_id)
    {
        if ($this->authUserCannot('search-provider-malpractice-judgement')) {
            return redirect()->back()->withError(self::ERROR_NOT_ENOUGH_PRIVILEGES);
        }

        $this->validate($request, [
            'needle' => 'min:3',
        ]);

        $malpractice = \App\ProviderMalpractice::find($malpractice_id);

        $needle = $request->needle;
        $perPage = $request->input('perPage') ? $request->input('perPage') : 10;
        $judgements = ProviderMalpracticeJudgement::search($needle)->provider($malpractice_id)->sortable()->paginate($perPage);

        $data = [
            'encToken'       => app('Illuminate\Encryption\Encrypter')->encrypt(csrf_token()),
            'judgements'     => $judgements,
            'needle'         => $needle,
            'malpractice_id' => $malpractice_id,
            'provider_id'    => $malpractice->provider_id,
            'providerName'   => $malpractice->provider->name,
            'policyNumber'   => $malpractice->policy_number,
            'seo'            => [
                'pageTitle' => 'Provider Malpractice Judgements',
            ],
        ];

        return view('provider.malpractice.judgement.index', $data);
    }

    public function create($malpractice_id)
    {
        if ($this->authUserCannot('create-provider-malpractice-judgement')) {
            return redirect()->back()->withError(self::ERROR_NOT_ENOUGH_PRIVILEGES);
        }

        $malpractice = \App\ProviderMalpractice::find($malpractice_id);

        $data = [
            'encToken'       => app('Illuminate\Encryption\Encrypter')->encrypt(csrf_token()),
            'equation'       => $this->equation(),
            'malpractice_id' => $malpractice_id,
            'provider_id'    => $malpractice->provider_id,
            'providerName'   => $malpractice->provider->name,
            'policyNumber'   => $malpractice->policy_number,
            'offenseTypesCB' => \App\OffenseType::offenseTypesCB(['0' => 'Select offense type']),
            'seo'            => [
                'pageTitle' => 'Add Malpractice Judgement',
            ],
        ];

        return view('provider.malpractice.judgement.create', $data);
    }

    public function store(ProviderMalpracticeJudgementRequest $request)
    {
        if ($this->authUserCannot('create-provider-malpractice-judgement')) {
            return redirect()->back()->withError(self::ERROR_NOT_ENOUGH_PRIVILEGES);
        }

        $inputs = $request->all();

        $inputs['occurred_at'] = !empty($inputs['occurred_at']) ? date('Y-m-d', strtotime($inputs['occurred_at'])) : null;
        $inputs['reported_at'] = !empty($inputs['reported_at']) ? date('Y-m-d', strtotime($inputs['reported_at'])) : null;
        $inputs['settled_at'] = !empty($inputs['settled_at']) ? date('Y-m-d', strtotime($inputs['settled_at'])) : null;

        ProviderMalpracticeJudgement::create($inputs);

        return redirect()->route('provider_malpractice_judgement_list_path', ['malpractice_id' => $inputs['malpractice_id']])->withSuccess('Provider malpractice judgement added.');
    }

    public function edit(ProviderMalpracticeJudgement $judgement)
    {
        if ($this->authUserCannot('update-provider-malpractice-judgement')) {
            return redirect()->back()->with('error', self::ERROR_NOT_ENOUGH_PRIVILEGES);
        }

        $malpractice = \App\ProviderMalpractice::find($judgement->malpractice_id);

        $data = [
            'encToken'       => app('Illuminate\Encryption\Encrypter')->encrypt(csrf_token()),
            'judgement'      => $judgement,
            'equation'       => $this->equation(),
            'malpractice_id' => $malpractice->id,
            'provider_id'    => $malpractice->provider_id,
            'providerName'   => $malpractice->provider->name,
            'policyNumber'   => $malpractice->policy_number,
            'offenseTypesCB' => \App\OffenseType::offenseTypesCB(),
            'seo'            => [
                'pageTitle' => 'Edit Providermalpracticejudgement Application',
            ],
        ];

        return view('provider.malpractice.judgement.edit', $data);
    }

    public function update(Providermalpracticejudgement $providerMalpracticeJudgement, ProviderMalpracticeJudgementRequest $request)
    {
        if ($this->authUserCannot('update-provider-malpractice-judgement')) {
            return redirect()->back()->with('error', self::ERROR_NOT_ENOUGH_PRIVILEGES);
        }

        $inputs = $request->all();

        if (empty($inputs['defendant'])) {
            $inputs['defendant'] = 0;
        }
        if (empty($inputs['dismissed'])) {
            $inputs['dismissed'] = 0;
        }
        if (empty($inputs['primary_sourced'])) {
            $inputs['primary_sourced'] = 0;
        }

        $inputs['occurred_at'] = !empty($inputs['occurred_at']) ? date('Y-m-d', strtotime($inputs['occurred_at'])) : null;
        $inputs['reported_at'] = !empty($inputs['reported_at']) ? date('Y-m-d', strtotime($inputs['reported_at'])) : null;
        $inputs['settled_at'] = !empty($inputs['settled_at']) ? date('Y-m-d', strtotime($inputs['settled_at'])) : null;

        $providerMalpracticeJudgement->update($inputs);

        return redirect()->route('provider_malpractice_judgement_list_path', ['malpractice_id' => $providerMalpracticeJudgement->malpractice_id])->with('success', 'Providermalpracticejudgement updated.');
    }

    public function destroy(Request $request)
    {
        if ($this->authUserCannot('delete-provider-malpractice-judgement')) {
            return redirect()->back()->withError(self::ERROR_NOT_ENOUGH_PRIVILEGES);
        }

        $strCid = $request->input('strCid');
        if (empty($strCid)) {
            return redirect()->back()->withError('There is no malpractice judgement selected.');
        }
        $arrCid = explode('|', $strCid);

        foreach ($arrCid as $id) {
            $judgement = ProviderMalpracticeJudgement::find($id);
            $judgement->delete();
        }

        return redirect()->route('provider_malpractice_judgement_list_path', ['malpractice_id' => $request->input('malpractice_id')])->withSuccess('Judgement deleted.');
    }

}
