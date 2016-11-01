
var obj=null;
var As=document.getElementById('classify').getElementsByTagName('option');
obj = As[0];
for(i=1;i<As.length;i++){if(window.location.href.indexOf(As[i].href)>=0)
obj=As[i];}
obj.selected='selected'