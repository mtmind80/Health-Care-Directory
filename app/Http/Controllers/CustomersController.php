<?php namespace App\Http\Controllers;

use App\Http\Requests;

use Illuminate\Http\Request;

use App\Customer;
use App\Http\Requests\CustomerRequest;

use EquationTrait;

class CustomersController extends CommonController
{
    use EquationTrait;

    public function index(Request $request)
    {
        if ($this->authUserCannot('list-customer')) {
            return redirect()->back()->withError(self::ERROR_NOT_ENOUGH_PRIVILEGES);
        }

        $perPage = $request->input('perPage') ? $request->input('perPage') : 10;
        $customers = Customer::sortable()->paginate($perPage);

        $data = [
            'encToken'  => app('Illuminate\Encryption\Encrypter')->encrypt(csrf_token()),
            'customers' => $customers,
            'needle'    => null,
            'seo'       => [
                'pageTitle' => 'Customers',
            ],
        ];

        return view('customer.index', $data);
    }

    public function search(Request $request)
    {
        if ($this->authUserCannot('search-customer')) {
            return redirect()->back()->withError(self::ERROR_NOT_ENOUGH_PRIVILEGES);
        }

        $this->validate($request, [
            'needle' => 'min:3',
        ]);

        $needle = $request->needle;
        $perPage = $request->input('perPage') ? $request->input('perPage') : 10;
        $customers = Customer::search($needle)->sortable()->paginate($perPage);
        $data = [
            'encToken'  => app('Illuminate\Encryption\Encrypter')->encrypt(csrf_token()),
            'customers' => $customers,
            'needle'    => $needle,
            'seo'       => [
                'pageTitle' => 'Customers',
            ],
        ];

        return view('customer.index', $data);
    }

    public function create()
    {
        if ($this->authUserCannot('create-customer')) {
            return redirect()->back()->withError(self::ERROR_NOT_ENOUGH_PRIVILEGES);
        }

        $data = [
            'encToken' => app('Illuminate\Encryption\Encrypter')->encrypt(csrf_token()),
            'equation' => $this->equation(),
            'seo'      => [
                'pageTitle' => 'Create Customer',
            ],
        ];

        return view('customer.create', $data);
    }

    public function store(CustomerRequest $request)
    {
        if ($this->authUserCannot('create-customer')) {
            return redirect()->back()->withError(self::ERROR_NOT_ENOUGH_PRIVILEGES);
        }

        $inputs = $request->all();

        if (empty($inputs['disable'])) {
            $inputs['disable'] = 0;
        }

        Customer::create($inputs);

        return redirect()->route('customer_list_path')->withSuccess('Customer created.');
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
                $customer = Customer::find($id);
                $customer->{$name} = $value;
                $customer->save();

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
        if ($this->authUserCannot('update-customer')) {
            return redirect()->back()->withError(self::ERROR_NOT_ENOUGH_PRIVILEGES);
        }

        $customer = Customer::find($id);
        $customer->disabled = !$customer->disabled;
        $customer->save();

        return redirect()->back()->withSuccess('Customer status toggled.');
    }

    public function destroy(Request $request)
    {
        if ($this->authUserCannot('delete-customer')) {
            return redirect()->back()->withError(self::ERROR_NOT_ENOUGH_PRIVILEGES);
        }

        $strCid = $request->input('strCid');
        if (empty($strCid)) {
            return redirect()->back()->withError('There is no customer selected.');
        }
        $arrCid = explode('|', $strCid);

        Customer::destroy($arrCid);

        return redirect()->route('customer_list_path')->withSuccess('Customer deleted.');
    }

}
