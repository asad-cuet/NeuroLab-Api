<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Middleware\EnsureUserIsSuperAdmin;
use Illuminate\Support\Str;

class SwaggerGeneratorController extends Controller
{
    public function __construct()
    {
        $this->middleware(EnsureUserIsSuperAdmin::class);
    }
    public function sync(Request $request)
    {
        $swaggerJson = json_decode(file_get_contents(app_path('Swagger/base.json')), true);

        $additionalJsonFiles = [
            'initial.json',
            'auth.json',
            'app-signup.json',
            'app-signin.json',
            'web-otp-signin.json',
            'web-app-reset-password.json',
            'users.json',
            'blog_categories.json',
            'blogs.json',
            'blog_comments.json',
            'pages.json',
            //MORE_FILES_HERE
        ];

        foreach ($additionalJsonFiles as $file) 
        {
            $additionalJson = json_decode(file_get_contents(app_path('Swagger/origin/'.$file)), true);
            $swaggerJson['paths'] = array_merge($swaggerJson['paths'], $additionalJson);
        }

        file_put_contents(app_path('Swagger/api-docs.json'), json_encode($swaggerJson, JSON_PRETTY_PRINT));


        return back()->with('success',"Swagger Generated");

    }

}
