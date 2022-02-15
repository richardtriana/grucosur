<?php

namespace App\Http\Controllers;

use App\Models\Credit;
use App\Models\Installment;
use Illuminate\Http\Request;

class ReportController extends Controller
{
	public function ReportCredits()
	{
		$now = date("Y-m-d");
		$payment_date_add_days = date("Y-m-d", strtotime($now . "+ 5 days"));

		$installments = Installment::select('installments.*', 'credits.client_id', 'clients.name', 'clients.last_name', 'credits.credit_value')
			->whereDate('payment_date', '<=', $payment_date_add_days)
			->whereNull('payment_register')
			->leftJoin('credits', 'installments.credit_id', 'credits.id')
			->leftJoin('clients', 'credits.client_id', 'clients.id')
			->paginate(10);

		return $installments;
	}
}
