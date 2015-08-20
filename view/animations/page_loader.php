<style>
#bowlG{
position:relative;
width:25px;
height:25px;
}

#bowl_ringG{
position:absolute;
width:25px;
height:25px;
border:2px solid #000000;
-moz-border-radius:25px;
-webkit-border-radius:25px;
-ms-border-radius:25px;
-o-border-radius:25px;
border-radius:25px;
}

.ball_holderG{
position:absolute;
width:7px;
height:25px;
left:9px;
top:0px;
-moz-animation-name:ball_moveG;
-moz-animation-duration:1.3s;
-moz-animation-iteration-count:infinite;
-moz-animation-timing-function:linear;
-webkit-animation-name:ball_moveG;
-webkit-animation-duration:1.3s;
-webkit-animation-iteration-count:infinite;
-webkit-animation-timing-function:linear;
-ms-animation-name:ball_moveG;
-ms-animation-duration:1.3s;
-ms-animation-iteration-count:infinite;
-ms-animation-timing-function:linear;
-o-animation-name:ball_moveG;
-o-animation-duration:1.3s;
-o-animation-iteration-count:infinite;
-o-animation-timing-function:linear;
animation-name:ball_moveG;
animation-duration:1.3s;
animation-iteration-count:infinite;
animation-timing-function:linear;
}

.ballG{
position:absolute;
left:0px;
top:-6px;
width:10px;
height:10px;
background:#FFB530;
-moz-border-radius:8px;
-webkit-border-radius:8px;
-ms-border-radius:8px;
-o-border-radius:8px;
border-radius:8px;
}

@-moz-keyframes ball_moveG{
0%{
-moz-transform:rotate(0deg)}

100%{
-moz-transform:rotate(360deg)}

}

@-webkit-keyframes ball_moveG{
0%{
-webkit-transform:rotate(0deg)}

100%{
-webkit-transform:rotate(360deg)}

}

@-ms-keyframes ball_moveG{
0%{
-ms-transform:rotate(0deg)}

100%{
-ms-transform:rotate(360deg)}

}

@-o-keyframes ball_moveG{
0%{
-o-transform:rotate(0deg)}

100%{
-o-transform:rotate(360deg)}

}

@keyframes ball_moveG{
0%{
transform:rotate(0deg)}

100%{
transform:rotate(360deg)}

}

</style>
<div id="bowlG" class="loader_bowlG" style="display:none;">
	<div id="bowl_ringG">
	<div class="ball_holderG">
	<div class="ballG">
	</div>
	</div>
	</div>
</div>