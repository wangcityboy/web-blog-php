function GoatYear(){
  this.identity = "GOATYEAR_IDENTITY22";
  this.id = "goatyear";
  this.cls = "active";
  this.init();
}

GoatYear.prototype.init = function(){
  var _s = this;
  if(this.isSupport() && !this.showed()){
    //动画模版
    this.html = '<div id="goatyear" class="goatyear">'+
      '<div class="title"></div>'+
      '<div class="fireworks"></div>'+
    '</div>';
    this.bodyDom = document.body;
    
    //将动画插入到页面中
    this.bodyDom.appendChild(this.str2dom(this.html));
    
    //等待页面加载完成
    this.bodyDom.onload = function(){
      _s.show();
    };
  }
};

/*
  显示动画
*/
GoatYear.prototype.show = function(){
  var _s = this;
  //记录显示历史
  localStorage.setItem(this.identity, "1");
  //显示
  this.addClass(document.getElementById(this.id),this.cls);
  //15秒后自动关闭
  setTimeout(function(){
    _s.hide();
  },15000);
  
};

/*
  隐藏动画
*/
GoatYear.prototype.hide = function(){
  this.bodyDom.removeChild(document.getElementById(this.id));
};

/*
  在dom元素上添加指定的class
*/
GoatYear.prototype.addClass = function(dom, cls){
  dom.className = dom.className + " " + cls;
};

/*
  将字符串转换成dom对象
  适用于字符串中只有一个父节点的情况
*/
GoatYear.prototype.str2dom = function(str){
  var div = document.createElement("div");
  
  div.innerHTML = str;
  
  return div.firstChild.cloneNode(true);
};

/*
  判断浏览器是否支持本动画
*/
GoatYear.prototype.isSupport = function(){
  return typeof(Worker) !== "undefined";
};

/*
  是否显示过此动画
*/
GoatYear.prototype.showed = function(){
  return localStorage.getItem(this.identity) && true;
};




