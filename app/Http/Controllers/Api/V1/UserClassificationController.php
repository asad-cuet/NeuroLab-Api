<?php
namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\UserClassification;
use Illuminate\Support\Facades\Validator;

class UserClassificationController extends Controller
{
    public function getMonthlyData($user_id)
    {
        $data = DB::select("
            SELECT 
                YEAR(created_at) AS year, 
                MONTH(created_at) AS month,
                SUM(CASE WHEN stress_score = 2 THEN sampling_duration_sec ELSE 0 END) / 3600 AS focus_time, 
                SUM(CASE WHEN stress_score = 1 THEN sampling_duration_sec ELSE 0 END) / 3600 AS medium_focus_time, 
                SUM(CASE WHEN stress_score = 0 THEN sampling_duration_sec ELSE 0 END) / 3600 AS distracted_time
            FROM user_classifications
            WHERE user_id = ?
            GROUP BY YEAR(created_at), MONTH(created_at)
            ORDER BY year, month
        ", [$user_id]);

        return response()->json($data);
    }

    public function getTodayData($user_id)
    {
        $data = DB::select("
            SELECT 
                SUM(CASE WHEN stress_score = 2 THEN sampling_duration_sec ELSE 0 END) / 3600 AS focus_time, 
                SUM(CASE WHEN stress_score = 1 THEN sampling_duration_sec ELSE 0 END) / 3600 AS medium_focus_time, 
                SUM(CASE WHEN stress_score = 0 THEN sampling_duration_sec ELSE 0 END) / 3600 AS distracted_time,
                (SUM(CASE WHEN stress_score IN (1,2) THEN sampling_duration_sec ELSE 0 END) * 100.0) / 
                NULLIF(SUM(sampling_duration_sec), 0) AS effective_working_percentage
            FROM user_classifications
            WHERE user_id = ? AND DATE(created_at) = CURDATE()
        ", [$user_id]);

        return response()->json($data);
    }

    public function getWeekData($user_id)
    {
        $data = DB::select("
            SELECT 
                DAYOFWEEK(created_at) AS day_of_week, 
                SUM(CASE WHEN stress_score IN (1,2) THEN sampling_duration_sec ELSE 0 END) / 3600 AS work_load, 
                SUM(CASE WHEN stress_score = 0 THEN sampling_duration_sec ELSE 0 END) / 3600 AS free_hours
            FROM user_classifications
            WHERE user_id = ? AND YEARWEEK(created_at) = YEARWEEK(CURDATE())
            GROUP BY day_of_week
            ORDER BY day_of_week
        ", [$user_id]);

        return response()->json($data);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'raw_eeg' => 'nullable|array',
            'features' => 'nullable|array',
            'score' => 'required',
            'sampling_duration_sec' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }



        $userId = auth()->id(); // Or pass from request if Auth not used

        $classification = UserClassification::create([
            'user_id' => $userId,
            'raw_eeg' => json_encode($request->raw_eeg),
            'features' => json_encode($request->features),
            'sampling_duration_sec' => $request->sampling_duration_sec,
            'stress_score' => $request->score,
        ]);

        return response()->json([
            'result' => true,
            'message' => 'Classification stored successfully.',
            'data' => $classification
        ],200);
    }

    public function getMonthSummary($year, $month, $user_id)
    {
        $data = DB::select("
            SELECT 
                SUM(CASE WHEN stress_score = 2 THEN sampling_duration_sec ELSE 0 END) / 3600 AS focus_time, 
                SUM(CASE WHEN stress_score = 1 THEN sampling_duration_sec ELSE 0 END) / 3600 AS medium_focus_time, 
                SUM(CASE WHEN stress_score = 0 THEN sampling_duration_sec ELSE 0 END) / 3600 AS distracted_time,
                (SUM(CASE WHEN stress_score IN (1,2) THEN sampling_duration_sec ELSE 0 END) * 100.0) / 
                NULLIF(SUM(sampling_duration_sec), 0) AS effective_working_percentage
            FROM user_classifications
            WHERE user_id = ? AND YEAR(created_at) = ? AND MONTH(created_at) = ?
        ", [$user_id, $year, $month]);

        return response()->json($data);
    }

    public function getSpecificMonthReport($year, $month, $user_id)
    {
        $data = DB::select("
            SELECT 
                MONTH(created_at) AS month,
                DAY(created_at) AS day,
                SUM(CASE WHEN stress_score = 2 THEN sampling_duration_sec ELSE 0 END) / 3600 AS focus_time, 
                SUM(CASE WHEN stress_score = 1 THEN sampling_duration_sec ELSE 0 END) / 3600 AS medium_focus_time, 
                SUM(CASE WHEN stress_score = 0 THEN sampling_duration_sec ELSE 0 END) / 3600 AS distracted_time
            FROM user_classifications
            WHERE user_id = ? AND YEAR(created_at) = ? AND MONTH(created_at) = ?
            GROUP BY MONTH(created_at), DAY(created_at)
            ORDER BY DAY(created_at)
        ", [$user_id, $year, $month]);

        return response()->json($data);
    }

    public function getSpecificDayReport($year, $month, $day, $user_id)
    {
        $data = DB::select("
            SELECT 
                SUM(CASE WHEN stress_score = 2 THEN sampling_duration_sec ELSE 0 END) / 3600 AS total_focus_time, 
                SUM(CASE WHEN stress_score = 1 THEN sampling_duration_sec ELSE 0 END) / 3600 AS total_medium_focus_time, 
                SUM(CASE WHEN stress_score = 0 THEN sampling_duration_sec ELSE 0 END) / 3600 AS total_distracted_time,
                (SUM(CASE WHEN stress_score IN (1,2) THEN sampling_duration_sec ELSE 0 END) * 100.0) / 
                NULLIF(SUM(sampling_duration_sec), 0) AS effective_working_percentage
            FROM user_classifications
            WHERE user_id = ? AND YEAR(created_at) = ? AND MONTH(created_at) = ? AND DAY(created_at) = ?
        ", [$user_id, $year, $month, $day]);

        return response()->json($data[0] ?? []);
    }


    public function allUserStats()
    {
        $user=auth()->user();
        if($user->is_admin!=1) 
        {
            return response()->json([
                'result' => false,
                'error' => 'Unauthorized',
                'message' => 'You do not have permission to access this resource.'
            ], 403);
        }


        try {
            $results = DB::select("
                SELECT 
                    users.id AS user_id,
                    users.name,

                    COALESCE(SUM(CASE WHEN uc.stress_score = 2 THEN uc.sampling_duration_sec ELSE 0 END) / 3600, 0) AS focus_time,
                    COALESCE(SUM(CASE WHEN uc.stress_score = 1 THEN uc.sampling_duration_sec ELSE 0 END) / 3600, 0) AS medium_focus_time,
                    COALESCE(SUM(CASE WHEN uc.stress_score = 0 THEN uc.sampling_duration_sec ELSE 0 END) / 3600, 0) AS distracted_time,

                    COALESCE(
                        (
                            SUM(CASE WHEN uc.stress_score IN (1, 2) THEN uc.sampling_duration_sec ELSE 0 END) * 100.0
                        ) /
                        NULLIF(SUM(CASE WHEN uc.stress_score IN (0, 1, 2) THEN uc.sampling_duration_sec ELSE 0 END), 0),
                        0
                    ) AS effective_working_percentage,

                    CASE 
                        WHEN TIMESTAMPDIFF(SECOND, MAX(uc.created_at), NOW()) <= 6 THEN 1
                        ELSE 0
                    END AS is_active,
                    TIMESTAMPDIFF(SECOND, MAX(uc.created_at), NOW()) AS last_active_diff_sec

                FROM users
                LEFT JOIN user_classifications uc 
                    ON users.id = uc.user_id AND DATE(uc.created_at) = CURDATE()

                WHERE users.is_admin = 0

                GROUP BY users.id, users.name
            ");


            return response()->json([
                'result' => true,
                'message' => 'success',
                'data' => $results,
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'result' => false,
                'error' => 'Error fetching user stats',
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}
