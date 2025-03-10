namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Grade;

class GradeController extends Controller
{
    public function getGrade($id)
    {
        $grade = Grade::find($id);

        if (!$grade) {
            return response()->json(['Student not found'], 404);
        }

        return response()->json([
            'finalGrade' => (float) $grade->finalGrade,
            'status' => $grade->status
        ]);
    }
}
