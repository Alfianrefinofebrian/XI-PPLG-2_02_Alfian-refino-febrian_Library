<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use Illuminate\Http\Request;

class LoanController extends Controller
{
    public function index()
    {
        return response()->json(Loan::with(['book', 'user'])->get());
    }

    public function store(Request $request)
    {
        $request->validate([
            'book_id' => 'required|exists:books,id',
            'user_id' => 'required|exists:users,id',
            'loan_date' => 'required|date',
            'return_date' => 'nullable|date|after_or_equal:loan_date',
            'status' => 'required|in:borrowed,returned',
        ]);

        $loan = Loan::create($request->all());

        return response()->json($loan, 201);
    }

    public function show(Loan $loan)
    {
        return response()->json($loan->load(['book', 'user']));
    }

    public function update(Request $request, Loan $loan)
    {
        $request->validate([
            'return_date' => 'nullable|date|after_or_equal:loan_date',
            'status' => 'required|in:borrowed,returned',
        ]);

        $loan->update($request->all());

        return response()->json($loan);
    }

    public function destroy(Loan $loan)
    {
        $loan->delete();
        return response()->json(null, 204);
    }
}