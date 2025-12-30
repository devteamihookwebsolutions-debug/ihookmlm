<?php
namespace Admin\App\Models\MatrixConfig;
use Admin\App\Models\Member\BinaryRatio;
use Admin\App\Models\Member\CarryOver;
use Illuminate\Http\Request;
use Admin\App\Display\MatrixConfig\DMatrixBinary;

class MMatrixBinary
{

    public static function getBinaryRatio($name, $id, $editable)
    {
        // Retrieve all records where status = 0
        $records = BinaryRatio::where('status', 0)->get();

        // Assuming DMatrixBinary::getBinaryRatio is a custom method somewhere in your app
        return DMatrixBinary::getBinaryRatio($records, $name, $id, $editable);
    }

        public static function getCarryOver($name, $id, $editable)
    {
        // Fetch all carryover records with status = 0
        $records = Carryover::where('status', 0)->get();

        // Assuming DMatrixBinary::getCarryOver() is still to be used
        return DMatrixBinary::getCarryOver($records, $name, $id, $editable);
    }
}