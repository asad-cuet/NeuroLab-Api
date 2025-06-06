<?php
namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserClassificationController extends Controller
{
    public function getMonthlyData()
    {
        $user_id= auth()->id();
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

    public function getTodayData()
    {
        $user_id= auth()->id();
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

    public function getWeekData()
    {
        $user_id= auth()->id();
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

    public function addClassification(Request $request)
    {
        $request->validate([
            'stress_score' => 'required|integer',
            'user_id' => 'required|integer',
            'features' => 'required|array'
        ]);

        $result = DB::insert("
            INSERT INTO user_classifications (stress_score, user_id, features) VALUES (?, ?, ?)
        ", [
            $request->stress_score,
            $request->user_id,
            json_encode($request->features)
        ]);

        return response()->json(['success' => $result]);
    }

    public function getMonthSummary($year, $month)
    {
        $user_id= auth()->id();
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

    public function getSpecificMonthReport($year, $month)
    {
        $user_id= auth()->id();
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

    public function getSpecificDayReport($year, $month, $day)
    {
        $user_id= auth()->id();
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
}
