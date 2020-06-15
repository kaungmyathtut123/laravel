<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>
    <h1>Welcome</h1>
    @if(session('status'))
        {{session('status')}}
    @endif
    <br>
    <a href="{{url('setSingle')}}">
      <button>Set Single Session</button>
    </a>
    <a href="{{url('getSingle')}}">
        <button>Get Single Session</button>
    </a>
    <a href="{{url('setMultiple')}}">
        <button>Set Multple Session</button>
    </a>
    <br><br>
    <a href="{{'deleteSes'}}">
      <button>Delete All Session</button>
    </a>
  </body>
</html>
