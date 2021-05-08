<?php
/**
 * This file implements Payment ontroller.
 * PHP version 7.2
 *
 * @category Class
 * @package  PaymentController
 * @author   Rose-Finch <info.codehas@gmail.com>
 * @license  https://codecanyon.net/licenses/standard  Standard Licenses
 * @link     https://www.codehas.com
 */
namespace App\Http\Controllers;

use App\Chapter;
use App\DataTables\PaymentDataTable;
use App\Events\LogActivity;
use App\Http\Requests\PaymentRequest;
use App\Payment;
use Illuminate\Http\Request;

/**
 * Controls the data flow into a payment object
 * and updates the view whenever data changes.
 *
 * @category Class
 * @package  PaymentController
 * @author   Rose-Finch <info.codehas@gmail.com>
 * @license  https://codecanyon.net/licenses/standard  Standard Licenses
 * @link     https://www.codehas.com
 */
class PaymentController extends Controller
{

    /**
     * Constructs a new instance.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource
     *
     * @param \App\DataTables\PaymentDataTable $dataTable The data table
     *
     * @return \Illuminate\Http\Response
     */
    public function index(PaymentDataTable $dataTable)
    {
        $this->authorize('manage', Payment::class);
        return $dataTable->render('management.payments.list');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $this->authorize('create', Payment::class);
        return view('entries.payment.create');
    }

    /**
     * Store a newly created resource in storage
     *
     * @param \App\Http\Requests\PaymentRequest $request The request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(PaymentRequest $request)
    {
        $this->authorize('create', Payment::class);
        $gateway = Payment::create($this->_validPayment($request));
        event(
            new LogActivity(
                $gateway->title,
                ' ' . trans('feed.newPaymentGatewayAdded'),
                trans('feed.payment')
            )
        );
        return response()->json(
            [
                'message' => trans('feed.newPaymentGatewayAdded'),
            ],
            200
        );
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Payment $payment The payment
     *
     * @return \Illuminate\View\View
     */
    public function show(Payment $payment)
    {
        return view('management.payments.show', compact('payment'));
    }

    /**
     * Show the form for editing the specified resource
     *
     * @param \App\Payment $payment The payment
     *
     * @return \Illuminate\View\View
     */
    public function edit(Payment $payment)
    {
        $this->authorize('manage', Payment::class);
        return view('management.payments.edit', compact('payment'));
    }

    /**
     * Update the specified resource in storage
     *
     * @param \App\Http\Requests\PaymentRequest $request The request
     * @param \App\Payment                      $payment The payment
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(PaymentRequest $request, Payment $payment)
    {
        $this->authorize('manage', Payment::class);
        $payment->update($this->_validPayment($request));
        event(
            new LogActivity(
                $payment->title,
                ' ' . trans('feed.newPaymentGatewayUpdated'),
                trans('feed.payment')
            )
        );
        return response()->json(
            [
                'message' => trans('feed.newPaymentGatewayUpdated'),
            ],
            200
        );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Payment $payment The payment
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Payment $payment)
    {
        $this->authorize('manage', Payment::class);
        if (Chapter::where('status', 1)->get()->count() > 0) {
            return back()->with(
                'message',
                trans('feed.closeAllSaleChapters')
            );
        }
        event(
            new LogActivity(
                $payment->title,
                ' ' . trans('feed.paymentGatewayRemoved'),
                trans('feed.payment')
            )
        );
        $payment->delete();
        return redirect(route('payment.index'))
            ->with('success', trans('feed.paymentGatewayRemoved'));
    }

    /**
     * Toggle state
     *
     * @param \Illuminate\Http\Request $request The request
     * @param \App\Payment             $payment The payment
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function toggle(Request $request, Payment $payment)
    {
        $this->authorize('manage', Payment::class);
        if ($request->payment_code == $payment->code) {
            $payment->update(['state' => $payment->state ? 0 : 1]);
            event(
                new LogActivity(
                    $payment->title,
                    ' ' . trans('feed.paymentGatewayStateToggled'),
                    trans('feed.payment')
                )
            );
            return back()->with(
                'success',
                trans('feed.paymentGatwayStateToggledSuccessfully')
            );
        }
        return back()->with('info', trans('feed.tryAgain'));
    }

    /**
     * Gives Valid Request
     *
     * @param mixed $request The request
     *
     * @return array
     */
    private function _validPayment($request)
    {
        return [
            'title' => $request->title,
            'code' => $request->code,
            'state' => $request->state,
            'detail' => $request->detail,
        ];
    }

    /**
     * Display all tax methods for point of sale
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function pos()
    {
        return Payment::where('state', 1)->latest()->get();
    }
}
