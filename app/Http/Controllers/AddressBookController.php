<?php

namespace App\Http\Controllers;

use App\Models\AddressBook;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class AddressBookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        return view('address-books.index', [
            'addressBooks' => AddressBook::orderBy('id', 'asc')->paginate(15),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('address-books.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = [
            'due_date' => 7
        ];
        $created = $request->user()->addressBooks()->create($validated);

        foreach ($request->billing_code as $key => $billing) {

            $phonecode  = substr($request->billing_phonecode[$key], 1, 3);
            $phone      = substr(str_replace(' ', '', $request->billing_phone[$key]), 4, 9);

            $data = [
                'billing_code'          => $billing,
                'billing_company_name'  => $request->billing_company_name[$key],
                'billing_company_id'    => $request->billing_company_id[$key],
                'billing_vat_id'        => $request->billing_vat_id[$key],
                'billing_first_name'    => $request->billing_first_name[$key],
                'billing_last_name'     => $request->billing_last_name[$key],
                'billing_address'       => $request->billing_address[$key],
                'billing_address_ext'   => $request->billing_address_ext[$key],
                'billing_postcode'      => $request->billing_postcode[$key],
                'billing_city'          => $request->billing_city[$key],
                'billing_phonecode'     => $phonecode[$key],
                'billing_phone'         => $phone[$key],
                'billing_email'         => $request->billing_email[$key],
            ];

            $validator = Validator::make($data, [
                'billing_code'          => 'required|string|max:4',
                'billing_company_name'  => 'string|max:128|nullable',
                'billing_company_id'    => 'string|max:8|nullable',
                'billing_vat_id'        => 'string|max:12|nullable',
                'billing_first_name'    => 'required|string|max:128',
                'billing_last_name'     => 'required|string|max:128',
                'billing_address'       => 'required|string|max:255',
                'billing_address_ext'   => 'string|max:255|nullable',
                'billing_postcode'      => 'required|string|max:12',
                'billing_city'          => 'required|string|max:128',
                'billing_phonecode'     => 'required|string|max:3',
                'billing_phone'         => 'required|string|max:9',
                'billing_email'         => 'required|string|max:128',
            ]);

            if (!$validator->fails()) {
                DB::table('address_books_billing')->insert([
                    'address_book_id'   => $created->id,
                    'code'              => $data['billing_code'],
                    'company_id'        => $data['billing_company_id'],
                    'vat_id'            => $data['billing_vat_id'],
                    'first_name'        => $data['billing_first_name'],
                    'last_name'         => $data['billing_last_name'],
                    'address'           => $data['billing_address'],
                    'address_ext'       => $data['billing_address_ext'],
                    'postcode'          => $data['billing_postcode'],
                    'city'              => $data['billing_city'],
                    'phonecode'         => $data['billing_phonecode'],
                    'phone'             => $data['billing_phone'],
                    'email'             => $data['billing_email'],
                ]);
            }
        }

        if (isset($request->branch_code)) {
            foreach ($request->branch_code as $key => $branch) {

                $phonecode  = substr($request->branch_phonecode[$key], 1, 3);
                $phone      = substr(str_replace(' ', '', $request->branch_phone[$key]), 4, 9);

                $data = [
                    'branch_code'          => $branch,
                    'branch_company_name'  => $request->branch_company_name[$key],
                    'branch_company_id'    => $request->branch_company_id[$key],
                    'branch_vat_id'        => $request->branch_vat_id[$key],
                    'branch_first_name'    => $request->branch_first_name[$key],
                    'branch_last_name'     => $request->branch_last_name[$key],
                    'branch_address'       => $request->branch_address[$key],
                    'branch_address_ext'   => $request->branch_address_ext[$key],
                    'branch_postcode'      => $request->branch_postcode[$key],
                    'branch_city'          => $request->branch_city[$key],
                    'branch_phonecode'     => $phonecode,
                    'branch_phone'         => $phone,
                    'branch_email'         => $request->branch_email[$key],
                ];
    
                $validator = Validator::make($data, [
                    'branch_code'          => 'required|string|max:4',
                    'branch_company_name'  => 'string|max:128|nullable',
                    'branch_company_id'    => 'string|max:8|nullable',
                    'branch_vat_id'        => 'string|max:12|nullable',
                    'branch_first_name'    => 'required|string|max:128',
                    'branch_last_name'     => 'required|string|max:128',
                    'branch_address'       => 'required|string|max:255',
                    'branch_address_ext'   => 'string|max:255|nullable',
                    'branch_postcode'      => 'required|string|max:12',
                    'branch_city'          => 'required|string|max:128',
                    'branch_phonecode'     => 'required|string|max:3',
                    'branch_phone'         => 'required|string|max:9',
                    'branch_email'         => 'required|string|max:128',
                ]);
    
                if (!$validator->fails()) {
                    DB::table('address_books_branch')->insert([
                        'address_book_id'   => $created->id,
                        'code'              => $data['branch_code'],
                        'company_id'        => $data['branch_company_id'],
                        'vat_id'            => $data['branch_vat_id'],
                        'first_name'        => $data['branch_first_name'],
                        'last_name'         => $data['branch_last_name'],
                        'address'           => $data['branch_address'],
                        'address_ext'       => $data['branch_address_ext'],
                        'postcode'          => $data['branch_postcode'],
                        'city'              => $data['branch_city'],
                        'phonecode'         => $data['branch_phonecode'],
                        'phone'             => $data['branch_phone'],
                        'email'             => $data['branch_email'],
                    ]);
                }
            }
        }
        return redirect(route('address-book.index'))->with('message', __('messages.alert.successfully_created'));
    }

    /**
     * Display the specified resource.
     */
    public function show(AddressBook $addressBook)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(AddressBook $addressBook)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, AddressBook $addressBook)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AddressBook $addressBook)
    {
        //
    }
}
