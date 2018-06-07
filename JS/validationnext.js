
function check()
{
var dag=document.getElementById('dag').value;
var mou=document.getElementById('mou').value;
var jl=document.getElementById('jl').value;
var karbo=document.getElementById('karbo').value;
var land=document.getElementById('land').value;
var landvalue=document.getElementById('landvalue').value;
if(dag.length==0)
{
alert("Please Enter the Dag No.!!!!");
document.getElementById('dag').focus();
return false;
}
if(mou.length==0)
{
alert("Please Enter the Mouja No.!!!!");
document.getElementById('mou').focus();
return false;
}
if(jl.length==0)
{
alert("Please Enter the JL No.!!!!");
document.getElementById('jl').focus();
return false;
}
if(karbo.length==0)
{

alert("Please Enter the Karbonama value.!!!!");
document.getElementById('karbo').focus();
return false;
}
if(land.length==0)
{
alert("Please Enter the Land Area No.!!!!");
document.getElementById('land').focus();
return false;

}
if(landvalue.length==0)
{
alert("Please Enter the amount Land Value.!!!!");
document.getElementById('landvalue').focus();
return false;

}
}


