<?php

namespace Admin\App\Http\Controllers\MatrixConfig;

use Admin\App\Http\Controllers\Controller;
use Admin\App\Models\MatrixConfig\MMatrix;
use Admin\App\Models\MatrixConfig\MSetMatrixConfiguration;
use Admin\App\Models\Middleware\MAdminActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Exception;

class MatrixController extends Controller
{
    public function index()
    {
        try {
            $matrices = MMatrix::showMatrix(); // Use $matrices instead of $matrix
            session()->forget(['success_message', 'error_message']);
            return view('matrixconfig.matrix', compact('matrices'));
        } catch (Exception $e) {
            session()->flash('error_message', $e->getMessage());
            return view('matrixconfig.matrix', [
                'matrices' => collect([]),
                'error' => $e->getMessage(),
            ]);
        }
    }

    public function create($step = 1)
{
    try {
        // Ensure step is valid (1, 2, or 3)
        $step = in_array($step, [1, 2, 3]) ? $step : 1;

        // Fetch matrix types for Step 2
        $matrixTypes = MMatrix::getMatrixTypesWizard(request()->input('matrix_type_id'));

        // Retrieve matrix data from session (for Steps 2 and 3)
        $matrixData = session('matrix_data', []);

        session()->forget(['success', 'error_message']);

        return view('matrixconfig.addmatrix', compact('step', 'matrixTypes', 'matrixData'));
    } catch (Exception $e) {
        session()->flash('error_message', $e->getMessage());
        return redirect()->route('admin.matrixconfig.matrix');
    }
}

    public function checkMatrixName(Request $request)
    {
        return response()->json(MMatrix::checkMatrixName($request->matrix_name));
    }

    public function store(Request $request)
    {
        try {
            $step = $request->input('step', 1);
            $matrixData = session('matrix_data', []);

            if ($step > 1 && empty($matrixData['matrix_name'])) {
                session()->flash('error_message', 'Session expired. Please start over.');
                return redirect()->route('admin.plans.create', 1);
            }

            if ($step == 1) {
                $validated = $request->validate([
                    'matrix_name' => 'required|string|max:255|unique:ihook_matrix_table,matrix_name', // Added unique validation like first code
                ]);
                $matrixData['matrix_name'] = $validated['matrix_name'];
                session(['matrix_data' => $matrixData]);

                \Log::info('Step 1 completed', ['matrix_name' => $matrixData['matrix_name']]);

                return redirect()->route('admin.plans.create', 2)->with('success', 'Plan name saved!');
            } elseif ($step == 2) {
                $validated = $request->validate([
                    'matrix_type_id' => 'required|integer|exists:ihook_matrix_type_table,matrix_type_id',
                ]);
                $matrixData['matrix_type_id'] = $validated['matrix_type_id'];
                session(['matrix_data' => $matrixData]);

                \Log::info('Step 2 completed', ['matrix_type_id' => $matrixData['matrix_type_id']]);

                return redirect()->route('admin.plans.create', 3)->with('success', 'Plan type selected!');
            } elseif ($step == 3) {
                $validated = $request->validate([
                    'status' => 'nullable|in:0,1',
                ]);

                if (empty($matrixData['matrix_name']) || empty($matrixData['matrix_type_id'])) {
                    return redirect()->route('admin.plans.create', 1)->with('error', 'Please complete previous steps.');
                }

                $finalData = [
                    'matrix_name' => $matrixData['matrix_name'],
                    'matrix_type_id' => $matrixData['matrix_type_id'],
                    'matrix_status' => $validated['status'] ?? 0, // Default to 0 if not provided
                    'matrix_default' => 0, // Default value if required
                    'created_by' => auth()->id() ?? 1,
                    'created_on' => now(),
                    'updated_by' => auth()->id() ?? 1,
                    'updated_on' => now(),
                ];

                $matrix = MMatrix::insertMatrix($finalData); // Adjust if it doesn't return the object/ID

                        // Clear session
                session()->forget('matrix_data');

                \Log::info('Plan created successfully', ['matrix_id' => $matrix->matrix_id]);

                return redirect()->route('admin.plans.success')->with('success', 'Plan created successfully!');
            }

            return redirect()->route('admin.plans.create', 1);
        } catch (\Illuminate\Validation\ValidationException $e) {
            \Log::error('Validation failed', ['errors' => $e->errors(), 'step' => $step]);
            throw $e;
        } catch (Exception $e) {
            \Log::error('Error in store method', [
                'step' => $step,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            $redirectTo = $step == 1 ? 1 : ($step == 2 ? 2 : 3);
            session()->flash('error_message', 'Failed to save step ' . $step . '. ' . $e->getMessage());
            return redirect()->route('admin.plans.create', $redirectTo);
        }
    }
  public function success()
    {
        try {
            // Check if there's a success message in the session
            if (!session('success_message')) {
                session()->flash('success_message', 'Plan created successfully!');
            }
            return view('matrixconfig.success'); // Adjust to match your view path
        } catch (Exception $e) {
            \Log::error('Error in success method', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            session()->flash('error_message', 'An error occurred while displaying the success page.');
            return redirect()->route('admin.plans');
        }
    }

    public function validateSetConfig(Request $request, $matrixId)
    {
        try {
            MSetMatrixConfiguration::insertMatrixConfiguration($request, $matrixId);
            return redirect()->route('admin.plans')->with('success', 'Matrix configuration has been saved');
        } catch (Exception $e) {
            \Log::error('Error in validateSetConfig method', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return redirect()->route('admin.plans')->with('error', 'Failed to save matrix configuration');
        }
    }
}
