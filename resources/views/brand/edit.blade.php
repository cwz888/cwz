<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 13px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }
        </style>
    </head>
    <body>
            <div class="content">
                <form action="/brand/update/{{$data->brand_id}}" method="post" enctype="multipart/form-data">
                @if ($errors->any())
                 <div class="alert alert-danger">
                 <ul>
                 @foreach ($errors->all() as $error)
                 <li>{{ $error }}</li>
                 @endforeach
                 </ul>
                 </div>
                @endif
                @csrf
                    <table>
                        <tr>
                            <td>品牌名称</td>
                            <td><input type="text" name="brand_name" value="{{$data->brand_name}}"></td>
                        </tr>
                        <tr>
                            <td>品牌描述</td>
                            <td><textarea name="brand_desc" cols="20" rows="2">{{$data->brand_desc}}</textarea></td>
                        </tr>
                        <tr>
                            <td>品牌logo</td>
                            <td><input type="file" name="brand_logo"><img src="{{config('app.img_url')}}{{$data->brand_logo}}" width="50"></td>
                        </tr>
                        <tr>
                            <td>品牌网址</td>
                            <td><input type="text" name="brand_url" value="{{$data->brand_url}}"></td>
                        </tr>
                        <input type="hidden" name="brand_id" value="{{$data->brand_id}}">
                        <tr>
                            <td colspan="2"><button>修改</button></td>
                        </tr>
                    </table>
                </form>
            </div>
        </div>
    </body>
</html>
