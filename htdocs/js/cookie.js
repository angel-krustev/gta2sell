/* Storing & retrieving form fields in a JSON cookie 
 * copyright Will Bradley, 2012, released under a CC-BY license
 * 
 * Change all instances of formName as necessary.
 * Cookie will be stored under the current URL, but
 * it won't include any hidden fields, etc.
 */

function setCookie(c_name,value,expireminutes)
{
   var exdate=new Date();
   exdate.setMinutes(exdate.getMinutes()+expireminutes);
   document.cookie=c_name+ "=" +escape(value)+";path=/"+
   ((expireminutes==null) ? "" : ";expires="+exdate.toUTCString());
}

function deleteCookie( name ) {
  document.cookie = name + '=;path=/; expires=Thu, 01 Jan 1970 00:00:01 GMT;';
}

function getCookie(c_name)
{
if (document.cookie.length>0)
  {
  c_start=document.cookie.indexOf(c_name + "=");
  if (c_start!=-1)
    {
    c_start=c_start + c_name.length+1;
    c_end=document.cookie.indexOf(";",c_start);
    if (c_end==-1) c_end=document.cookie.length;
    return unescape(document.cookie.substring(c_start,c_end));
    }
  }
return "";
}

function getInputValue(formName,fieldName,def) {
  // load values from cookie
  var cookie = getCookie(formName);
  var result = def;
  if(cookie.length > 10){
    var retval = JSON.parse(cookie);
    for(var i=0;i<retval.length;i++) {
      var obj = retval[i];
      for(var key in obj){
        //console.warn(key+": "+obj[key]);
        if( key == fieldName){
            result = obj[key];
        }
      }
    }
  }
//  result = result.replace(/,/g , "");
//  result = result.replace(/$/g,""); 
  return result;
}


function onSubmit(formName,ttl)
{
  var form=document.getElementById(formName);
  var json = [];
  //alert(formName+" "+form.length);
  // Loop through all the form elements
  for (var i=0;i<form.length;i++) {
  if (form.elements[i].name &&  form.elements[i].name == 'at' ) { continue; }
    if (form.elements[i].name && (form.elements[i].checked
      || /select|textarea/i.test(form.elements[i].nodeName)
      || /text|password|hidden/i.test(form.elements[i].type))) {
      var entry = {};
      entry[form.elements[i].name] = form.elements[i].value;
      json.push(entry);
   //  console.warn(formName+" Submit :" +form.elements[i].name +":"+ form.elements[i].value);
    }
  }
  setCookie(formName,JSON.stringify(json),ttl);
  //alert(JSON.stringify(json));

}

function onLoad(formName) {
  // load values from cookie
  var cookie = getCookie(formName);
  var form=document.getElementById(formName);
  if(cookie.length > 10){
    var retval = JSON.parse(cookie);
    for(var i=0;i<retval.length;i++) {
      var obj = retval[i];
      for(var key in obj){
         if( form.elements[key] != null && key != null  ){ 
          form.elements[key].value = obj[key];
    // console.warn(formName+" Load:"+form.elements[i].value +":"+ obj[key]);
         }
      }
    }
  }
  setFields(formName);
}

function setFields(formName) {
  var form=document.getElementById(formName);
  if(form != null){
  for (var i=0;i<form.length;i++) {
    if (form.elements[i].name &&  form.elements[i].name == 'at' ) { continue; }
    if (form.elements[i].name ) {
         jQuery("#span-"+form.elements[i].name).html( $("#"+form.elements[i].name+" option:selected").text() );
    }
  }
  }
}

 function setAction(formName, sfx) {
  var form=document.getElementById(formName);
        form.action = form.action+sfx;
        //alert(form.action);
 }
