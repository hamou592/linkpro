<!DOCTYPE html>
<html>
<head>
 <meta charset="UTF-8">
 <title>{{ $client->name }}</title>
 <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body class="min-h-screen bg-gray-100 flex flex-col items-center p-8">
    <h1 class="text-3xl mb-4">{{ $client->name }}</h1>
    @foreach($client->contents as $content)
      <div class="bg-white shadow rounded p-4 w-full max-w-md mb-4">
         <img src="{{ asset('storage/'.$content->logo_path) }}" class="w-20 h-20 mx-auto rounded-full">
         <p class="mt-2 text-center text-gray-600">{{ $content->phone }}</p>
         @if($content->links)
            <div class="flex justify-center gap-4 mt-4">
               @foreach($content->links as $platform => $url)
                   <a href="{{ $url }}" class="text-blue-500">{{ ucfirst($platform) }}</a>
               @endforeach
            </div>
         @endif
      </div>
    @endforeach
</body>
</html>
