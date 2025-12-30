<?php

namespace Admin\App\Http\Controllers\Genealogy;

use Admin\App\Http\Controllers\Controller;
use Admin\App\Models\Genealogy\MGraphicalGenealogyTemplate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\Middleware\MURLCrypt;
use App\Models\Middleware\MMatrixDetails;
use App\Models\Genealogy\MGenealogy;


class GraphicalGenealogyTemplateController extends Controller
{

      public function setGenealogyTemplate(Request $request)
    {

        // dd('function reached or not ');
        try {
            // Get the type from query string (?do=...)
            $graphicalGenealogyType = $request->query('do');

            // Get the JSON payload from request
            $data = $request->json()->all();

            // Extract values
            $templateKey = $data['templateKey'] ?? null;
            $templateValue = $data['templateValue'] ?? null;

            if (!$templateKey || !$templateValue) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'templateKey and templateValue are required.'
                ], 400);
            }

            // Prefix based on the genealogy type using if-else
            if ($graphicalGenealogyType === 'grpgenealogy') {
                $templateKey = 'graphical_genealogy_' . trim($templateKey);
            } elseif ($graphicalGenealogyType === 'countgenealogy') {
                $templateKey = 'count_genealogy_' . trim($templateKey);
            } elseif ($graphicalGenealogyType === 'rankgenealogy') {
                $templateKey = 'rank_genealogy_' . trim($templateKey);
            } else {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Invalid genealogy type.'
                ], 400);
            }

            // Call your model method
            MGraphicalGenealogyTemplate::setGenealogyTemplate($templateKey, $templateValue);

            return response()->json([
                'status' => 'success',
                'message' => 'Template updated successfully.'
            ]);
        } catch (Exception $e) {
            // Log the error if needed
            \Log::error('Genealogy template error: ' . $e->getMessage());

            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }

}
