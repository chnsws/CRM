//黑色半透明提示
function tishi(neirong)
{
    layer.msg(neirong, {
        time: 2000, 
        color:"#fff"
    });
}
function loading()
{
    var obj=layer.msg('正在加载', {
        icon: 16,
        shade:0.01,
        area:'100px',
        time:99999999
    });
    return obj;
}
function loadingtip(tip,wid)
{
    var obj=layer.msg(tip, {
        icon: 16,
        shade:0.01,
        area:wid,
        time:99999999
    });
    return obj;
}