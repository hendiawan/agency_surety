<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Laravel') }}</title>

    <link rel="apple-touch-icon" sizes="144x144" href="apple-touch-icon-ipad-retina.png" />
    <link rel="apple-touch-icon" sizes="114x114" href="apple-touch-icon-iphone-retina.png" />
    <link rel="apple-touch-icon" sizes="72x72" href="apple-touch-icon-ipad.png" />
    <link rel="apple-touch-icon" sizes="57x57" href="apple-touch-icon-iphone.png" />
    <link rel="shortcut icon" type="image/x-icon" href="favicon.ico" />

    <!-- bootstrap -->
    <link href="/css/bootstrap-3.3.7/css/bootstrap.css" rel="stylesheet" />
    
    <link rel="stylesheet" href="/css/font-awesome-4.7/css/font-awesome.min.css">
    <link href="/main-attr/style.css" rel="stylesheet" type="text/css" />

    
</head>
<body>
    <!-- count particles -->
    <div class="count-particles">
      <span class="js-count-particles">--</span> particles
    </div>

    <!-- particles.js container -->
    <div id="particles-js"></div>
    <div id="topMain">
        <div id="topBarMain">
            <div class="pad20">
                <a class="logoMain" href="{{ url('/') }}">
                    <img src="images/logo-main.png" rel="logo">
                </a>
                <p align="right" class="address"><strong>PT JAMKRIDA NTB BERSAING</strong><br/>Jl. Langko No. 63, Mataram - Nusa Tenggara Barat<br/>
                Tlp.: (0370) 639304, 639305, Fax: 639307</p>
            </div>
        </div> <!-- /topBar -->
        
    </div> <!-- /top -->
    
    <a href="{{ url('/login') }}" class="hexagon hexa-widget aqua ttip hex-error" data-ttip="Come back home..."><i class="fa fa-power-off"></i></a>

    <script type="text/javascript" src="/main-attr/particles.min.js"></script>
    <script type="text/javascript" src="/main-attr/app.js"></script>
    <script type="text/javascript" src="/main-attr/stats.js"></script>
    <script>
      var count_particles, stats, update;
      stats = new Stats;
      stats.setMode(0);
      stats.domElement.style.position = 'absolute';
      stats.domElement.style.left = '0px';
      stats.domElement.style.top = '0px';
      document.body.appendChild(stats.domElement);
      count_particles = document.querySelector('.js-count-particles');
      update = function() {
        stats.begin();
        stats.end();
        if (window.pJSDom[0].pJS.particles && window.pJSDom[0].pJS.particles.array) {
          count_particles.innerText = window.pJSDom[0].pJS.particles.array.length;
        }
        requestAnimationFrame(update);
      };
      requestAnimationFrame(update);
    </script>
    
</body>
</html>