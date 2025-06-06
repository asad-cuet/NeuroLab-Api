<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
  
        <title>Implement Social Share Button in Laravel - ItSolutionStuff.com</title>
          
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/>
        <style>
            .social-btn-sp #social-links {
                margin: 0 auto;
                max-width: 500px;
            }
            .social-btn-sp #social-links ul li {
                display: inline-block;
            }          
            .social-btn-sp #social-links ul li a {
                padding: 15px;
                border: 1px solid #ccc;
                margin: 1px;
                font-size: 30px;
            }
            table #social-links{
                display: inline-table;
            }
            table #social-links ul li{
                display: inline;
            }
            table #social-links ul li a{
                padding: 5px;
                border: 1px solid #ccc;
                margin: 1px;
                font-size: 15px;
                background: #e3e3ea;
            }
        </style>
  
    </head>
    <body>
        <div class="container mt-4">
            <h2 class="mb-5 text-center">Details of Contents</h2>
  
        <p>{{$upload->title}}</p>
        <p><img src="{{asset($upload->name)}}" alt=""></p>
  
 
        </div>
    </body>
</html>