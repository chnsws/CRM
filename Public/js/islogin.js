
//当打开页面后，设置三个小时后自动跳销毁cookie退出登录
setTimeout(function() {
    ToLoginPage();
}, 10800000);

function ToLoginPage()
{
    if (self.frameElement && self.frameElement.tagName == "IFRAME") 
    {
        //如果在iframe中
        window.parent.location='/index.php/Home/Index/tuichu';
    }
    else 
    {
        //不在iframe中
        window.location='/index.php/Home/Index/tuichu';
    }
}
//错误代码处理方法
function errorFun(errorstr)
{
    /*
        0:无权限
        1:没有登录
    */
    if('undefined'!=typeof layer)
    {
        if('undefined'!=typeof jiazai)
        {
            layer.close(jiazai);
        }
    }
    switch(errorstr)
    {
        case 'error:0':
            //无权限
            tishi("您当前没有此操作的权限");
            throw '没有权限';
            //window.location='/index.php/Home/Main/index';
        break;
        case 'error:1':
            //没有登录吃力方式，跳到登录页
            ToLoginPage();
        break;
    }
    
}
