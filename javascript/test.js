function add(a,b)
{
    console.log(a+b);
}
function sub(a,b)
{
    console.log(a-b);
}
add.call(sub,3,1);

function Class1()
{
    this.name = "class1";
    this.showNam = function()
    {
        console.log(this.name);
}
}
function Class2()
{
    this.name = "class2";
}
var c1 = new Class1();
var c2 = new Class2();
c1.showNam.call(c2);

function Class1()
{
    this.showTxt = function(txt)
    {
        console.log(txt);
    }
}
function Class2()
{
    Class1.call(this);
}
var c2 = new Class2();
c2.showTxt("cc");
console.log(c2.prototype.toString());

