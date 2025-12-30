<?php
namespace User\App\Http\Controllers\Genealogy;
use Admin\App\Models\Middleware\MURLCrypt;
use User\App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class GenealogySearchController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function search(Request $request)
    {
        try {
            $payload   = $request->json()->all();
            $encrypt   = $payload['encrypturl'] ?? null;
            $username  = $payload['members_username'] ?? null;

            [$members_id, $matrix_id] = MURLCrypt::getDecryptURL($encrypt);

            return response(MGenealogySearch::getSearchMemberDetails($username, $matrix_id));
        } catch (\Exception $e) {
            session(['error_message' => $e->getMessage()]);
            return redirect()->route('genealogy.search');
        }
    }
}
