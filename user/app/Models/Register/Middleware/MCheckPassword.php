<?php
namespace User\App\Models\Register\Middleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MCheckPassword{
    /**
     * This public static function is used to check password
     * @return boolean data
    */
  
public function checkPassword(Request $request): bool
{
    $validator = Validator::make($request->all(), [
        'members_password' => [
            'required',
            'string',
            'min:9', // greater than 8
            'regex:/[0-9]/',        // must contain a number
            'regex:/[A-Z]/',        // must contain an uppercase letter
            'regex:/[a-z]/',        // must contain a lowercase letter
            'regex:/[\W_]/',        // must contain a special character
        ],
    ]);

    if ($validator->fails()) {
        return false;
    }

    return true;
}

}
?>