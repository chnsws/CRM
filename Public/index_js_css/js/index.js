/** index.js By Beginner Emain:zheng_jinfan@126.com HomePage:http://www.zhengjinfan.cn */


function lock($, layer) {
	//自定页
	layer.open({
		title: false,
		type: 1,
		closeBtn: 0,
		anim: 6,
		content: $('#lock-temp').html(),
		shade: [0.9, '#393D49'],
		success: function(layero, lockIndex) {

			//给显示用户名赋值
			layero.find('div#lockUserName').text('admin');
			layero.find('input[name=lockPwd]').on('focus', function() {
					var $this = $(this);
					if($this.val() === '输入密码解锁..') {
						$this.val('').attr('type', 'password');
					}
				})
				.on('blur', function() {
					var $this = $(this);
					if($this.val() === '' || $this.length === 0) {
						$this.attr('type', 'text').val('输入密码解锁..');
					}
				});
			//在此处可以写一个请求到服务端删除相关身份认证，因为考虑到如果浏览器被强制刷新的时候，身份验证还存在的情况			
			//do something...
			//e.g. 
			/*
			 $.post(url,params,callback,'json');
			 */
			//绑定解锁按钮的点击事件
			layero.find('button#unlock').on('click', function() {
				var $lockBox = $('div#lock-box');

				var userName = $lockBox.find('div#lockUserName').text();
				var pwd = $lockBox.find('input[name=lockPwd]').val();
				if(pwd === '输入密码解锁..' || pwd.length === 0) {
					layer.msg('请输入密码..', {
						icon: 2,
						time: 1000
					});
					return;
				}
				unlock(userName, pwd);
			});
			/**
			 * 解锁操作方法
			 * @param {String} 用户名
			 * @param {String} 密码
			 */
			var unlock = function(un, pwd) {
				//这里可以使用ajax方法解锁
				/*$.post('api/xx',{username:un,password:pwd}},function(data){
				 	//验证成功
					if(data.success){
						//关闭锁屏层
						layer.close(lockIndex);
					}else{
						layer.msg('密码输入错误..',{icon:2,time:1000});
					}					
				},'json');
				*/

				//演示：默认输入密码都算成功
				//关闭锁屏层
				layer.close(lockIndex);
			};
		}
	});
};
