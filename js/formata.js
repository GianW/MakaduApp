/*
<input name="a" maxlength="10" type="text">
Restrição = (\\d/) Somente números e "/"<br>Máscara = ##/##/####

<input name="b" maxlength="14" type="text"><br>
Restrição = (\\d.-) Somente números, ponto e hífen<br>Máscara = ###.###.###-##

<input name="c" maxlength="14" type="text"><br>
Restrição = (\\d()- ) Somente números, ponto e hífen<br>Máscara = (##) ####-####

<textarea name="d" cols="4" rows="5" style="width: 300px; height: 120px;"></textarea><br>
Restrição = (a\\^bc) Somente os caracteres "a", "b", "c" e "^"

<script type="text/javascript">
//<![CDATA[

var r = new Restrict("form");
r.field.a = "\\d/";
r.mask.a = "##/##/####";
r.field.b = "\\d.-";
r.mask.b = "###.###.###-##";
r.field.c = "\\d()- ";
r.mask.c = "(##) ####-####";
r.field.d = "a\\^bc";

r.onKeyRefuse = function(o, k){
 o.style.backgroundColor = "#fdc";
}
r.onKeyAccept = function(o, k){
 if(k > 30)
  o.style.backgroundColor = "transparent";
}
r.start();

//]]>
</script>
*/

//funcao de eventos
addEvent = function(o, e, f, s){
  var r = o[r = "_" + (e = "on" + e)] = o[r] || (o[e] ? [[o[e], o]] : []), a, c, d;
  r[r.length] = [f, s || o], o[e] = function(e){
      try{
          (e = e || event).preventDefault || (e.preventDefault = function(){e.returnValue = false;});
          e.stopPropagation || (e.stopPropagation = function(){e.cancelBubble = true;});
          e.target || (e.target = e.srcElement || null);
          e.key = (e.which + 1 || e.keyCode + 1) - 1 || 0;
      }catch(f){}
      for(d = 1, f = r.length; f; r[--f] && (a = r[f][0], o = r[f][1], a.call ? c = a.call(o, e) : (o._ = a, c = o._(e), o._ = null), d &= c !== false));
      return e = null, !!d;
  }
};

removeEvent = function(o, e, f, s){
  for(var i = (e = o["_on" + e] || []).length; i;)
      if(e[--i] && e[i][0] == f && (s || o) == e[i][1])
          return delete e[i];
  return false;
};

//função de máscaras e restrições de digitação
Restrict = function(form){
this.form = form, this.field = {}, this.mask = {};
}
Restrict.field = Restrict.inst = Restrict.c = null;
Restrict.prototype.start = function(){
var $, __ = document.forms[this.form], s, x, j, c, sp, o = this, l;
var p = {".":/./, w:/\w/, W:/\W/, d:/\d/, D:/\D/, s:/\s/, a:/[\xc0-\xff]/, A:/[^\xc0-\xff]/};
for(var _ in $ = this.field)
 if(/text|textarea|password/i.test(__[_].type)){
  x = $[_].split(""), c = j = 0, sp, s = [[],[]];
  for(var i = 0, l = x.length; i < l; i++)
   if(x[i] == "\\" || sp){
    if(sp = !sp) continue;
    s[j][c++] = p[x[i]] || x[i];
   }
   else if(x[i] == "^") c = (j = 1) - 1;
   else s[j][c++] = x[i];
  o.mask[__[_].name] && (__[_].maxLength = o.mask[__[_].name].length);
  __[_].pt = s, addEvent(__[_], "keydown", function(e){
   var r = Restrict.field = e.target;
   if(!o.mask[r.name]) return;
   r.l = r.value.length, Restrict.inst = o; Restrict.c = e.key;
   setTimeout(o.onchanged, r.e = 1);
  });
  addEvent(__[_], "keyup", function(e){
   (Restrict.field = e.target).e = 0;
  });
  addEvent(__[_], "keypress", function(e){
   o.restrict(e) || e.preventDefault();
   var r = Restrict.field = e.target;
   if(!o.mask[r.name]) return;
   if(!r.e){
    r.l = r.value.length, Restrict.inst = o, Restrict.c = e.key || 0;
    setTimeout(o.onchanged, 1);
   }
  });
 }
}
Restrict.prototype.restrict = function(e){
var o, c = e.key, n = (o = e.target).name, r;
var has = function(c, r){
 for(var i = r.length; i--;)
  if((r[i] instanceof RegExp && r[i].test(c)) || r[i] == c) return true;
 return false;
}
var inRange = function(c){
 return has(c, o.pt[0]) && !has(c, o.pt[1]);
}
return (c < 30 || inRange(String.fromCharCode(c))) ?
 (this.onKeyAccept && this.onKeyAccept(o, c), !0) :
 (this.onKeyRefuse && this.onKeyRefuse(o, c),  !1);
}
Restrict.prototype.onchanged = function(){
var ob = Restrict, si, moz = false, o = ob.field, t, lt = (t = o.value).length, m = ob.inst.mask[o.name];
if(o.l == o.value.length) return;
if(si = o.selectionStart) moz = true;
else if(o.createTextRange){
 var obj = document.selection.createRange(), r = o.createTextRange();
 if(!r.setEndPoint) return false;
 r.setEndPoint("EndToStart", obj); si = r.text.length;
}
else return false;
for(var i in m = m.split(""))
 if(m[i] != "#")
  t = t.replace(m[i] == "\\" ? m[++i] : m[i], "");
var j = 0, h = "", l = m.length, ini = si == 1, t = t.split("");
for(i = 0; i < l; i++)
 if(m[i] != "#"){
  if(m[i] == "\\" && (h += m[++i])) continue;
  h += m[i], i + 1 == l && (t[j - 1] += h, h = "");
 }
 else{
  if(!t[j] && !(h = "")) break;
  (t[j] = h + t[j++]) && (h = "");
 }
o.value = o.maxLength > -1 && o.maxLength < (t = t.join("")).length ? t.slice(0, o.maxLength) : t;
if(ob.c && ob.c != 46 && ob.c != 8){
 if(si != lt){
  while(m[si] != "#" && m[si]) si++;
  ini && m[0] != "#" && si++;
 }
 else si = o.value.length;
}
!moz ? (obj.move("character", si), obj.select()) : o.setSelectionRange(si, si);
}


function FormataValor(id,tammax,teclapres) {
    
	if(window.event) { 
		// Internet Explorer
		var tecla = teclapres.keyCode; 
	}else if(teclapres.which) {
		// Nestcape / firefox
		var tecla = teclapres.which;
	}
		
	if (tecla < 48 || tecla > 57){
		event.returnValue = false;                
		return false;
	}
	
	vr = document.getElementById(id).value;
	vr = vr.toString().replace( "/", "" );
	vr = vr.toString().replace( "/", "" );
	vr = vr.toString().replace( ",", "" );
	vr = vr.toString().replace( ".", "" );
	vr = vr.toString().replace( ".", "" );
	vr = vr.toString().replace( ".", "" );
	vr = vr.toString().replace( ".", "" );
	tam = vr.length;
	
	if (tam < tammax && tecla != 8){ 
		tam = vr.length + 1; 
	}
	
	if (tecla == 8 ){ 
		tam = tam - 1; 
	}
	
	if ( tecla == 8 || tecla >= 48 && tecla <= 57 || tecla >= 96 && tecla <= 105 ){
		if ( tam <= 2 ){
			document.getElementById(id).value = vr; 
		}
		
		if ( (tam > 2) && (tam <= 5) ){
			document.getElementById(id).value = vr.substr( 0, tam - 2 ) + ',' + vr.substr( tam - 2, tam ); 
		}
		
		if ( (tam >= 6) && (tam <= 8) ){
			document.getElementById(id).value = vr.substr( 0, tam - 5 ) + vr.substr( tam - 5, 3 ) + ',' + vr.substr( tam - 2, tam ); 
		}
		
		if ( (tam >= 9) && (tam <= 11) ){
			document.getElementById(id).value = vr.substr( 0, tam - 8 ) + vr.substr( tam - 8, 3 ) + vr.substr( tam - 5, 3 ) + ',' + vr.substr( tam - 2, tam );
		}
		
		if ( (tam >= 12) && (tam <= 14) ){
			document.getElementById(id).value = vr.substr( 0, tam - 11 ) + vr.substr( tam - 11, 3 ) + vr.substr( tam - 8, 3 ) + vr.substr( tam - 5, 3 ) + ',' + vr.substr( tam - 2, tam ); 
		}
		
		if ( (tam >= 15) && (tam <= 17) ){
			document.getElementById(id).value = vr.substr( 0, tam - 14 ) + vr.substr( tam - 14, 3 ) +vr.substr( tam - 11, 3 ) + vr.substr( tam - 8, 3 ) + vr.substr( tam - 5, 3 ) + ',' + vr.substr( tam - 2, tam );
		}
	}
	
	return true;
}