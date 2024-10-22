<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Collection;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $customers = [];
        return view('customers.index', [
            'customers' => DB::table('customers')
                                ->join('customer_groups', 'customers.customer_group', '=', 'customer_groups.id')
                                ->join('customer_groups_locales', 'customer_groups.id', '=', 'customer_groups_locales.group_id')
                                ->select('customers.id', 'customers.email', 'customer_groups_locales.title as group_name')
                                ->where('customer_groups_locales.locale', '=', app()->getLocale())
                                ->orderBy('id', 'desc')
                                ->paginate(15),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request): Collection|View|JsonResponse
    {
        if ($request->ajax()) {

            $email = $request->get(key: 'email');
            $data = Db::table('users')
                        ->select('id')
                        ->where('email', '=', $email)
                        ->first();
            return response()->json($data);

        }
        return view('customers.create', [
            'groups' => DB::table('customer_groups')
                            ->join('customer_groups_locales', 'customer_groups.id', '=', 'customer_groups_locales.group_id')
                            ->select('customer_groups.id', 'customer_groups_locales.title')
                            ->where('customer_groups_locales.locale', '=', app()->getLocale())
                            ->orderBy('customer_groups_locales.title', 'asc')
                            ->get(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'customer_group' => ['required', 'int'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.Customer::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        Customer::create([
            'customer_group' => $request->customer_group,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        return redirect(route('customer.index'))->with('message', __('messages.alert.successfully_created'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Customer $customer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Customer $customer): View
    {
        return view('customers.edit', [
            'customer'  => $customer,
            'groups'    => DB::table('customer_groups')
                            ->join('customer_groups_locales', 'customer_groups.id', '=', 'customer_groups_locales.group_id')
                            ->select('customer_groups.id', 'customer_groups_locales.title')
                            ->where('customer_groups_locales.locale', '=', app()->getLocale())
                            ->orderBy('customer_groups_locales.title', 'asc')
                            ->get(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Customer $customer): RedirectResponse
    {
        $validated = $request->validate([
            'customer_group' => ['required', 'int'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);
        $customer->update($validated);

        return redirect(route('customer.index'))->with('message', __('messages.alert.successfully_updated'));;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Customer $customer): RedirectResponse
    {
        DB::table('customers')->where('id', '=', $customer->id)->delete();
        return redirect(route('customer.index'))->with('message', __('messages.alert.removed'));
    }
}
