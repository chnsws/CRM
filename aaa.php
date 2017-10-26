<!DOCTYPE html>
<html xmlns:wb="http://open.weibo.com/wb">
<head>
	<title></title>
	<meta charset="UTF-8">
	<script src="http://tjs.sjs.sinajs.cn/open/api/js/wb.js" type="text/javascript" charset="utf-8"></script>
	<script type="text/javascript"> 
(function(){
var p = {
url:'',
to:'pengyou',
desc:'',/*默认分享理由(可选)*/
summary:document.title ,/*摘要(可选)*/
title:'',/*分享标题(可选)*/
site:'',/*分享来源 如：腾讯网(可选)*/
pics:'' /*分享图片的路径(可选)*/
};
var s = [];
for(var i in p){
s.push(i + '=' + encodeURIComponent(p[i]||''));
}
(function(){
var p = {
url:location.href,
to:'pengyou',
desc:document.title ,/*默认分享理由(可选)*/
summary:document.title ,/*摘要(可选)*/
title:document.title ,/*分享标题(可选)*/
site:'',/*分享来源 如：腾讯网(可选)*/
pics:'' /*分享图片的路径(可选)*/
};
var s = [];
for(var i in p){
s.push(i + '=' + encodeURIComponent(p[i]||''));
}
document.write(['<a href="http://sns.qzone.qq.com/cgi-bin/qzshare/cgi_qzshare_onekey?',s.join('&'),'" target="_blank" title="分享到腾讯朋友">腾讯朋友</a>'].join(''));
})();
(function(){
var p = {
url:location.href,
desc:document.title ,/*默认分享理由(可选)*/
summary:document.title,/*摘要(可选)*/
title:document.title,/*分享标题(可选)*/
site:'',/*分享来源 如：腾讯网(可选)*/
pics:'' /*分享图片的路径(可选)*/
};
var s = [];
for(var i in p){
s.push(i + '=' + encodeURIComponent(p[i]||''));
}
document.write(['<a href="http://sns.qzone.qq.com/cgi-bin/qzshare/cgi_qzshare_onekey?',s.join('&'),'" target="_blank" title="分享到QQ空间">QQ空间</a>'].join(''));
})();

function weixinAddContact(name){
	WeixinJSBridge.invoke("addContact", {webtype: "1",username: name}, function(e) {
		WeixinJSBridge.log(e.err_msg);
		//e.err_msg:add_contact:added 已经添加
		//e.err_msg:add_contact:cancel 取消添加
		//e.err_msg:add_contact:ok 添加成功
		if(e.err_msg == 'add_contact:added' || e.err_msg == 'add_contact:ok'){
		    //关注成功，或者已经关注过
		}
	})
	alert("aaaaa")
}

</script>
</head>
<body>
	<a href="http://sns.qzone.qq.com/cgi-bin/qzshare/cgi_qzshare_onekey?url=http://fj.qq.com/news/wm/wm019.htm&amp;to=pengyou&amp;desc=%E6%88%91%E4%BB%AC_%E8%85%BE%E8%AE%AF%E5%A4%A7%E9%97%BD%E7%BD%91%E5%BD%B1%E5%83%8F%E7%BA%AA%E5%AE%9E%E6%A0%8F%E7%9B%AE_%E8%85%BE%E8%AE%AF%E7%BD%91&amp;summary=%E6%88%91%E4%BB%AC_%E8%85%BE%E8%AE%AF%E5%A4%A7%E9%97%BD%E7%BD%91%E5%BD%B1%E5%83%8F%E7%BA%AA%E5%AE%9E%E6%A0%8F%E7%9B%AE_%E8%85%BE%E8%AE%AF%E7%BD%91&amp;title=%E6%88%91%E4%BB%AC_%E8%85%BE%E8%AE%AF%E5%A4%A7%E9%97%BD%E7%BD%91%E5%BD%B1%E5%83%8F%E7%BA%AA%E5%AE%9E%E6%A0%8F%E7%9B%AE_%E8%85%BE%E8%AE%AF%E7%BD%91&amp;site=&amp;pics=" target="_blank" title="分享到腾讯朋友">腾讯朋友</a>
	<a href="http://sns.qzone.qq.com/cgi-bin/qzshare/cgi_qzshare_onekey?url=http%3A%2F%2Ffj.qq.com%2Fnews%2Fwm%2Fwm019.htm&amp;desc=%E6%88%91%E4%BB%AC_%E8%85%BE%E8%AE%AF%E5%A4%A7%E9%97%BD%E7%BD%91%E5%BD%B1%E5%83%8F%E7%BA%AA%E5%AE%9E%E6%A0%8F%E7%9B%AE_%E8%85%BE%E8%AE%AF%E7%BD%91&amp;summary=%E6%88%91%E4%BB%AC_%E8%85%BE%E8%AE%AF%E5%A4%A7%E9%97%BD%E7%BD%91%E5%BD%B1%E5%83%8F%E7%BA%AA%E5%AE%9E%E6%A0%8F%E7%9B%AE_%E8%85%BE%E8%AE%AF%E7%BD%91&amp;title=%E6%88%91%E4%BB%AC_%E8%85%BE%E8%AE%AF%E5%A4%A7%E9%97%BD%E7%BD%91%E5%BD%B1%E5%83%8F%E7%BA%AA%E5%AE%9E%E6%A0%8F%E7%9B%AE_%E8%85%BE%E8%AE%AF%E7%BD%91&amp;site=&amp;pics=" target="_blank" title="分享到QQ空间">QQ空间1</a>

	<wb:share-button addition="number" type="button" ralateUid="3183319544"></wb:share-button>

	<div class="bdsharebuttonbox">
    <a href="#" class="bds_more" data-cmd="more">
    </a>
    <a href="#" class="bds_qzone" data-cmd="qzone">
    </a>
    <a href="#" class="bds_tsina" data-cmd="tsina">
    </a>
    <a href="#" class="bds_tqq" data-cmd="tqq">
    </a>
    <a href="#" class="bds_renren" data-cmd="renren">
    </a>
    <a href="#" class="bds_weixin" data-cmd="weixin">
    </a>
</div>
</body>
</html>