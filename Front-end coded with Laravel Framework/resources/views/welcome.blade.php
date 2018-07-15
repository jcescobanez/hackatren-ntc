<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="csrf-token" content="{{ csrf_token() }}">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

<style>
body {
    background-image: url({{asset('images/bg_station.jpg')}});
    background-repeat: no-repeat;

background-size: cover;
}
.slidecontainer {
    width: 100%;
}

.slider {
    -webkit-appearance: none;
    width: 100%;
    height: 15px;
    border-radius: 5px;
    background: #d3d3d3;
    outline: none;
opacity:1;
    -webkit-transition: .2s;
    transition: opacity .2s;

  }

.slider:hover {
    opacity: 1;
}

.slider::-webkit-slider-thumb {
    -webkit-appearance: none;
    appearance: none;
    width: 60px;
    height: 60px;
    border-radius: 50%;
    background-image: url({{asset('images/tren.png')}});
    background-repeat: no-repeat;
    background-position: center;
    cursor: pointer;
    -webkit-animation-timing-function: linear;
    animation: move 5s linear infinite;
    animation-timing-function: linear;
}

@keyframes move{

    0%{
        transform:translate(0);
    }

    50%{
        transform:translate(1100px);
    }
    100%{
    }
}

.slider::-moz-range-thumb {
    width: 25px;
    height: 25px;
    border-radius: 50%;
    background: #4CAF50;
    cursor: pointer;

}

input[type=range] {
  height: 50px;
  background-color: rgba(0,0,0,0);
margin-top:380px;

}

</style>

</head>
<body>
  <p class="text-primary">Arriving at <span id="appstation">{{asset('images/tren.png')}}</span></p>

<div class="container-fluid second" style="margin-top:-20px;">
  <input type="range" min="1" max="240" value="1" class="slider" id="myRange" autofocus>
</div>

</body>
<script>
var slider = document.getElementById("myRange");
var station = document.getElementById("appstation");

slider.oninput = function() {

  if(slider.value == 10) {
    station.innerHTML = "Baclaran Station...";
  } else if(slider.value == 22) {
    station.innerHTML = "EDSA Station...";
  } else if(slider.value == 34) {
    station.innerHTML = "Libertad Station...";
  } else if(slider.value == 46) {
    station.innerHTML = "Gil Puyat Station...";
  } else if(slider.value == 58) {
    station.innerHTML = "Vito Cruz Station...";
  } else if(slider.value == 70) {
    station.innerHTML = "Quirino Station...";
  } else if(slider.value == 82) {
    station.innerHTML = "Pedro Gil Station...";
  } else if(slider.value == 94) {
    station.innerHTML = "U.N Avenue Station...";
  } else if(slider.value == 106) {
    station.innerHTML = "Central Station...";
  } else if(slider.value == 118) {
    station.innerHTML = "Carriedo Station...";
  } else if(slider.value == 130) {
    station.innerHTML = "Doroteo Jose Station...";
  } else if(slider.value == 142) {
    station.innerHTML = "Bambang Station...";
  } else if(slider.value == 154) {
    station.innerHTML = "Tayuman Station...";
  } else if(slider.value == 166) {
    station.innerHTML = "Blumentritt Station...";
  } else if(slider.value == 178) {
    station.innerHTML = "Abad Santos Station...";
  } else if(slider.value == 190) {
    station.innerHTML = "R. Papa Station...";
  } else if(slider.value == 202) {
    station.innerHTML = "5th Avenue Station...";
  } else if(slider.value == 214) {
    station.innerHTML = "Monumento Station...";
} else if(slider.value == 226) {
    station.innerHTML = "Balintawak Station...";
} else if(slider.value == 238) {
    station.innerHTML = "Roosevelt Station...";
  } else {
    station.innerHTML = "";
  }
}

$(document).ready(function(){

    $("#myRange").on("change", function(e){
        var name = e.target.value;
        $.get('station?station_name=' + name, function(data){
          if(data == "true") {
            console.log(data);
          }
        });
    });
});

</script>

</html>
