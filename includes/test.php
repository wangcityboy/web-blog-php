<html>

<head>

 <title>Untitled</title>
 
	 <style type="text/css">
	    .div {
	        background:url(http://avatar.profile.csdn.net/F/4/D/2_im2web.jpg) no-repeat;
	        width:300px;
	        height:200px;
	    }
	 </style>   
	  
</head>


<body>

<div class="div"> </div>
<div class="div"> </div>

<input type="button" value="修改背景" id="btnModify"/>

</body>

<script type="text/javascript">
var g=function(id) {return document.getElementById(id)};

var Style={
    ss:document.styleSheets[0],
    insertRule: function(selector,styles) {
        var n=(this.ss.cssRules?this.ss.cssRules:this.ss.rules).length;
        if (this.ss.insertRule)   // Try the W3C API first
            this.ss.insertRule(selector + "{" + styles + "}", n);
        else if (this.ss.addRule) // Otherwise use the IE API
            this.ss.addRule(selector, styles, n);
    }
};

g("btnModify").onclick=function() {
    var img="http://avatar.profile.csdn.net/6/D/1/2_sohighthesky.jpg";
    Style.insertRule(".div","background-image:url("+img+")");
}

</script>
</html>


